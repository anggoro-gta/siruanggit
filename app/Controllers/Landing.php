<?php

namespace App\Controllers;

use App\Models\Slider;
use App\Models\TentangKami;
use App\Models\Pertanyaan;
use App\Models\KontakKami;
use App\Models\Ruang;

class Landing extends BaseController
{

    protected $slider;
    protected $tentangkami;
    protected $pertanyaan;
    protected $kontakkami;
    protected $ruang;

    public function __construct()
    {
        $this->slider = new Slider();
        $this->tentangkami = new TentangKami();
        $this->pertanyaan = new Pertanyaan();
        $this->kontakkami = new KontakKami();
        $this->ruang = new Ruang();
    }

    public function index(): string
    {
        $getdataslider = $this->slider->getsliderisshow();
        $gettentangkami = $this->tentangkami->gettentangkami();
        $getpertanyaan = $this->pertanyaan->getAll();    
        $getkontakkami = $this->kontakkami->getAll();
        $getruang = $this->ruang->getAll();

        $dataRuangan = [];

        foreach ($getruang as $ruang) {
            $slug = url_title($ruang['nama_ruang'], '-', true);

            $foto = [];

            foreach (['foto1', 'foto2', 'foto3', 'foto4'] as $field) {
                if (!empty($ruang[$field])) {
                    $foto[] = base_url('upload/ruang/' . $ruang[$field]);
                }
            }

            $dataRuangan[$slug] = [
                'nama'             => $ruang['nama_ruang'],
                'alamat'           => $ruang['alamat'],
                'notelp'           => $ruang['telppj'] ?? '-',
                'penanggungjawab'  => $ruang['namapj'] ?? '-',
                'luas'             => $ruang['luas_ruang'] ?? '-',
                'jumlahkursi'      => $ruang['jml_kursi'] ?? '-',
                'jumlahmeja'       => $ruang['jml_meja'] ?? '-',
                'fasilitas'        => $ruang['fasilitas'] ?? '-',
                'foto'             => $foto,
                'googlemaps_url'   => 'https://www.google.com/maps?q='
                    . $ruang['latitude'] . ',' . $ruang['longitude'],
            ];
        }

        $data = [
            'title' => 'Landing Page',
            'sliderdata' => $getdataslider,
            'tentangkamidata' => $gettentangkami,
            'pertanyaandata' => $getpertanyaan,
            'kontakkamidata' => $getkontakkami,
            'ruangdata'    => $getruang,
            'dataRuangan'  => $dataRuangan,
        ];

        return view('landing/index', $data);
    }
}
