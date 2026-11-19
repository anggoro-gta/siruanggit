<?php

namespace App\Controllers;

use App\Models\PeminjamanRuang;

class Home extends BaseController
{
    protected $peminjamanruang;

    public function __construct()
    {
        $this->peminjamanruang = new PeminjamanRuang();
    }

    public function index(): string
    {
        $kategoriuser = user()->kategori;
        $kodedinas = user()->kode_dinas;

        if ($kategoriuser == 'admin') {
            $getsemuapinjamanruang = $this->peminjamanruang->counttotalpinjamruang();
            $getpinjamruangansetujui = $this->peminjamanruang->counttotalpinjamruang(null, 1);
            $getpinjamruanganditolak = $this->peminjamanruang->counttotalpinjamruang(null, 0);
            $getpinjamruangandibatalkan = $this->peminjamanruang->counttotalpinjamruang(null, 2);

            $data = [
                'title' => 'SiRuang | Kab. Kediri',
                'semuaruang' => $getsemuapinjamanruang,
                'disetujui' => $getpinjamruangansetujui,
                'ditolak' => $getpinjamruanganditolak,
                'dibatalkan' => $getpinjamruangandibatalkan
            ];
        } else {
            $getsemuapinjamanruang = $this->peminjamanruang->counttotalpinjamruang($kodedinas, null);
            $getpinjamruangansetujui = $this->peminjamanruang->counttotalpinjamruang($kodedinas, 1);
            $getpinjamruanganditolak = $this->peminjamanruang->counttotalpinjamruang($kodedinas, 0);
            $getpinjamruangandibatalkan = $this->peminjamanruang->counttotalpinjamruang($kodedinas, 2);

            $data = [
                'title' => 'SiRuang | Kab. Kediri',
                'semuaruang' => $getsemuapinjamanruang,
                'disetujui' => $getpinjamruangansetujui,
                'ditolak' => $getpinjamruanganditolak,
                'dibatalkan' => $getpinjamruangandibatalkan
            ];
        }        

        if ($kategoriuser === 'admin') {
            return view('home/index', $data);
        } else if ($kategoriuser === 'opd') {
            return view('home/index_opd', $data);
        } else {
            return view('home/index_masyarakat', $data);
        }
    }
}
