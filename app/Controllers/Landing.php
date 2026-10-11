<?php

namespace App\Controllers;

use App\Models\Slider;
use App\Models\TentangKami;
use App\Models\Pertanyaan;
use App\Models\KontakKami;

class Landing extends BaseController
{

    protected $slider;
    protected $tentangkami;
    protected $pertanyaan;
    protected $kontakkami;

    public function __construct()
    {
        $this->slider = new Slider();
        $this->tentangkami = new TentangKami();
        $this->pertanyaan = new Pertanyaan();
        $this->kontakkami = new KontakKami();
    }

    public function index(): string
    {
        $getdataslider = $this->slider->getsliderisshow();
        $gettentangkami = $this->tentangkami->gettentangkami();
        $getpertanyaan = $this->pertanyaan->getAll();    
        $getkontakkami = $this->kontakkami->getAll();

        $data = [
            'title' => 'Landing Page',
            'sliderdata' => $getdataslider,
            'tentangkamidata' => $gettentangkami,
            'pertanyaandata' => $getpertanyaan,
            'kontakkamidata' => $getkontakkami,
        ];

        return view('landing/index', $data);
    }
}
