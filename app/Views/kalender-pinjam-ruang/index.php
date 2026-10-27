<?php
    if($role==='admin'){
        echo $this->extend('layouts/template');
    }else{
        echo $this->extend('layouts/template_opd');
    }
?>

<?= $this->section('csskhusus'); ?>
<!-- FullCalendar JS (CDN Bundle mencakup CSS & JS sekaligus) -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<style>
    /* Pastikan container kalender mengambil lebar penuh */
    .calendar-container {
        width: 100% !important;
        max-width: 100% !important;
        margin: 30px 0 !important;
        padding: 0 15px !important;
        box-sizing: border-box !important;
    }

    #calendar {
        width: 100% !important;
        height: 750px !important;
    }

    /* Memaksa tabel internal FullCalendar melebar penuh */
    .fc {
        width: 100% !important;
        max-width: 100% !important;
    }

    .fc .fc-view-harness {
        width: 100% !important;
    }

    /* Kustomisasi warna tombol & tema FullCalendar */
    .fc-button-primary {
        background-color: #1e293b !important;
        border-color: #1e293b !important;
    }

    .fc-button-primary:hover {
        background-color: #334155 !important;
        border-color: #334155 !important;
    }

    .fc-button-active {
        background-color: #2563eb !important;
        border-color: #2563eb !important;
    }

    .fc-toolbar-title {
        font-size: 1.5rem !important;
        font-weight: bold;
    }

    /* Mengubah kursor menjadi pointer saat hover di event kalender */
    .fc-event {
        cursor: pointer !important;
    }

    .custom-swal-popup {
        border-radius: 12px !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
    }

    #features-2 .feature-item {
        min-height: 90px;
        display: flex;
        align-items: center;
    }

    #features-2 .feature-item > .d-flex {
        width: 100%;
        height: 100%;
        align-items: center;
    }

    #features-2 .feature-icon {
        width: 60px;
        min-width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #features-2 .feature-icon i {
        font-size: 28px;
    }

    #features-2 .feature-content {
        flex: 1;
    }

    #features-2 .feature-content h3 {
        margin: 0 0 5px 0;
        font-size: 16px;
    }

    #features-2 .feature-content p {
        margin: 0;
        line-height: 1.5;
    }

    .logo-text {
        display: flex;
        flex-direction: column;
        line-height: 1;
    }

    .logo-text .sitename {
        margin: 0;
    }

    .logo-text span {
        font-size: 12px;
        font-weight: 500;
        margin-top: 5px;
        letter-spacing: 0.5px;
        color: #6c757d;
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
                <form method="get" action="<?= base_url('kalender-pinjam-ruang') ?>">
                    <select class="form-control" name="ruang_id" onchange="this.form.submit()">
                        <option value="">Semua Ruang</option>
                        <?php
                            foreach ($ruangdata as $item) {
                                $selected = ($ruang_id ?? '') === $item['kode_ruang'] ? ' selected' : '';
                                echo '<option value="' . esc($item['kode_ruang']) . '"' . $selected . '>' . esc($item['nama_ruang']) . '</option>';
                            }
                        ?>
                    </select>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="calendar-container">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('javascriptkhusus'); ?>
<script>
    const activemenu = document.querySelector('.active-menu-kalender-pinjam-ruang');

    activemenu.classList.add('active');

</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');

        // Inisialisasi FullCalendar
        const calendar = new FullCalendar.Calendar(calendarEl, {
        // Tampilan awal (Bulan)
        initialView: 'dayGridMonth',
        expandRows: true, // Memaksa baris tanggal mengisi seluruh tinggi container
        handleWindowResize: true, // Responsif saat window di-resize
        
        // Bahasa & Zona Waktu
        locale: 'id', // Format bahasa Indonesia (opsional)
        
        // Konfigurasi Toolbar Bawaan FullCalendar
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        // Label Tombol
        buttonText: {
            today: 'Hari Ini',
            month: 'Bulan',
            week: 'Minggu',
            day: 'Hari'
        },

        // Pengaturan Tampilan Events
        editable: false,        // Set true jika ingin drag-and-drop
        selectable: false,      // Set true jika ingin memilih area tanggal
        dayMaxEvents: true,     // Tampilkan "+more" jika event terlalu banyak dalam 1 hari
        displayEventTime: true,
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },

        events: <?= json_encode(array_map(static function (array $jadwal): array {
            $warna = [
            ['backgroundColor' => '#2563eb', 'borderColor' => '#1d4ed8'],
            ['backgroundColor' => '#16a34a', 'borderColor' => '#15803d'],
            ['backgroundColor' => '#ea580c', 'borderColor' => '#c2410c'],
            ['backgroundColor' => '#9333ea', 'borderColor' => '#7e22ce'],
            ['backgroundColor' => '#0891b2', 'borderColor' => '#0e7490'],
            ['backgroundColor' => '#db2777', 'borderColor' => '#be185d'],
            ][((int) $jadwal['id']) % 6];

            $mulai = !empty($jadwal['tgljamacaramulai'])
            ? date('Y-m-d\TH:i:s', strtotime($jadwal['tgljamacaramulai']))
            : null;
            $selesai = !empty($jadwal['tgljamacaraselesai'])
            ? date('Y-m-d\TH:i:s', strtotime($jadwal['tgljamacaraselesai']))
            : null;
            $acara = trim((string) ($jadwal['acara'] ?? '-'));
            $ruang = trim((string) ($jadwal['nama_ruang'] ?? ''));
            $namaorganisasi = trim((string) ($jadwal['namaorganisasi'] ?? ''));

            return [
            'id' => (string) $jadwal['id'],
            'title' => $namaorganisasi,
            'namaorganisasi' => $namaorganisasi,
            'acara' => $acara,
            'ruang' => $ruang,
            'start' => $mulai,
            'end' => $selesai,
            'backgroundColor' => $warna['backgroundColor'],
            'borderColor' => $warna['borderColor'],
            ];
        }, $jadwaldata ?? []), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>,

        // Handler saat Event diklik
        eventClick: function(info) {
            // Format tanggal & waktu agar rapi
            const formatTanggal = (tanggal, tampilkanTahun = true) => tanggal.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            ...(tampilkanTahun ? { year: 'numeric' } : {})
            });

            const startDate = info.event.start ? formatTanggal(info.event.start) : '-';
            const endDate = info.event.end ? formatTanggal(info.event.end) : startDate;
            const tanggalSama = info.event.start && info.event.end
            && info.event.start.toDateString() === info.event.end.toDateString();
            const tanggalString = tanggalSama
            ? startDate
            : `${formatTanggal(info.event.start, info.event.start.getFullYear() === info.event.end?.getFullYear())} - ${endDate}`;

            const startTime = info.event.start ? info.event.start.toLocaleTimeString('id-ID', {
            hour: '2-digit', minute: '2-digit'
            }) : '';

            const endTime = info.event.end ? info.event.end.toLocaleTimeString('id-ID', {
            hour: '2-digit', minute: '2-digit'
            }) : '';

            const timeString = info.event.allDay 
            ? 'Seharian Penuh' 
            : `${startTime} - ${endTime} WIB`;

            const jadwalString = info.event.allDay
            ? tanggalString
            : tanggalSama
                ? `${startDate} | ${startTime} - ${endTime} WIB`
                : `${startDate} | ${startTime} - ${endDate} | ${endTime} WIB`;

            // Tampilkan SweetAlert2 Popup
            const namaOrganisasi = info.event.extendedProps.namaorganisasi || '-';
            const acara = info.event.extendedProps.acara || '-';
            const ruang = info.event.extendedProps.ruang || 'Ruang tidak tersedia';

            Swal.fire({
            title: `<span style="color: #1e293b; font-size: 20px;">Detail Peminjaman</span>`,
            html: `
                <div style="text-align: left; font-family: Arial, sans-serif; line-height: 1.6; padding: 10px;">
                <div style="margin-bottom: 12px;">
                    <strong style="color: #64748b; font-size: 12px; display: block; text-transform: uppercase;">Organisasi:</strong>
                    <span style="font-size: 16px; font-weight: bold; color: #0f172a;">${namaOrganisasi}</span>
                </div>

                <div style="margin-bottom: 12px;">
                    <strong style="color: #64748b; font-size: 12px; display: block; text-transform: uppercase;">Perihal Acara:</strong>
                    <span style="font-size: 14px; color: #334155;">${acara}</span>
                </div>

                <div style="margin-bottom: 12px;">
                    <strong style="color: #64748b; font-size: 12px; display: block; text-transform: uppercase;">Ruang:</strong>
                    <span style="font-size: 14px; color: #334155;">${ruang}</span>
                </div>
                
                <div style="margin-bottom: 12px;">
                    <strong style="color: #64748b; font-size: 12px; display: block; text-transform: uppercase;">Jadwal:</strong>
                    <span style="font-size: 14px; color: #334155;">📅 ${jadwalString}</span>
                </div>

                <div style="margin-bottom: 12px; display: none;">
                    <strong style="color: #64748b; font-size: 12px; display: block; text-transform: uppercase;">Jadwal (tanggal):</strong>
                    <span style="font-size: 14px; color: #334155;">📅 ${tanggalString}</span>
                </div>

                <div style="margin-bottom: 12px; display: none;">
                    <strong style="color: #64748b; font-size: 12px; display: block; text-transform: uppercase;">Jam:</strong>
                    <span style="font-size: 14px; color: #334155;">⏰ ${timeString}</span>
                </div>
                </div>
            `,
            icon: 'info',
            iconColor: '#2563eb',
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#1e293b',
            customClass: {
                popup: 'custom-swal-popup'
            }
            });
        }
        });

        // Render Kalender ke Layar
        calendar.render();

        // Memaksa kalkulasi ulang ukuran setelah render
        setTimeout(() => {
        calendar.updateSize();
        }, 100);
    });
</script>

<?= $this->endSection(); ?>
