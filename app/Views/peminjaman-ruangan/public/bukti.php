<?php
$mulai = $row['tgljamacaramulai'] ?? null;
$selesai = $row['tgljamacaraselesai'] ?? null;
$tanggalMulai = $mulai ? tanggal_indo($mulai) : '-';
$tanggalSelesai = $selesai ? tanggal_indo($selesai) : '-';
$tanggal = $tanggalMulai === $tanggalSelesai ? $tanggalMulai : $tanggalMulai . ' / ' . $tanggalSelesai;
$waktu = ($mulai && $selesai) ? date('H:i', strtotime($mulai)) . ' - ' . date('H:i', strtotime($selesai)) : '-';
$logoPath = FCPATH . 'landing/assets/img/kediri-old.png';
$logo = is_file($logoPath) ? 'data:image/png;base64,' . base64_encode((string) file_get_contents($logoPath)) : base_url('landing/assets/img/kediri-old.png');
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Bukti Pemesanan</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; color: #172033; background: #f3f5f9; font: 14px Arial, sans-serif; }
        .container { width: min(760px, calc(100% - 32px)); margin: 32px auto; }
        .card { overflow: hidden; background: #fff; border-radius: 14px; box-shadow: 0 8px 30px rgba(23, 32, 51, .12); }
        .header { display: flex; align-items: center; gap: 18px; padding: 24px; color: #fff; background: #1c4d83; }
        .header img { width: 58px; height: 72px; object-fit: contain; }
        .header h1 { margin: 0 0 5px; font-size: 20px; }
        .header p { margin: 0; opacity: .85; }
        .content { padding: 24px; }
        .status { display: inline-block; margin-bottom: 20px; padding: 7px 13px; color: #176b3a; background: #dcf7e7; border-radius: 999px; font-weight: bold; }
        .booking { display: grid; grid-template-columns: .85fr 1fr 1.65fr; gap: 24px; padding-bottom: 22px; border-bottom: 1px solid #e5e7eb; }
        .label { color: #6b7280; font-size: 12px; }
        .value { margin-top: 6px; font-weight: bold; line-height: 1.4; }
        h2 { margin: 24px 0 12px; font-size: 17px; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 8px 0; border-bottom: 1px solid #f0f1f3; vertical-align: top; }
        td:first-child { width: 145px; font-weight: bold; }
        .footer { padding: 18px 24px; color: #6b7280; background: #fafafa; font-size: 12px; }
        @media (max-width: 600px) { .booking { grid-template-columns: 1fr; gap: 12px; } .header { padding: 18px; } .content { padding: 18px; } }
    </style>
</head>
<body>
    <main class="container">
        <article class="card">
            <header class="header">
                <img src="<?= esc($logo) ?>" alt="Logo Kabupaten Kediri">
                <div><h1>Verifikasi Bukti Pemesanan</h1><p>SiRuang · Sekretariat Daerah Kabupaten Kediri</p></div>
            </header>
            <section class="content">
                <div class="status">✓ Pemesanan Disetujui</div>
                <div class="booking">
                    <div><div class="label">Kode Booking</div><div class="value"><?= esc($row['nopinjam'] ?? '-') ?></div></div>
                    <div><div class="label">Ruang/Gedung</div><div class="value"><?= esc($row['nama_ruang'] ?? '-') ?></div></div>
                    <div><div class="label">Tanggal dan Waktu</div><div class="value"><?= esc($tanggal) ?><br><?= esc($waktu) ?></div></div>
                </div>
                <h2>Data Peminjam</h2>
                <table>
                    <tr><td>Nama</td><td><?= esc($row['namapeminjam'] ?? '-') ?></td></tr>
                    <tr><td>NIP</td><td><?= esc($row['nip'] ?? '-') ?></td></tr>
                    <tr><td>Organisasi</td><td><?= esc($row['namaorganisasi'] ?? '-') ?></td></tr>
                    <tr><td>Alamat</td><td><?= esc($row['alamat_organisasi'] ?? '-') ?></td></tr>
                    <tr><td>No. Telepon</td><td><?= esc($row['nohp'] ?? '-') ?></td></tr>
                    <tr><td>Perihal</td><td><?= esc($row['acara'] ?? '-') ?></td></tr>
                </table>
                <h2>Informasi Ruangan</h2>
                <table>
                    <tr><td>Alamat Ruangan</td><td><?= esc($row['alamat_ruang'] ?? '-') ?></td></tr>
                    <tr><td>Fasilitas</td><td><?= esc($row['fasilitas'] ?? '-') ?></td></tr>
                    <tr><td>Peruntukan</td><td><?= esc(strtoupper($row['peruntukan'] ?? '-')) ?></td></tr>
                </table>
            </section>
            <footer class="footer">Halaman ini dapat diakses publik untuk memvalidasi keaslian bukti pemesanan.</footer>
        </article>
    </main>
</body>
</html>
