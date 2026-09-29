<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'SiRuang | Kab. Kediri',
        ];

        return view('home/index', $data);
    }
}
