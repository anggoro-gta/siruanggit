<?= $this->extend('layouts/template_opd'); ?>

<?= $this->section('csskhusus'); ?>
<style>
    #timeline-list .timeline-item {
        position: relative;
        margin-bottom: 1.25rem !important;
        padding: .15rem 0 1rem .9rem;
        border-left-width: 2px !important;
    }

    #timeline-list {
        max-height: 530px;
        overflow-y: auto;
        overflow-x: hidden;
        padding-right: .65rem;
        scrollbar-width: thin;
        scrollbar-color: #c5ccd5 transparent;
    }

    #timeline-list::-webkit-scrollbar {
        width: 6px;
    }

    #timeline-list::-webkit-scrollbar-thumb {
        background: #c5ccd5;
        border-radius: 10px;
    }

    #timeline-list::-webkit-scrollbar-track {
        background: transparent;
    }

    #timeline-list .timeline-row {
        display: flex;
        align-items: flex-start;
        gap: .65rem;
    }

    #timeline-list .timeline-icon {
        flex: 0 0 20px;
        width: 20px;
        color: #697a8d;
        font-size: 1.1rem;
        line-height: 1.35;
        text-align: center;
    }

    #timeline-list .timeline-text {
        min-width: 0;
        line-height: 1.5;
        overflow-wrap: break-word;
    }

    #timeline-list .timeline-text > div {
        white-space: normal;
    }

    #timeline-list .timeline-date {
        color: #697a8d;
        font-size: .9rem;
        font-weight: 500;
    }

    #timeline-list .timeline-title {
        color: #566a7f;
        font-size: .95rem;
        font-weight: 600;
    }

    #timeline-list .timeline-room {
        color: #9aa7b5;
        font-size: .82rem;
        margin-top: .15rem;
    }

    #timeline-range {
        font-size: .78rem;
        line-height: 1.4;
    }

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
</style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<?php $errors = session('errors') ?? []; ?>
<?php
$now = date('Y-m-d\TH:i');
?>
<!-- Content Wrapper. Contains page content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title"><?= $title ?></h5>
                    </div>
                    <a href="<?= base_url('peminjaman-ruang-opd'); ?>" class="btn btn-secondary">
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
                        <input type="hidden" class="form-control" name="kode_dinas" id="kode_dinas" value="<?= $kode_dinas ?>">
                        <div class="mb-4 row">
                            <label for="namaorganisasi" class="col-md-3 col-form-label">Nama Organisasi <sup class="text-danger">*</sup></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control <?= isset($errors['namaorganisasi']) ? 'is-invalid' : '' ?>" id="namaorganisasi" name="namaorganisasi" readonly value="<?= esc(old('namaorganisasi', $namaorganisasi ?? '')) ?>">
                                <?php if (isset($errors['namaorganisasi'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['namaorganisasi']) ?></div><?php endif; ?>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="namapeminjam" class="col-md-3 col-form-label">Nama Peminjam <sup class="text-danger">*</sup></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control <?= isset($errors['namapeminjam']) ? 'is-invalid' : '' ?>" id="namapeminjam" name="namapeminjam" required value="<?= esc(old('namapeminjam', $namapeminjam ?? '')) ?>">
                                <?php if (isset($errors['namapeminjam'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['namapeminjam']) ?></div><?php endif; ?>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="nohp" class="col-md-3 col-form-label">No. HP <sup class="text-danger">*</sup></label>
                            <div class="col-md-9">
                                <input type="number" class="form-control <?= isset($errors['nohp']) ? 'is-invalid' : '' ?>" id="nohp" name="nohp" required value="<?= esc(old('nohp', $nohp ?? '')) ?>">
                                <?php if (isset($errors['nohp'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['nohp']) ?></div><?php endif; ?>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="acara" class="col-md-3 col-form-label">Acara</label>
                            <div class="col-md-9">
                                <textarea class="form-control <?= isset($errors['acara']) ? 'is-invalid' : '' ?>" id="acara" name="acara"><?= esc(old('acara', $acara ?? '')) ?></textarea>
                                <?php if (isset($errors['acara'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['acara']) ?></div><?php endif; ?>
                            </div>
                        </div>
                        <div class="mb-4 row align-items-start">
                            <label for="tgljamacaramulai" class="col-md-3 col-form-label">
                                Tanggal Acara <sup class="text-danger">*</sup>
                            </label>

                            <div class="col-md-4">
                                <input
                                    type="datetime-local"
                                    class="form-control <?= isset($errors['tgljamacaramulai']) ? 'is-invalid' : '' ?>"
                                    id="tgljamacaramulai"
                                    name="tgljamacaramulai"
                                    min="<?= $now ?>"
                                    required
                                    value="<?= esc(old('tgljamacaramulai', $tgljamacaramulai ?? '')) ?>"
                                >

                                <?php if (isset($errors['tgljamacaramulai'])) : ?>
                                    <div class="invalid-feedback d-block">
                                        <?= esc($errors['tgljamacaramulai']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-1 d-flex justify-content-center align-items-center pt-md-2">
                                <span>s.d.</span>
                            </div>

                            <div class="col-md-4">
                                <input
                                    type="datetime-local"
                                    class="form-control <?= isset($errors['tgljamacaraselesai']) ? 'is-invalid' : '' ?>"
                                    id="tgljamacaraselesai"
                                    name="tgljamacaraselesai"
                                    required
                                    value="<?= esc(old('tgljamacaraselesai', $tgljamacaraselesai ?? '')) ?>"
                                >

                                <?php if (isset($errors['tgljamacaraselesai'])) : ?>
                                    <div class="invalid-feedback d-block">
                                        <?= esc($errors['tgljamacaraselesai']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mb-4 row">
                            <label for="kode_ruang" class="col-md-3 col-form-label">Nama Ruangan <sup class="text-danger">*</sup></label>
                            <div class="col-md-9">
                                <select class="form-select <?= isset($errors['kode_ruang']) ? 'is-invalid' : '' ?>" id="kode_ruang" name="kode_ruang" required>
                                    <option value="">Pilih Ruangan</option>
                                    <?php foreach ($ref_ruang as $r) : ?>
                                        <option value="<?= esc($r['kode_ruang']) ?>" <?= old('kode_ruang', $kode_ruang ?? '') == $r['kode_ruang'] ? 'selected' : '' ?>>
                                            <?= esc($r['nama_ruang']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($errors['kode_ruang'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['kode_ruang']) ?></div><?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mb-4 row">
                            <label for="filesuratpinjam" class="col-md-3 col-form-label"> File Surat Izin (Opsional)</label>
                            <div class="col-md-9">
                                <input type="file" class="form-control <?= isset($errors['filesuratpinjam']) ? 'is-invalid' : '' ?>" id="filesuratpinjam" name="filesuratpinjam" value="<?= esc(old('filesuratpinjam', $filesuratpinjam ?? '')) ?>" accept=".pdf, .doc, .docx, .jpg, .png, .jpeg">
                                <small class="form-text text-muted">Format file: PDF, DOC, DOCX, JPG, PNG. Maksimal ukuran file: 2MB.</small>
                                <?php $fileLama = $filesuratpinjam ?? ''; ?>
                                <?php if (!empty($fileLama)) : ?>
                                    <div class="mt-2">
                                        <a href="<?= base_url('upload/surat/' . rawurlencode($fileLama)) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-show me-1"></i><?= esc($fileLama) ?>
                                        </a>
                                        <!-- <small class="text-muted d-block">Pilih file baru hanya jika ingin menggantinya.</small> -->
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($errors['filesuratpinjam'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['filesuratpinjam']) ?></div><?php endif; ?>
                            </div>
                        </div>
                        <div class="accordion mb-3" id="accordionExample">
                            <div class="accordion-item active">
                                <h2 class="accordion-header" id="headingOne">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">Syarat & Ketentuan</button>
                                </h2>

                                <div id="accordionOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body">
                                        <ul>
                                            <?php
                                                foreach ($ref_ketentuan as $k) {
                                                    echo '<li>' . esc($k['ketentuan']) . '</li>';
                                                }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-check form-check-inline mb-3">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" required="">
                            <label class="form-check-label" for="inlineCheckbox1">Saya setuju</label>
                        </div>
                        <div>
                            <button class="btn btn-secondary" type="reset">Batal</button>
                            <button class="btn btn-primary" type="submit"><?= $button ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card" id="timeline-card" style="display:none">
                <div class="card-header">
                    <h5 class="card-title mb-1">Jadwal Ruang</h5>
                    <div id="timeline-range" class="timeline-range text-muted"></div>
                </div>
                <div class="card-body">
                    <div id="timeline-loading" class="text-muted" style="display:none">Memuat jadwal...</div>
                    <div id="timeline-empty" class="text-muted" style="display:none">Tidak ada jadwal pada rentang tanggal tersebut.</div>
                    <div id="timeline-list"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('javascriptkhusus'); ?>
<script>
    const activemenu = document.querySelector('.active-menu-peminjaman-ruang-opd');

    activemenu.classList.add('active');
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mulai = document.getElementById('tgljamacaramulai');
    const selesai = document.getElementById('tgljamacaraselesai');
    const ruang = document.getElementById('kode_ruang');
    const form = mulai ? mulai.closest('form') : null;
    const tombolSimpan = form ? form.querySelector('button[type="submit"]') : null;
    const card = document.getElementById('timeline-card');
    const loading = document.getElementById('timeline-loading');
    const empty = document.getElementById('timeline-empty');
    const list = document.getElementById('timeline-list');
    const range = document.getElementById('timeline-range');

    if (!mulai || !selesai || !ruang || !form || !tombolSimpan) return;

    // Tombol hanya boleh aktif setelah kombinasi tanggal dan ruangan
    // berhasil dicek dan tidak ditemukan jadwal yang bentrok.
    let jadwalBentrok = true;
    let sedangMenyimpan = false;
    tombolSimpan.disabled = true;

    function setBentrok(value) {
        jadwalBentrok = value;
        tombolSimpan.disabled = value;
    }

    const esc = value => String(value ?? '').replace(/[&<>'"]/g, c => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;'
    }[c]));

    const formatDate = value => new Intl.DateTimeFormat('id-ID', {
        dateStyle: 'medium', timeStyle: 'short'
    }).format(new Date(String(value).replace(' ', 'T')));

    async function loadTimeline() {
        if (!mulai.value || !selesai.value || !ruang.value || selesai.value < mulai.value) {
            card.style.display = 'none';
            setBentrok(true);
            return;
        }

        card.style.display = '';
        // Nonaktifkan selama pengecekan berlangsung agar tidak bisa submit
        // sebelum status bentroknya diketahui.
        setBentrok(true);
        range.textContent = `Rentang: ${formatDate(mulai.value)} s.d. ${formatDate(selesai.value)}`;
        loading.style.display = '';
        empty.style.display = 'none';
        list.innerHTML = '';

        const body = new URLSearchParams({
            mulai: mulai.value,
            selesai: selesai.value,
            kode_ruang: ruang.value,
            id: document.getElementById('id')?.value || '',
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        });

        try {
            const response = await fetch('<?= base_url('peminjaman-ruang-opd/timeline') ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body
            });
            const result = await response.json();
            if (!response.ok) throw new Error(result.message || 'Gagal memuat jadwal.');

            if (!result.data.length) {
                setBentrok(false);
                empty.style.display = '';
                return;
            }

            setBentrok(true);

            if (window.Swal) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Jadwal bentrok',
                    text: 'Ruangan tersebut sudah digunakan pada rentang waktu yang dipilih.',
                    confirmButtonText: 'Mengerti'
                });
            }

            list.innerHTML = result.data.map(item => `
                <div class="timeline-item border-start border-3 border-primary py-2 mb-3" style="background-color: #f5f5f5;">
                    <div class="timeline-row">
                        <span class="timeline-icon">
                            <i class="bx bx-calendar"></i>
                        </span>
                        <div class="timeline-text timeline-date">
                            <div>${esc(formatDate(item.tgljamacaramulai))} s.d. ${esc(formatDate(item.tgljamacaraselesai))}</div>
                        </div>
                    </div>

                    <div class="timeline-row mt-1">
                        <span class="timeline-icon">
                            <i class="bx bx-note"></i>
                        </span>
                        <div class="timeline-text timeline-title">
                            <div>${esc(item.acara || '-')}</div>
                        </div>
                    </div>

                    <div class="timeline-row mt-1">
                        <span class="timeline-icon">
                            <i class="bx bx-home"></i>
                        </span>
                        <div class="timeline-text timeline-room">
                            <div>${esc(item.nama_ruang || 'Ruang belum ditentukan')}</div>
                        </div>
                    </div>
                </div>
            `).join('');
        } catch (error) {
            // Jika pengecekan gagal, jangan izinkan submit karena status
            // ketersediaan ruangan belum berhasil dipastikan.
            setBentrok(true);
            empty.textContent = error.message;
            empty.style.display = '';
        } finally {
            loading.style.display = 'none';
        }
    }

    mulai.addEventListener('change', loadTimeline);
    selesai.addEventListener('change', loadTimeline);
    ruang.addEventListener('change', loadTimeline);

    // Jalankan pengecekan saat halaman dibuka kembali setelah redirect
    // validasi/error, karena nilai input berasal dari old() dan tidak
    // memicu event change secara otomatis.
    loadTimeline();

    form.addEventListener('submit', function (event) {
        if (jadwalBentrok || sedangMenyimpan) {
            event.preventDefault();
            return;
        }

        // Mencegah double submit sebelum redirect selesai.
        sedangMenyimpan = true;
        tombolSimpan.disabled = true;
        tombolSimpan.dataset.labelAwal = tombolSimpan.innerHTML;
        tombolSimpan.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Menyimpan...';
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mulai = document.getElementById('tgljamacaramulai');
    const selesai = document.getElementById('tgljamacaraselesai');

    if (!mulai || !selesai) {
        return;
    }

    function getLocalDateTime() {
        const now = new Date();
        const offset = now.getTimezoneOffset() * 60000;

        return new Date(now.getTime() - offset)
            .toISOString()
            .slice(0, 16);
    }

    function updateMinimalSelesai() {
        const waktuSekarang = getLocalDateTime();

        let minSelesai = waktuSekarang;

        if (mulai.value && mulai.value > minSelesai) {
            minSelesai = mulai.value;
        }

        selesai.min = minSelesai;
    }

    function updateMinimalMulai() {
        const waktuSekarang = getLocalDateTime();

        // Hanya membatasi pilihan, jangan menghapus nilai input
        mulai.min = waktuSekarang;
    }

    function validateTanggal() {
        const sekarang = getLocalDateTime();

        mulai.setCustomValidity('');
        selesai.setCustomValidity('');

        if (mulai.value && mulai.value < sekarang) {
            mulai.setCustomValidity(
                'Tanggal mulai tidak boleh sebelum waktu sekarang.'
            );
        }

        if (selesai.value && selesai.value < sekarang) {
            selesai.setCustomValidity(
                'Tanggal selesai tidak boleh sebelum waktu sekarang.'
            );
        }

        if (mulai.value && selesai.value && selesai.value < mulai.value) {
            selesai.setCustomValidity(
                'Tanggal selesai tidak boleh sebelum tanggal mulai.'
            );
        }
    }

    function validateSelesai() {
        if (
            mulai.value &&
            selesai.value &&
            selesai.value < mulai.value
        ) {
            selesai.setCustomValidity(
                'Tanggal dan waktu selesai tidak boleh sebelum tanggal dan waktu mulai.'
            );
        } else {
            selesai.setCustomValidity('');
        }
    }

    mulai.addEventListener('change', function () {
        updateMinimalMulai();
        updateMinimalSelesai();
        validateSelesai();
    });

    selesai.addEventListener('change', function () {
        updateMinimalSelesai();
        validateSelesai();
    });

    // Inisialisasi saat halaman dibuka
    updateMinimalMulai();
    updateMinimalSelesai();
    validateSelesai();

    // Perbarui waktu minimum setiap menit
    setInterval(function () {
        updateMinimalMulai();
        updateMinimalSelesai();
    }, 60000);
});
</script>
<?= $this->endSection(); ?>
