<?php

$formatTanggal = static function (?string $value): string {
    if (empty($value)) {
        return '-';
    }

    $tanggal = tanggal_indo($value);
    return $tanggal;
};

$mulai = $row['tgljamacaramulai'] ?? null;
$selesai = $row['tgljamacaraselesai'] ?? null;
$tanggalMulai = $formatTanggal($mulai);
$tanggalSelesai = $formatTanggal($selesai);
$waktu = ($mulai && $selesai)
    ? date('H:i', strtotime($mulai)) . ' - ' . date('H:i', strtotime($selesai))
    : '-';

$tanggalAcara = $tanggalMulai === $tanggalSelesai
    ? $tanggalMulai
    : $tanggalMulai . ' / ' . $tanggalSelesai;

$logoPath = FCPATH . 'landing/assets/img/kediri-old.png';
$logo = is_file($logoPath)
    ? 'data:image/png;base64,' . base64_encode((string) file_get_contents($logoPath))
    : base_url('landing/assets/img/kediri-old.png');
$bookingCode = $row['nopinjam'] ?: $row['id'];
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Bukti Pemesanan - <?= esc($bookingCode) ?></title>
    <style>
        @page { size: A4 portrait; margin: 0mm 14mm; }
        * { box-sizing: border-box; }
        body { margin: 0; color: #111; font: 14px Arial, Helvetica, sans-serif; }
        .paper { width: 100%; min-height: 273mm; }
        .kop { display: flex; align-items: center; padding-bottom: 8px; border-bottom: 3px solid #111; }
        .kop img { width: 72px; height: 88px; margin: 0 18px 0 8px; object-fit: contain; transform: translateY(85px); }
        .kop-text { flex: 1; text-align: center; line-height: 1.25; }
        .kop-text .instansi { font-size: 16px; }
        .kop-text strong { display: block; font-size: 20px; }
        .kop-text small { display: block; margin-top: 3px; font-size: 13px; }
        h1 { margin: 11px 0 16px; text-align: center; font-size: 17px; }
        .summary { display: grid; grid-template-columns: 1.15fr 1.55fr .8fr; gap: 14px; padding-bottom: 17px; border-bottom: 1px solid #999; }
        .label { color: #555; font-size: 13px; }
        .value { margin-top: 4px; font-weight: bold; line-height: 1.35; font-size: 12.5px;}
        .qr-code { display: block; width: 90px; height: 90px; margin: 8px 0 8px auto; }
        .section { padding: 14px 0; border-bottom: 1px solid #999; }
        .section-title { margin-bottom: 8px; font-size: 14px; font-weight: bold; }
        .details { width: 100%; border-collapse: collapse; }
        .details td { padding: 4px 0; vertical-align: top; }
        .details td:first-child { width: 125px; font-weight: bold; }
        .details td:nth-child(2) { width: 12px; }
        .terms { margin: 6px 0 0 20px; padding-left: 18px; }
        .terms li { padding: 2px 0; line-height: 1.3; }
        .footer { margin-top: 22px; text-align: right; line-height: 1.4; }
        .print-button { position: fixed; top: 18px; right: 22px; padding: 9px 14px; border: 0; border-radius: 4px; background: #f59e0b; color: #fff; cursor: pointer; }
        @media print { .print-button { display: none; } }
    </style>
</head>
<body>
    <main class="paper">
        <header class="kop">
            <img src="<?= esc($logo) ?>" alt="Logo Kabupaten Kediri">
            <div class="kop-text">
                <div class="instansi">PEMERINTAH KABUPATEN KEDIRI</div>
                <div class="instansi">SEKRETARIAT DAERAH</div>
                <strong>BAGIAN UMUM</strong>
                <small>Jalan Soekarno Hatta Nomor 1, Kecamatan Ngasem, Kabupaten Kediri 64182</small>
                <small>Telepon (0354) 689901–689905, Pos-el bagian_umum@kedirikab.go.id</small>
            </div>
        </header>
        <h1>BUKTI PEMESANAN</h1>
        <section class="summary">
            <table border="0" width="100%">
                <tr>
                    <td width="25%" style="vertical-align:top">
                        <div class="label">Ruang/Gedung</div><div class="value"><?= esc($row['nama_ruang'] ?? '-') ?></div>
                    </td>
                    <td style="vertical-align:top">
                        <div class="label" style="text-align:center">Tanggal dan Waktu Acara</div>
                        <div class="value"  style="text-align:center">
                            <?= esc($tanggalAcara) ?><br><?= esc($waktu) ?>
                        </div>
                    </td>
                    <td width="25%" style="vertical-align:top">
                        <div class="label" style="text-align:right">Kode Booking</div>
                        <div class="value" style="text-align:right"><?= esc($bookingCode) ?></div>
                    </td>
                </tr>
            </table>
        </section>
        <section class="section">
            <div class="section-title">Data Diri Peminjam:</div>
            <table class="details">
                <tr><td>Nama</td><td>:</td><td><?= esc($row['namapeminjam'] ?? '-') ?></td></tr>
                <tr><td>NIP</td><td>:</td><td><?= esc($row['nip'] ?? '-') ?></td></tr>
                <tr><td>Organisasi</td><td>:</td><td><?= esc($row['namaorganisasi'] ?? '-') ?></td></tr>
                <tr><td>Alamat</td><td>:</td><td><?= esc($row['alamat_organisasi'] ?? '-') ?></td></tr>
                <tr><td>No. Telepon</td><td>:</td><td><?= esc($row['nohp'] ?? '-') ?></td></tr>
            </table>
        </section>
        <section class="section">
            <div class="section-title">Syarat dan Ketentuan Pemakaian:</div>
            <ol class="terms">
                <?php foreach ($ketentuan as $item): ?>
                    <li><?= esc($item['ketentuan']) ?></li>
                <?php endforeach; ?>
            </ol>
        </section>
        <div class="footer">
            <table border="0" width="100%">
                
                <tr>
                    <td  width="60%"></td>
                    <td style="text-align: center">
                        Kediri, <?= esc(tanggal_indo(date('Y-m-d'))) ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center">
                        <img class="qr-code" src="<?= esc($qrCode) ?>" alt="QR Code Bukti Pemesanan">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center">
                        <strong>Bagian Umum<br>Sekretariat Daerah Kabupaten Kediri</strong>
                    </td>
                </tr>
            </table>
        </div>
    </main>
</body>
</html>
