<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>SiRuang | KAB. KEDIRI</title>
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

        <div class="col-lg-2 col-md-3 footer-links">
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
        </div>

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

        // Data Jadwal (Events)
        events: [
          {
            id: '1',
            title: 'Bagian Umum - Rapat Koordinasi',
            start: '2026-08-01T09:00:00',
            end: '2026-08-01T11:00:00',
            backgroundColor: '#f59e0b',
            borderColor: '#d97706'
          },
          {
            id: '2',
            title: 'Peminjaman Ruang Utama',
            start: '2026-08-05',
            allDay: true, // Untuk acara seharian penuh
            backgroundColor: '#3b82f6',
            borderColor: '#2563eb'
          },
          {
            id: '3',
            title: 'Rapat Dinas Pendidikan',
            start: '2026-08-14T07:00:00',
            backgroundColor: '#10b981',
            borderColor: '#059669'
          }
        ],

        // Handler saat Event diklik
        eventClick: function(info) {
          // Format tanggal & waktu agar rapi
          const startDate = info.event.start ? info.event.start.toLocaleDateString('id-ID', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
          }) : '-';

          const startTime = info.event.start ? info.event.start.toLocaleTimeString('id-ID', {
            hour: '2-digit', minute: '2-digit'
          }) : '';

          const endTime = info.event.end ? info.event.end.toLocaleTimeString('id-ID', {
            hour: '2-digit', minute: '2-digit'
          }) : '';

          const timeString = info.event.allDay 
            ? 'Seharian Penuh' 
            : `${startTime} - ${endTime} WIB`;

          // Tampilkan SweetAlert2 Popup
          Swal.fire({
            title: `<span style="color: #1e293b; font-size: 20px;">Detail Peminjaman</span>`,
            html: `
              <div style="text-align: left; font-family: Arial, sans-serif; line-height: 1.6; padding: 10px;">
                <div style="margin-bottom: 12px;">
                  <strong style="color: #64748b; font-size: 12px; display: block; text-transform: uppercase;">Nama Kegiatan / Ruang:</strong>
                  <span style="font-size: 16px; font-weight: bold; color: #0f172a;">${info.event.title}</span>
                </div>
                
                <div style="margin-bottom: 12px;">
                  <strong style="color: #64748b; font-size: 12px; display: block; text-transform: uppercase;">Tanggal:</strong>
                  <span style="font-size: 14px; color: #334155;">📅 ${startDate}</span>
                </div>

                <div style="margin-bottom: 12px;">
                  <strong style="color: #64748b; font-size: 12px; display: block; text-transform: uppercase;">Waktu:</strong>
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

    const dataRuangan = {

      "joyoboyo": {
          nama: "Joyoboyo",
          alamat: "Jl. Soekarno Hatta No.1 Kediri Gedung Setda Kab. Kediri Lantai 1",
          notelp: "081234567890",
          penanggungjawab: "Admin Ruangan Joyoboyo",
          luas: "120",
          jumlahkursi: "100",
          jumlahmeja: "20",
          fasilitas: "AC, LCD Projector, Sound System, WiFi",
          foto: [
              "<?= base_url('landing/assets/') ?>img/SLD-0000003_20260811010353.jpeg",
              "<?= base_url('landing/assets/') ?>img/SLD-0000005_20260811010450.png",
              "<?= base_url('landing/assets/') ?>img/SLD-0000003_20260811010353.jpeg",
          ],
          googlemaps_url: "https://www.google.com/maps?q=-7.8167,112.0167"
      },

      "aula-utama-kelud": {
          nama: "Aula Utama Kelud (Convention Hall SLG)",
          alamat: "Jl. Erlangga Kawasan SLG",
          notelp: "081234567891",
          penanggungjawab: "Admin Aula Kelud",
          luas: "500",
          jumlahkursi: "500",
          jumlahmeja: "50",
          fasilitas: "AC, Sound System, LCD, WiFi, Panggung",
          foto: [
              "<?= base_url('landing/assets/') ?>img/SLD-0000005_20260811010450.png",
              "<?= base_url('landing/assets/') ?>img/SLD-0000005_20260811010450.png",
              "<?= base_url('landing/assets/') ?>img/SLD-0000003_20260811010353.jpeg",
          ],
          googlemaps_url: "https://www.google.com/maps?q=-7.8160,111.9800"
      },

      "kilisuci": {
          nama: "Kilisuci",
          alamat: "Jl. Soekarno Hatta No.1 Kediri",
          notelp: "081234567892",
          penanggungjawab: "Admin Ruangan Kilisuci",
          luas: "100",
          jumlahkursi: "80",
          jumlahmeja: "15",
          fasilitas: "AC, LCD Projector, WiFi",
          foto: [
              "<?= base_url('landing/assets/') ?>img/SLD-0000004_20260811010438.png",
              "<?= base_url('landing/assets/') ?>img/SLD-0000005_20260811010450.png",
              "<?= base_url('landing/assets/') ?>img/SLD-0000003_20260811010353.jpeg",
          ],
          googlemaps_url: "https://www.google.com/maps?q=-7.8167,112.0167"
      }

    };
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
</body>

</html>
