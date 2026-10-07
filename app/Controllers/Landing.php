<?php

namespace App\Controllers;

use App\Models\Slider;
use App\Models\TentangKami;
use App\Models\Pertanyaan;

class Landing extends BaseController
{

    protected $slider;
    protected $tentangkami;
    protected $pertanyaan;

    public function __construct()
    {
        $this->slider = new Slider();
        $this->tentangkami = new TentangKami();
        $this->pertanyaan = new Pertanyaan();
    }

    public function index(): string
    {
        $getdataslider = $this->slider->getsliderisshow();
        $gettentangkami = $this->tentangkami->gettentangkami();
        $getpertanyaan = $this->pertanyaan->getAll();    

        $data = [
            'title' => 'Landing Page',
            'sliderdata' => $getdataslider,
            'tentangkamidata' => $gettentangkami,
            'pertanyaandata' => $getpertanyaan,
        ];

        return view('landing/index', $data);
    }
}
