<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>SiRuang | Kab. Kediri</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="<?= base_url('landing/assets/') ?>img/kediri.png" rel="icon">
  <link href="<?= base_url('landing/assets/') ?>img/kediri.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url('landing/assets/') ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('landing/assets/') ?>vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url('landing/assets/') ?>vendor/aos/aos.css" rel="stylesheet">
  <link href="<?= base_url('landing/assets/') ?>vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?= base_url('landing/assets/') ?>vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="<?= base_url('landing/assets/') ?>css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: iLanding
  * Template URL: https://bootstrapmade.com/ilanding-bootstrap-landing-page-template/
  * Updated: Nov 12 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  
  <!-- FullCalendar JS (CDN Bundle mencakup CSS & JS sekaligus) -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
  <!-- SweetAlert2 CSS & JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
</head>

<body class="index-page">

    <!-- navbar dan sidebar -->
    <?= $this->include('layouts/navbarsidebar_landing'); ?>

  <main class="main">

    <!-- section isinya disini -->
    <?= $this->renderSection('content'); ?>
    <!-- section isinya disini -->

  </main>

  <footer id="footer" class="footer">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">

              <img src="<?= base_url('landing/assets/') ?>img/kediri.png" alt="">

              <div class="logo-text">
                  <span class="sitename">SiRuang</span>
                  <h6 class="sitename">Kabupaten Kediri</h6>
              </div>

          </a>
          <div class="footer-contact pt-3">
            <p>Jl. Soekarno-Hatta No. 1, Kediri</p>
            <p class="mt-3"><strong>Telepon:</strong> <span>Jl. Soekarno-Hatta No. 1, Kediri</span></p>
            <p><strong>Email:</strong> <span>bagian_umum@kedirikab.go.id</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <!--<div class="col-lg-2 col-md-3 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><a href="#">Web Design</a></li>
            <li><a href="#">Web Development</a></li>
            <li><a href="#">Product Management</a></li>
            <li><a href="#">Marketing</a></li>
            <li><a href="#">Graphic Design</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Hic solutasetp</h4>
          <ul>
            <li><a href="#">Molestiae accusamus iure</a></li>
            <li><a href="#">Excepturi dignissimos</a></li>
            <li><a href="#">Suscipit distinctio</a></li>
            <li><a href="#">Dilecta</a></li>
            <li><a href="#">Sit quas consectetur</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Nobis illum</h4>
          <ul>
            <li><a href="#">Ipsam</a></li>
            <li><a href="#">Laudantium dolorum</a></li>
            <li><a href="#">Dinera</a></li>
            <li><a href="#">Trodelas</a></li>
            <li><a href="#">Flexo</a></li>
          </ul>
        </div> -->

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">SiRuang | Kabupaten Kediri</strong> <span>All Rights Reserved</span></p>
    </div>

  </footer>
  <!-- MODAL DETAIL RUANGAN -->
  <div class="modal fade" id="modal-detail-ruang" tabindex="-1"
      aria-labelledby="modalDetailRuangLabel"
      aria-hidden="true">

      <div class="modal-dialog modal-lg">
          <div class="modal-content">

              <!-- HEADER -->
              <div class="modal-header">
                  <h5 class="modal-title" id="modalDetailRuangLabel">
                      <strong>DETAIL RUANGAN</strong>
                  </h5>

                  <button type="button"
                          class="btn-close"
                          data-bs-dismiss="modal"
                          aria-label="Close">
                  </button>
              </div>

              <!-- BODY -->
              <div class="modal-body">

                  <!-- FOTO -->
                  <div id="carouselfoto" class="carousel slide">

                      <div class="carousel-inner"
                          id="items"
                          style="height:450px;">

                          <div class="carousel-item active">
                              <img
                                  src="<?= base_url('landing/assets/') ?>img/logo_kediri.png"
                                  id="foto_ruang1"
                                  style="height:450px; object-fit:cover;"
                                  class="d-block w-100"
                                  alt="Foto ruangan">
                          </div>

                      </div>

                      <button class="carousel-control-prev"
                              type="button"
                              data-bs-target="#carouselfoto"
                              data-bs-slide="prev">

                          <span class="carousel-control-prev-icon"></span>
                          <span class="visually-hidden">Previous</span>

                      </button>

                      <button class="carousel-control-next"
                              type="button"
                              data-bs-target="#carouselfoto"
                              data-bs-slide="next">

                          <span class="carousel-control-next-icon"></span>
                          <span class="visually-hidden">Next</span>

                      </button>

                  </div>

                  <hr>

                  <section id="features-2" class="features-2 section">

                    <div class="container" data-aos="fade-up" data-aos-delay="100">

                        <div class="row g-4">

                            <!-- KOLOM KIRI -->
                            <div class="col-lg-6">

                                <!-- ALAMAT -->
                                <div class="feature-item mb-4"
                                    data-aos="fade-left"
                                    data-aos-delay="200">

                                    <div class="d-flex align-items-center gap-4">

                                        <div class="feature-icon flex-shrink-0">
                                            <i class="bi bi-geo"></i>
                                        </div>

                                        <div class="feature-content text-start">
                                            <h3>ALAMAT</h3>
                                            <p id="modal_alamat">-</p>
                                        </div>

                                    </div>

                                </div>


                                <!-- NOMOR TELEPON -->
                                <div class="feature-item mb-4"
                                    data-aos="fade-left"
                                    data-aos-delay="300">

                                    <div class="d-flex align-items-center gap-4">

                                        <div class="feature-icon flex-shrink-0">
                                            <i class="bi bi-telephone"></i>
                                        </div>

                                        <div class="feature-content text-start">
                                            <h3>NOMOR TELEPON</h3>
                                            <p id="modal_notelp">-</p>
                                        </div>

                                    </div>

                                </div>


                                <!-- JUMLAH KURSI -->
                                <div class="feature-item mb-4"
                                    data-aos="fade-left"
                                    data-aos-delay="400">

                                    <div class="d-flex align-items-center gap-4">

                                        <div class="feature-icon flex-shrink-0">
                                            <i class="fa fa-chair"></i>
                                        </div>

                                        <div class="feature-content text-start">
                                            <h3>JUMLAH KURSI</h3>
                                            <p id="modal_jumlahkursi">-</p>
                                        </div>

                                    </div>

                                </div>


                                <!-- FASILITAS -->
                                <div class="feature-item"
                                    data-aos="fade-left"
                                    data-aos-delay="500">

                                    <div class="d-flex align-items-center gap-4">

                                        <div class="feature-icon flex-shrink-0">
                                            <i class="bi bi-building-fill-gear"></i>
                                        </div>

                                        <div class="feature-content text-start">
                                            <h3>FASILITAS</h3>
                                            <p id="modal_fasilitas">-</p>
                                        </div>

                                    </div>

                                </div>

                            </div>
                            <!-- KOLOM KANAN -->
                            <div class="col-lg-6">

                                <!-- PENANGGUNG JAWAB -->
                                <div class="feature-item mb-4"
                                    data-aos="fade-left"
                                    data-aos-delay="200">

                                    <div class="d-flex align-items-center gap-4">

                                        <div class="feature-icon flex-shrink-0">
                                            <i class="bi bi-person-circle"></i>
                                        </div>

                                        <div class="feature-content text-start">
                                            <h3>PENANGGUNG JAWAB</h3>
                                            <p id="modal_namapenanggungjawab">-</p>
                                        </div>

                                    </div>

                                </div>


                                <!-- LUAS RUANGAN -->
                                <div class="feature-item mb-4"
                                    data-aos="fade-left"
                                    data-aos-delay="300">

                                    <div class="d-flex align-items-center gap-4">

                                        <div class="feature-icon flex-shrink-0">
                                            <i class="bi bi-rulers"></i>
                                        </div>

                                        <div class="feature-content text-start">
                                            <h3>LUAS RUANGAN (M<sup>2</sup>)</h3>
                                            <p id="modal_luasruangan">-</p>
                                        </div>

                                    </div>

                                </div>


                                <!-- JUMLAH MEJA -->
                                <div class="feature-item mb-4"
                                    data-aos="fade-left"
                                    data-aos-delay="400">

                                    <div class="d-flex align-items-center gap-4">

                                        <div class="feature-icon flex-shrink-0">
                                            <i class="bi bi-table"></i>
                                        </div>

                                        <div class="feature-content text-start">
                                            <h3>JUMLAH MEJA</h3>
                                            <p id="modal_jumlahmeja">-</p>
                                        </div>

                                    </div>

                                </div>

                            </div>
                            
                            <div class="col-md-12">
                              <div id="maps" style="height: 300px; width: 100%; border-radius: 10px; overflow: hidden;"></div>
                            </div>
                        </div>

                    </div>

                </section>

              </div>

              <!-- FOOTER -->
              <div class="modal-footer">

                  <a href="#"
                    id="link_testimoni"
                    class="btn btn-info"
                    target="_blank">
                      Testimoni
                  </a>

                  <a href="#"
                    id="link_pinjam"
                    class="btn btn-danger">
                      Pesan Ruangan
                  </a>

              </div>

          </div>
      </div>
  </div>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?= base_url('landing/assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url('landing/assets/') ?>vendor/php-email-form/validate.js"></script>
  <script src="<?= base_url('landing/assets/') ?>vendor/aos/aos.js"></script>
  <script src="<?= base_url('landing/assets/') ?>vendor/glightbox/js/glightbox.min.js"></script>
  <script src="<?= base_url('landing/assets/') ?>vendor/swiper/swiper-bundle.min.js"></script>
  <script src="<?= base_url('landing/assets/') ?>vendor/purecounter/purecounter_vanilla.js"></script>

  <!-- Main JS File -->
  <script src="<?= base_url('landing/assets/') ?>js/main.js"></script>

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

  <script>
      const dataRuangan = <?= json_encode(
          $dataRuangan,
          JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
      ) ?>;
  </script>

  <script>

    document.querySelectorAll('.btn-detail-ruang').forEach(function(button) {

        button.addEventListener('click', function(e) {

            e.preventDefault();

            const id = this.dataset.room;

            const ruang = dataRuangan[id];

            if (!ruang) {
                console.error('Data ruangan tidak ditemukan:', id);
                return;
            }

            tampilkanMap(ruang.googlemaps_url);

            // =========================
            // INFORMASI
            // =========================

            document.getElementById('modalDetailRuangLabel').innerHTML =
                '<strong>' + ruang.nama + '</strong>';

            document.getElementById('modal_alamat').textContent =
                ruang.alamat;

            document.getElementById('modal_notelp').textContent =
                ruang.notelp;

            document.getElementById('modal_jumlahkursi').textContent =
                ruang.jumlahkursi;

            document.getElementById('modal_fasilitas').textContent =
                ruang.fasilitas;

            document.getElementById('modal_namapenanggungjawab').textContent =
                ruang.penanggungjawab;

            document.getElementById('modal_luasruangan').textContent =
                ruang.luas;

            document.getElementById('modal_jumlahmeja').textContent =
                ruang.jumlahmeja;


            // =========================
            // FOTO
            // =========================

            const carouselItems =
                document.getElementById('items');

            carouselItems.innerHTML = '';

            ruang.foto.forEach(function(foto, index) {

                const div = document.createElement('div');

                div.className =
                    'carousel-item' +
                    (index === 0 ? ' active' : '');

                div.innerHTML = `
                    <img
                        src="${foto}"
                        class="d-block w-100"
                        style="height:450px; object-fit:cover;"
                        alt="${ruang.nama}">
                `;

                carouselItems.appendChild(div);

            });


            // =========================
            // LINK TESTIMONI
            // =========================

            document.getElementById('link_testimoni').href =
                '#testimonials';


            // =========================
            // LINK PESAN RUANGAN
            // =========================

            document.getElementById('link_pinjam').href =
                '#contact';


            // =========================
            // TAMPILKAN MODAL
            // =========================

            const modalElement =
                document.getElementById('modal-detail-ruang');

            const modal =
                bootstrap.Modal.getOrCreateInstance(modalElement);

            modal.show();

        });

    });

  </script>

  <script>

    function tampilkanMap(googlemaps_url) {

        const mapContainer = document.getElementById('maps');

        const embedUrl = googlemaps_url + '&output=embed';

        mapContainer.innerHTML = `
            <iframe
                src="${embedUrl}"
                width="100%"
                height="300"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        `;
    }

  </script>
  <script>
      const roomSearch = document.getElementById('roomSearch');
      const roomCards = document.querySelectorAll('.room-card-item');

      roomSearch.addEventListener('input', function () {
          const keyword = this.value.toLowerCase().trim();

          roomCards.forEach(card => {
              const searchData = card.dataset.search.toLowerCase();

              card.style.display = searchData.includes(keyword)
                  ? ''
                  : 'none';
          });
      });
  </script>
</body>

</html>
