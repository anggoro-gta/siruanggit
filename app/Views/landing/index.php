<?= $this->extend('layouts/template_landing'); ?>
<?= $this->section('content'); ?>
<!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div id="heroSlideshow" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-interval="4500">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroSlideshow" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#heroSlideshow" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#heroSlideshow" data-bs-slide-to="2" aria-label="Slide 3"></button>
          </div>

          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="row align-items-center">
                <div class="col-lg-12"><div class="hero-image"><img src="<?= base_url('landing/assets/') ?>img/SLD-0000003_20260811010353.jpeg" alt="Ilustrasi SiRuang" class="img-fluid"></div></div>
              </div>
            </div>

            <div class="carousel-item">
              <div class="row align-items-center">
                <div class="col-lg-12"><div class="hero-image"><img src="<?= base_url('landing/assets/') ?>img/SLD-0000005_20260811010450.png" alt="Fitur pengelolaan SiRuang" class="img-fluid"></div></div>
              </div>
            </div>

            <div class="carousel-item">
              <div class="row align-items-center">
                <div class="col-lg-12"><div class="hero-image"><img src="<?= base_url('landing/assets/') ?>img/SLD-0000004_20260811010438.png" alt="Tampilan aplikasi SiRuang" class="img-fluid"></div></div>
              </div>
            </div>
          </div>

          <button class="carousel-control-prev" type="button" data-bs-target="#heroSlideshow" data-bs-slide="prev" aria-label="Slide sebelumnya"><span class="carousel-control-prev-icon" aria-hidden="true"></span></button>
          <button class="carousel-control-next" type="button" data-bs-target="#heroSlideshow" data-bs-slide="next" aria-label="Slide berikutnya"><span class="carousel-control-next-icon" aria-hidden="true"></span></button>
        </div>

        <!-- <div class="row stats-row gy-4 mt-5" data-aos="fade-up" data-aos-delay="500">
          <div class="col-lg-3 col-md-6">
            <div class="stat-item">
              <div class="stat-icon">
                <i class="bi bi-trophy"></i>
              </div>
              <div class="stat-content">
                <h4>3x Won Awards</h4>
                <p class="mb-0">Vestibulum ante ipsum</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="stat-item">
              <div class="stat-icon">
                <i class="bi bi-briefcase"></i>
              </div>
              <div class="stat-content">
                <h4>6.5k Faucibus</h4>
                <p class="mb-0">Nullam quis ante</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="stat-item">
              <div class="stat-icon">
                <i class="bi bi-graph-up"></i>
              </div>
              <div class="stat-content">
                <h4>80k Mauris</h4>
                <p class="mb-0">Etiam sit amet orci</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="stat-item">
              <div class="stat-icon">
                <i class="bi bi-award"></i>
              </div>
              <div class="stat-content">
                <h4>6x Phasellus</h4>
                <p class="mb-0">Vestibulum ante ipsum</p>
              </div>
            </div>
          </div>
        </div> -->

      </div>

    </section><!-- /Hero Section -->

    <!-- Kalender Section -->
    <section id="kalender" class="testimonials section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Peminjaman Yang Diverifikasi Oleh Admin</h2>
        <p>Setelah anda mengisi formulir peminjaman maka akan diverifikasi oleh admin, jika admin mengizinkan maka data peminjaman anda akan ditampilkan sesuai tanggal peminjaman yang anda lakukan</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="d-flex justify-content-center">
          <div class="calendar-container">
            <div id="calendar"></div>
          </div>
        </div>

      </div>

    </section><!-- /Kalender Section -->

    <!-- Daftar Ruang Section -->
    <section id="daftar-ruang" class="features section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Daftar Ruang</h2>
        <p>Dibawah adalah daftar Ruang yang bisa dipinjam pada sistem ini dan melihat status ketersediaannya apakah saat ini ada atau sedang dipinjam</p>
      </div><!-- End Section Title -->

      <div class="container">

        <form class="room-search" role="search" onsubmit="return false;">
          <label class="visually-hidden" for="roomSearch">Cari ruangan</label>
          <input id="roomSearch" type="search" placeholder="Cari ruang berdasarkan nama atau alamat..." autocomplete="off">
          <button type="submit" aria-label="Cari ruangan"><i class="bi bi-search" aria-hidden="true"></i></button>
        </form>

        <div id="roomList" class="row g-4 room-grid">
          <div class="col-xl-3 col-lg-4 col-md-6 room-card-item" data-room="joyoboyo jl soekarno hatta no 1 kediri gedung setda kab kediri lantai 1">
            <article class="room-card">
              <img src="<?= base_url('landing/assets/') ?>img/SLD-0000003_20260811010353.jpeg" alt="Ruang Joyoboyo" loading="lazy">
              <div class="room-card-body">
                <p class="room-rating"><i class="bi bi-star-fill" aria-hidden="true"></i> 0</p>
                <h3>Joyoboyo</h3>
                <p class="room-address">Jl. Soekarno Hatta No.1 Kediri Gedung Setda Kab. Kediri Lantai 1</p>
                <a href="javascript:void(0)"
                class="room-button btn-detail-ruang"
                data-room="joyoboyo">
                    Lihat Selengkapnya <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </article>
          </div>

          <div class="col-xl-3 col-lg-4 col-md-6 room-card-item" data-room="aula utama kelud convention hall slg jl erlangga kawasan slg">
            <article class="room-card">
              <img src="<?= base_url('landing/assets/') ?>img/SLD-0000005_20260811010450.png" alt="Aula Utama Kelud" loading="lazy">
              <div class="room-card-body">
                <p class="room-rating"><i class="bi bi-star-fill" aria-hidden="true"></i> 0</p>
                <h3>Aula Utama Kelud (Convention Hall SLG)</h3>
                <p class="room-address">Jl. Erlangga Kawasan SLG</p>
                <a href="javascript:void(0)"
                class="room-button btn-detail-ruang"
                data-room="aula-utama-kelud">
                    Lihat Selengkapnya <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </article>
          </div>

          <div class="col-xl-3 col-lg-4 col-md-6 room-card-item" data-room="kilisuci jl soekarno hatta no 1 kediri">
            <article class="room-card">
              <img src="<?= base_url('landing/assets/') ?>img/SLD-0000004_20260811010438.png" alt="Ruang Kilisuci" loading="lazy">
              <div class="room-card-body">
                <p class="room-rating"><i class="bi bi-star-fill" aria-hidden="true"></i> 0</p>
                <h3>Kilisuci</h3>
                <p class="room-address">Jl. Soekarno Hatta No.1 Kediri</p>
                <a href="javascript:void(0)"
                class="room-button btn-detail-ruang"
                data-room="kilisuci">
                    Lihat Selengkapnya <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </article>
          </div>

          <div class="col-xl-3 col-lg-4 col-md-6 room-card-item" data-room="kameswara wisma tamu canda bhirawa jl soekarno hatta no 1 kediri">
            <article class="room-card">
              <img src="<?= base_url('landing/assets/') ?>img/SLD-0000003_20260811010353.jpeg" alt="Kameswara Wisma Tamu Canda Bhirawa" loading="lazy">
              <div class="room-card-body">
                <p class="room-rating"><i class="bi bi-star-fill" aria-hidden="true"></i> 0</p>
                <h3>Kameswara (Wisma Tamu Canda Bhirawa)</h3>
                <p class="room-address">Jl. Soekarno Hatta No.1 Kediri</p>
                <a href="javascript:void(0)"
                class="room-button btn-detail-ruang"
                data-room="joyoboyo">
                    Lihat Selengkapnya <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </article>
          </div>

          <div class="col-xl-3 col-lg-4 col-md-6 room-card-item" data-room="pendapa panjalu jayati">
            <article class="room-card">
              <img src="<?= base_url('landing/assets/') ?>img/SLD-0000005_20260811010450.png" alt="Pendapa Panjalu Jayati" loading="lazy">
              <div class="room-card-body">
                <p class="room-rating"><i class="bi bi-star-fill" aria-hidden="true"></i> 0</p>
                <h3>Pendapa Panjalu Jayati</h3>
                <p class="room-address">Kabupaten Kediri</p>
                <a href="javascript:void(0)"
                class="room-button btn-detail-ruang"
                data-room="joyoboyo">
                    Lihat Selengkapnya <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </article>
          </div>

          <div class="col-xl-3 col-lg-4 col-md-6 room-card-item" data-room="sekartaji">
            <article class="room-card">
              <img src="<?= base_url('landing/assets/') ?>img/SLD-0000004_20260811010438.png" alt="Ruang Sekartaji" loading="lazy">
              <div class="room-card-body">
                <p class="room-rating"><i class="bi bi-star-fill" aria-hidden="true"></i> 0</p>
                <h3>Sekartaji</h3>
                <p class="room-address">Kabupaten Kediri</p>
                <a href="javascript:void(0)"
                class="room-button btn-detail-ruang"
                data-room="joyoboyo">
                    Lihat Selengkapnya <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </article>
          </div>

          <div class="col-xl-3 col-lg-4 col-md-6 room-card-item" data-room="bhagawanta bhari">
            <article class="room-card">
              <img src="<?= base_url('landing/assets/') ?>img/SLD-0000003_20260811010353.jpeg" alt="Ruang Bhagawanta Bhari" loading="lazy">
              <div class="room-card-body">
                <p class="room-rating"><i class="bi bi-star-fill" aria-hidden="true"></i> 0</p>
                <h3>Bhagawanta Bhari</h3>
                <p class="room-address">Kabupaten Kediri</p>
                <a href="javascript:void(0)"
                class="room-button btn-detail-ruang"
                data-room="joyoboyo">
                    Lihat Selengkapnya <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </article>
          </div>

          <div class="col-xl-3 col-lg-4 col-md-6 room-card-item" data-room="asmorobangun convention hall">
            <article class="room-card">
              <img src="<?= base_url('landing/assets/') ?>img/SLD-0000005_20260811010450.png" alt="Asmorobangun Convention Hall" loading="lazy">
              <div class="room-card-body">
                <p class="room-rating"><i class="bi bi-star-fill" aria-hidden="true"></i> 0</p>
                <h3>Asmorobangun (Convention Hall)</h3>
                <p class="room-address">Kabupaten Kediri</p>
                <a href="javascript:void(0)"
                class="room-button btn-detail-ruang"
                data-room="joyoboyo">
                    Lihat Selengkapnya <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </article>
          </div>
        </div>

        <p id="roomEmptyState" class="room-empty-state" hidden>Ruangan tidak ditemukan.</p>

        <div class="d-flex justify-content-center">
        </div>

      </div>

    </section><!-- /Daftar Ruang Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4 align-items-center justify-content-between">

          <div class="col-xl-12" data-aos="fade-up" data-aos-delay="200">

            <span class="about-meta">TENTANG KAMI</span>

            <h2 class="about-title">
                Kemudahan dalam Menemukan dan Memesan Ruangan
            </h2>

            <p class="about-description">
                SiRuang merupakan platform informasi dan layanan peminjaman ruangan
                yang membantu masyarakat dan pengguna dalam menemukan berbagai
                pilihan ruangan yang tersedia, melihat informasi fasilitas,
                serta melakukan pemesanan ruangan secara lebih mudah dan terorganisir.
            </p>

            <div class="row feature-list-wrapper">

                <div class="col-md-6">
                    <ul class="feature-list">

                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            Informasi ruangan yang lengkap
                        </li>

                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            Informasi fasilitas ruangan
                        </li>

                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            Lokasi ruangan terintegrasi peta
                        </li>

                    </ul>
                </div>

                <div class="col-md-6">
                    <ul class="feature-list">

                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            Proses pemesanan lebih mudah
                        </li>

                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            Informasi ketersediaan ruangan
                        </li>

                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            Pengelolaan ruangan lebih terorganisir
                        </li>

                    </ul>
                </div>

            </div>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

    

    <section class="faq-9 faq section light-background" id="faq">

      <div class="container">
        <div class="row">

          <div class="col-lg-5 aos-init aos-animate" data-aos="fade-up">
            <h2 class="faq-title">Pertanyaan Umum</h2>
            <p class="faq-description">Kumpulan pertanyaan yang sering muncul terkait layanan dan pemesanan ruang.</p>
            <div class="faq-arrow d-none d-lg-block aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
              <svg class="faq-arrow" width="200" height="211" viewBox="0 0 200 211" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M198.804 194.488C189.279 189.596 179.529 185.52 169.407 182.07L169.384 182.049C169.227 181.994 169.07 181.939 168.912 181.884C166.669 181.139 165.906 184.546 167.669 185.615C174.053 189.473 182.761 191.837 189.146 195.695C156.603 195.912 119.781 196.591 91.266 179.049C62.5221 161.368 48.1094 130.695 56.934 98.891C84.5539 98.7247 112.556 84.0176 129.508 62.667C136.396 53.9724 146.193 35.1448 129.773 30.2717C114.292 25.6624 93.7109 41.8875 83.1971 51.3147C70.1109 63.039 59.63 78.433 54.2039 95.0087C52.1221 94.9842 50.0776 94.8683 48.0703 94.6608C30.1803 92.8027 11.2197 83.6338 5.44902 65.1074C-1.88449 41.5699 14.4994 19.0183 27.9202 1.56641C28.6411 0.625793 27.2862 -0.561638 26.5419 0.358501C13.4588 16.4098 -0.221091 34.5242 0.896608 56.5659C1.8218 74.6941 14.221 87.9401 30.4121 94.2058C37.7076 97.0203 45.3454 98.5003 53.0334 98.8449C47.8679 117.532 49.2961 137.487 60.7729 155.283C87.7615 197.081 139.616 201.147 184.786 201.155L174.332 206.827C172.119 208.033 174.345 211.287 176.537 210.105C182.06 207.125 187.582 204.122 193.084 201.144C193.346 201.147 195.161 199.887 195.423 199.868C197.08 198.548 193.084 201.144 195.528 199.81C196.688 199.192 197.846 198.552 199.006 197.935C200.397 197.167 200.007 195.087 198.804 194.488ZM60.8213 88.0427C67.6894 72.648 78.8538 59.1566 92.1207 49.0388C98.8475 43.9065 106.334 39.2953 114.188 36.1439C117.295 34.8947 120.798 33.6609 124.168 33.635C134.365 33.5511 136.354 42.9911 132.638 51.031C120.47 77.4222 86.8639 93.9837 58.0983 94.9666C58.8971 92.6666 59.783 90.3603 60.8213 88.0427Z" fill="currentColor"></path>
              </svg>
            </div>
          </div>

          <div class="col-lg-7 aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
            <div class="faq-container">

              <!-- FAQ 1 -->
              <div class="faq-item faq-active">

                  <h3>Apa itu SiRuang?</h3>

                  <div class="faq-content">
                      <p>
                          SiRuang merupakan aplikasi layanan informasi dan peminjaman
                          ruangan Pemerintah Kabupaten Kediri. Melalui SiRuang,
                          pengguna dapat melihat informasi ruangan, fasilitas,
                          kapasitas, lokasi, serta melakukan pemesanan ruangan.
                      </p>
                  </div>

                  <i class="faq-toggle bi bi-chevron-right"></i>

              </div>
              <!-- End Faq item -->


              <!-- FAQ 2 -->
              <div class="faq-item">

                  <h3>Siapa saja yang dapat menggunakan SiRuang?</h3>

                  <div class="faq-content">
                      <p>
                          SiRuang dapat digunakan oleh pengguna yang membutuhkan
                          informasi dan layanan peminjaman ruangan yang tersedia
                          di lingkungan Pemerintah Kabupaten Kediri, sesuai dengan
                          ketentuan dan kebijakan yang berlaku.
                      </p>
                  </div>

                  <i class="faq-toggle bi bi-chevron-right"></i>

              </div>
              <!-- End Faq item -->


              <!-- FAQ 3 -->
              <div class="faq-item">

                  <h3>Informasi apa saja yang tersedia pada SiRuang?</h3>

                  <div class="faq-content">
                      <p>
                          SiRuang menyediakan informasi mengenai nama dan lokasi
                          ruangan, alamat, kapasitas, luas ruangan, jumlah meja
                          dan kursi, fasilitas yang tersedia, penanggung jawab,
                          serta informasi pendukung lainnya.
                      </p>
                  </div>

                  <i class="faq-toggle bi bi-chevron-right"></i>

              </div>
              <!-- End Faq item -->


              <!-- FAQ 4 -->
              <div class="faq-item">

                  <h3>Bagaimana cara melihat detail suatu ruangan?</h3>

                  <div class="faq-content">
                      <p>
                          Pilih ruangan yang ingin diketahui informasinya, kemudian
                          klik tombol <strong>Lihat Selengkapnya</strong>. Sistem akan
                          menampilkan detail ruangan, foto, fasilitas, informasi
                          kapasitas, lokasi pada peta, serta informasi penanggung jawab.
                      </p>
                  </div>

                  <i class="faq-toggle bi bi-chevron-right"></i>

              </div>
              <!-- End Faq item -->


              <!-- FAQ 5 -->
              <div class="faq-item">

                  <h3>Bagaimana cara melakukan pemesanan ruangan?</h3>

                  <div class="faq-content">
                      <p>
                          Untuk melakukan pemesanan, pilih ruangan yang diinginkan
                          kemudian klik tombol <strong>Pesan Ruangan</strong>.
                          Selanjutnya ikuti tahapan pemesanan yang tersedia pada
                          sistem hingga proses pengajuan selesai.
                      </p>
                  </div>

                  <i class="faq-toggle bi bi-chevron-right"></i>

              </div>
              <!-- End Faq item -->


              <!-- FAQ 6 -->
              <div class="faq-item">

                  <h3>Bagaimana jika membutuhkan informasi lebih lanjut?</h3>

                  <div class="faq-content">
                      <p>
                          Untuk mendapatkan informasi lebih lanjut mengenai ruangan,
                          fasilitas, jadwal, atau proses peminjaman, pengguna dapat
                          menghubungi kontak penanggung jawab yang tercantum pada
                          informasi detail masing-masing ruangan.
                      </p>
                  </div>

                  <i class="faq-toggle bi bi-chevron-right"></i>

              </div>
              <!-- End Faq item -->

          </div>
          </div>

        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Kontak Kami</h2>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-4 g-lg-5">
          <div class="col-lg-5">
            <div class="info-box" data-aos="fade-up" data-aos-delay="200">
              <h3>Informasi Kontak</h3>
              <p>Hubungi kami untuk informasi dan bantuan lebih lanjut</p>

              <div class="info-item" data-aos="fade-up" data-aos-delay="300">
                <div class="icon-box">
                  <i class="bi bi-geo-alt"></i>
                </div>
                <div class="content">
                  <h4>Alamat</h4>
                  <p>Jl. Soekarno-Hatta No. 1, Kediri</p>
                </div>
              </div>

              <div class="info-item" data-aos="fade-up" data-aos-delay="400">
                <div class="icon-box">
                  <i class="bi bi-telephone"></i>
                </div>
                <div class="content">
                  <h4>Telepon</h4>
                  <p>+62 812-5990-7707</p>
                </div>
              </div>

              <div class="info-item" data-aos="fade-up" data-aos-delay="500">
                <div class="icon-box">
                  <i class="bi bi-envelope"></i>
                </div>
                <div class="content">
                  <h4>Email</h4>
                  <p>bagian_umum@kedirikab.go.id</p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-7">

            <div class="contact-form"
                data-aos="fade-up"
                data-aos-delay="300" style="background-color: #f8f9fa; padding: 20px; border-radius: 10px;">

                <div style="
                    width: 100%;
                    height: 400px;
                    overflow: hidden;
                    border-radius: 10px;
                ">

                    <iframe
                        src="https://www.google.com/maps?q=-7.8167,112.0167&output=embed"
                        width="100%"
                        height="400"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>

                </div>

                <div class="text-center mt-4">

                    <a
                        href="https://www.google.com/maps?q=-7.8167,112.0167"
                        target="_blank"
                        class="btn">

                        <i class="bi bi-geo-alt"></i>
                        Buka di Google Maps

                    </a>

                </div>

            </div>

        </div>

        </div>

      </div>

    </section><!-- /Contact Section -->
    
<!-- / Content -->
<?= $this->endSection(); ?>