<?php

namespace App\Controllers;

use App\Models\Slider;

class Landing extends BaseController
{

    protected $slider;

    public function __construct()
    {
        $this->slider = new Slider();
    }

    public function index(): string
    {
        $getdataslider = $this->slider->getsliderisshow();

        $data = [
            'title' => 'Landing Page',
            'sliderdata' => $getdataslider,
        ];

        return view('landing/index', $data);
    }
}
