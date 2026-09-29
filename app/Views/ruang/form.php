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
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<!-- Geocoder CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css"/>
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
            <a href="<?= base_url('master-ruang'); ?>" class="btn btn-secondary">
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
                        <label for="nama_ruang" class="form-label">Nama Ruang <sup class="text-danger">*</sup></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-edit-alt"></i></span>
                            <input type="text" class="form-control <?= isset($errors['nama_ruang']) ? 'is-invalid' : '' ?>" id="nama_ruang" name="nama_ruang" required value="<?= esc(old('nama_ruang', $nama_ruang ?? '')) ?>">
                        </div>
                        <?php if (isset($errors['nama_ruang'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['nama_ruang']) ?></div><?php endif; ?>
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="luas_ruang" class="form-label">Luas Ruang <sup class="text-danger">*</sup></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-ruler"></i></span>
                            <input type="number" class="form-control <?= isset($errors['luas_ruang']) ? 'is-invalid' : '' ?>" id="luas_ruang" name="luas_ruang" required value="<?= esc(old('luas_ruang', $luas_ruang ?? '')) ?>">
                            <span class="input-group-text">m&sup2;</span>
                        </div>
                        <?php if (isset($errors['luas_ruang'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['luas_ruang']) ?></div><?php endif; ?>
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="jml_kursi" class="form-label">Jumlah Kursi <sup class="text-danger">*</sup></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-chair"></i></span>
                            <input type="number" class="form-control <?= isset($errors['jml_kursi']) ? 'is-invalid' : '' ?>" id="jml_kursi" name="jml_kursi" required value="<?= esc(old('jml_kursi', $jml_kursi ?? '')) ?>">
                            <span class="input-group-text">unit</span>
                        </div>
                        <?php if (isset($errors['jml_kursi'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['jml_kursi']) ?></div><?php endif; ?>
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="jml_meja" class="form-label">Jumlah Meja <sup class="text-danger">*</sup></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-table"></i></span>
                            <input type="number" class="form-control <?= isset($errors['jml_meja']) ? 'is-invalid' : '' ?>" id="jml_meja" name="jml_meja" required value="<?= esc(old('jml_meja', $jml_meja ?? '')) ?>">
                            <span class="input-group-text">unit</span>
                        </div>
                        <?php if (isset($errors['jml_meja'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['jml_meja']) ?></div><?php endif; ?>
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="fasilitas" class="form-label">Fasilitas <sup class="text-danger">*</sup></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-list-ol"></i></span>
                            <input type="text" class="form-control <?= isset($errors['fasilitas']) ? 'is-invalid' : '' ?>" id="fasilitas" name="fasilitas" required value="<?= esc(old('fasilitas', $fasilitas ?? '')) ?>">
                        </div>
                        <?php if (isset($errors['fasilitas'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['fasilitas']) ?></div><?php endif; ?>
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="ukuran_banner" class="form-label">Ukuran Banner </label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-image"></i></span>
                            <input type="text" class="form-control <?= isset($errors['ukuran_banner']) ? 'is-invalid' : '' ?>" id="ukuran_banner" name="ukuran_banner" value="<?= esc(old('ukuran_banner', $ukuran_banner ?? '')) ?>">
                        </div>
                        <?php if (isset($errors['ukuran_banner'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['ukuran_banner']) ?></div><?php endif; ?>
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="namapj" class="form-label">Nama Penanggung Jawab <sup class="text-danger">*</sup></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-user"></i></span>
                            <input type="text" class="form-control <?= isset($errors['namapj']) ? 'is-invalid' : '' ?>" id="namapj" name="namapj" required value="<?= esc(old('namapj', $namapj ?? '')) ?>">
                        </div>
                        <?php if (isset($errors['namapj'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['namapj']) ?></div><?php endif; ?>
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="telppj" class="form-label">Telepon Penanggung Jawab <sup class="text-danger">*</sup></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-phone"></i></span>
                            <input type="text" class="form-control <?= isset($errors['telppj']) ? 'is-invalid' : '' ?>" id="telppj" name="telppj" required value="<?= esc(old('telppj', $telppj ?? '')) ?>">
                        </div>
                        <?php if (isset($errors['telppj'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['telppj']) ?></div><?php endif; ?>
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="harga_sewa" class="form-label">Harga Sewa <sup class="text-danger">*</sup></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" style="color: #9e9e9e">Rp</span>
                            <input type="text" class="form-control nominal <?= isset($errors['harga_sewa']) ? 'is-invalid' : '' ?>" id="harga_sewa" name="harga_sewa" required value="<?= esc(old('harga_sewa', $harga_sewa > 0 ? number_format($harga_sewa, 0, ',', '.') : '')) ?>">
                        </div>
                        <?php if (isset($errors['harga_sewa'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['harga_sewa']) ?></div><?php endif; ?>
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="peruntukan" class="form-label">Peruntukan <sup class="text-danger">*</sup></label>
                        <select class="form-select <?= isset($errors['peruntukan']) ? 'is-invalid' : '' ?>" id="peruntukan" name="peruntukan" required>
                            <option value="">Pilih</option>
                            <option value="dinas" <?= old('peruntukan', $peruntukan) === 'dinas' ? 'selected' : '' ?>>Dinas</option>
                            <option value="masyarakat" <?= old('peruntukan', $peruntukan) === 'masyarakat' ? 'selected' : '' ?>>Masyarakat</option>
                        </select>
                        <?php if (isset($errors['peruntukan'])) : ?><div class="invalid-feedback"><?= esc($errors['peruntukan']) ?></div><?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="alamat" class="form-label">Alamat Ruang <sup class="text-danger">*</sup></label>
                            <textarea class="form-control <?= isset($errors['alamat']) ? 'is-invalid' : '' ?>" id="alamat" name="alamat" required><?= esc(old('alamat', $alamat ?? '')) ?></textarea>
                            <?php if (isset($errors['alamat'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['alamat']) ?></div><?php endif; ?>
                        </div>
                        <div class="row align-items-end">
                            <div class="mb-4 col-md-5">
                                <label for="latitude" class="form-label">
                                    Latitude <sup class="text-danger">*</sup>
                                </label>

                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" style="color: #9e9e9e">
                                        <i class="bx bx-current-location"></i>
                                    </span>
                                    <input type="text" class="form-control" id="latitude" name="latitude">
                                </div>
                            </div>

                            <div class="mb-4 col-md-5">
                                <label for="longitude" class="form-label">
                                    Longitude <sup class="text-danger">*</sup>
                                </label>

                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" style="color: #9e9e9e">
                                        <i class="bx bx-current-location"></i>
                                    </span>
                                    <input type="text" class="form-control" id="longitude" name="longitude">
                                </div>
                            </div>

                            <div class="mb-4 col-md-2">
                                <button type="button" class="btn btn-info w-100" id="btn-open-maps" <?= !empty($latitude) ? '' : (!empty($longitude) ? '' : 'disabled') ?> >
                                    <i class="bx bx-search"></i>
                                </button>
                            </div>
                        </div>
                        <div id="map" class="mb-4" style="height:380px;border-radius:12px;"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="foto1" class="form-label">Foto 1 <sup class="text-primary">( Hanya boleh file ekstensi .jpg/.jpeg/.png/.webp )</sup></label>
                            <input class="form-control" type="file" id="foto1" name="foto1" accept=".jpg,.jpeg,.png,.webp">
                            <?php if (isset($errors['foto1'])) : ?><div class="invalid-feedback"><?= esc($errors['foto1']) ?></div><?php endif; ?>
                            <?php
                                $f1 = '';
                                if(!empty($foto1)) {
                                    $f1 = '<a href="' . base_url('upload/ruang/' . $foto1) . '" title="Lihat" target="_blank">
                                        <img src="'. base_url('upload/ruang/' . $foto1) .'" width="30%" class="mt-2 gambar">
                                    </a>';
                                }
                                echo $f1;
                            ?>
                        </div>
                        <div class="mb-4">
                            <label for="foto2" class="form-label">Foto 2 <sup class="text-primary">( Hanya boleh file ekstensi .jpg/.jpeg/.png/.webp )</sup></label>
                            <input class="form-control" type="file" id="foto2" name="foto2" accept=".jpg,.jpeg,.png,.webp">
                            <?php if (isset($errors['foto2'])) : ?><div class="invalid-feedback"><?= esc($errors['foto2']) ?></div><?php endif; ?>
                            <?php
                                $f2 = '';
                                if(!empty($foto2)) {
                                    $f2 = '<a href="' . base_url('upload/ruang/' . $foto2) . '" title="Lihat" target="_blank">
                                        <img src="'. base_url('upload/ruang/' . $foto2) .'" width="30%" class="mt-2 gambar">
                                    </a>';
                                }
                                echo $f2;
                            ?>
                        </div>
                        <div class="mb-4">
                            <label for="foto3" class="form-label">Foto 3 <sup class="text-primary">( Hanya boleh file ekstensi .jpg/.jpeg/.png/.webp )</sup></label>
                            <input class="form-control" type="file" id="foto3" name="foto3" accept=".jpg,.jpeg,.png,.webp">
                            <?php if (isset($errors['foto3'])) : ?><div class="invalid-feedback"><?= esc($errors['foto3']) ?></div><?php endif; ?>
                            <?php
                                $f3 = '';
                                if(!empty($foto3)) {
                                    $f3 = '<a href="' . base_url('upload/ruang/' . $foto3) . '" title="Lihat" target="_blank">
                                        <img src="'. base_url('upload/ruang/' . $foto3) .'" width="30%" class="mt-2 gambar">
                                    </a>';
                                }
                                echo $f3;
                            ?>
                        </div>
                        <div class="mb-4">
                            <label for="foto4" class="form-label">Foto 4 <sup class="text-primary">( Hanya boleh file ekstensi .jpg/.jpeg/.png/.webp )</sup></label>
                            <input class="form-control" type="file" id="foto4" name="foto4" accept=".jpg,.jpeg,.png,.webp">
                            <?php if (isset($errors['foto4'])) : ?><div class="invalid-feedback"><?= esc($errors['foto4']) ?></div><?php endif; ?>
                            <?php
                                $f4 = '';
                                if(!empty($foto4)) {
                                    $f4 = '<a href="' . base_url('upload/ruang/' . $foto4) . '" title="Lihat" target="_blank">
                                        <img src="'. base_url('upload/ruang/' . $foto4) .'" width="30%" class="mt-2 gambar">
                                    </a>';
                                }
                                echo $f4;
                            ?>
                        </div>
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
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Geocoder JS -->
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    const activemenu = document.querySelector('.active-menu-ruang');

    activemenu.classList.add('active');

    $(document).ready(function() {
        $('.nominal').on('keyup', function() {
            var angka = $(this).val();
            if (angka === '' || angka === '0' || angka === '0.00') {
                // $(this).val('0');
                return;
            }
            $(this).val(formatRibuan(angka));
        });

        function replaceAngka(angka) {
            let number_string = angka.replace(/[^,\d]/g, '').toString();
            // kalau isinya cuma nol semua, kembalikan '0'
            if (/^0+$/.test(number_string)) {
                return '0';
            }
            return number_string;
        }

        function formatRibuan(angka) {
            // var number_string = angka.replace(/[^,\d]/g, '').toString(),
            var number_string = replaceAngka(angka)
            split = number_string.split(','),
                sisa = split[0].length % 3,
                angka_hasil = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                angka_hasil += separator + ribuan.join('.');
            }

            angka_hasil = split[1] != undefined ? angka_hasil + ',' + split[1] : angka_hasil;
            return angka_hasil;
        }
    })

</script>
<script>
  const defaultLat = -7.808567492728441;   // Kediri
  const defaultLng = 112.04166959033034;  // Kediri

  const map = L.map('map').setView([defaultLat, defaultLng], 13);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap'
  }).addTo(map);

  let marker = null;

  const $lat = $('#latitude');
  const $lng = $('#longitude');
  const $btn = $('#btn-open-maps');

  function isValidLatLng(lat, lng) {
    lat = parseFloat(lat);
    lng = parseFloat(lng);
    if (Number.isNaN(lat) || Number.isNaN(lng)) return false;
    if (lat < -90 || lat > 90) return false;
    if (lng < -180 || lng > 180) return false;
    return true;
  }

  function setButtonEnabled(enabled) {
    $btn.prop('disabled', !enabled);
  }

  function clearPoint() {
    $lat.val('');
    $lng.val('');
    $('#span_lat').text('');
    $('#span_long').text('');
    // marker boleh dihapus atau biarkan terakhir; sesuai kebutuhan:
    if (marker) {
      map.removeLayer(marker);
      marker = null;
    }
    setButtonEnabled(false);
  }

  function setPoint(lat, lng, { pan = false, doReverse = false } = {}) {
    lat = parseFloat(lat);
    lng = parseFloat(lng);

    // isi field (tanpa enter kalau kosong)
    $lat.val(lat.toFixed(15));
    $lng.val(lng.toFixed(15));

    $('#span_lat').text(': ' + lat.toFixed(6));
    $('#span_long').text(': ' + lng.toFixed(6));

    if (!marker) {
      marker = L.marker([lat, lng], { draggable: true }).addTo(map);

      marker.on('dragend', async (e) => {
        const p = e.target.getLatLng();
        setPoint(p.lat, p.lng, { pan: false, doReverse: true });
      });
    } else {
      marker.setLatLng([lat, lng]);
    }

    if (pan) map.setView([lat, lng], 16);

    setButtonEnabled(true);

    if (doReverse) reverseGeocode(lat, lng);
  }

  // Klik peta => set marker + reverse geocode
  map.on('click', async (e) => {
    setPoint(e.latlng.lat, e.latlng.lng, { pan: false, doReverse: true });
  });

  // Geocoder
  const geocoder = L.Control.geocoder({ defaultMarkGeocode: false })
    .on('markgeocode', async function(e) {
      const center = e.geocode.center;
      map.setView(center, 17);
      setPoint(center.lat, center.lng, { pan: false, doReverse: false });
      $('#span_alamat').text(e.geocode.name || '');
      setButtonEnabled(true);
    })
    .addTo(map);

  async function reverseGeocode(lat, lng) {
    try {
      const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`;
      const res = await fetch(url, { headers: { 'Accept': 'application/json' }});
      const json = await res.json();
      $('#span_alamat').text(': ' + (json.display_name || ''));
    } catch (err) {
      console.warn('Reverse geocode gagal:', err);
    }
  }

  // === INPUT EVENT: user isi lat/lng => marker otomatis muncul + tombol enable ===
  function syncFromInputs() {
    const latVal = $lat.val().trim();
    const lngVal = $lng.val().trim();

    // kalau salah satu kosong => jangan isi marker, tombol disable
    if (latVal === '' || lngVal === '') {
      // kalau Anda ingin marker ikut hilang saat user hapus input:
      if (marker) { map.removeLayer(marker); marker = null; }
      setButtonEnabled(false);
      return;
    }

    // kalau tidak valid => disable juga (opsional)
    if (!isValidLatLng(latVal, lngVal)) {
      setButtonEnabled(false);
      return;
    }

    // valid => set marker
    setPoint(latVal, lngVal, { pan: false, doReverse: false });
  }

  // realtime saat user mengetik
  $lat.on('input', syncFromInputs);
  $lng.on('input', syncFromInputs);

  // === INIT dari DB (kalau edit data) ===
  const existingLat = "<?= $latitude ?>";
  const existingLng = "<?= $longitude ?>";

  if (isValidLatLng(existingLat, existingLng)) {
    setPoint(existingLat, existingLng, { pan: true, doReverse: false });
  } else {
    // kosong -> field jangan diisi & tombol disable
    clearPoint();
    // tetap biarkan map di Kediri
    map.setView([defaultLat, defaultLng], 13);
  }

  // === Tombol Lihat Peta (contoh aksi) ===
  // Sesuaikan: misal buka modal / scroll ke map / fokus map
  $btn.on('click', function() {
    map.invalidateSize();      // penting kalau map di dalam tab/modal
    if (marker) map.panTo(marker.getLatLng());
  });
</script>
<script>
  $('#btn-open-maps').on('click', function () {
    const lat = $('#lat').val().trim();
    const lng = $('#lng').val().trim();

    // validasi sederhana
    const latNum = parseFloat(lat);
    const lngNum = parseFloat(lng);
    if (isNaN(latNum) || isNaN(lngNum)) return;

    // Google Maps (pin di koordinat)
    const url = `https://www.google.com/maps?q=${latNum},${lngNum}`;

    // opsi A: buka tab baru
    window.open(url, '_blank');

    // opsi B: redirect di tab yang sama (pakai ini kalau mau)
    // window.location.href = url;
  });
</script>

<?= $this->endSection(); ?>
