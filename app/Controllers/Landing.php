<?php

namespace App\Controllers;

use App\Models\Slider;
use App\Models\TentangKami;

class Landing extends BaseController
{

    protected $slider;
    protected $tentangkami;

    public function __construct()
    {
        $this->slider = new Slider();
        $this->tentangkami = new TentangKami();
    }

    public function index(): string
    {
        $getdataslider = $this->slider->getsliderisshow();
        $gettentangkami = $this->tentangkami->gettentangkami();

        $data = [
            'title' => 'Landing Page',
            'sliderdata' => $getdataslider,
            'tentangkamidata' => $gettentangkami,
        ];

        return view('landing/index', $data);
    }
}
