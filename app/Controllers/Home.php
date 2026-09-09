<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'tittle' => 'SiRuang | Kab. Kediri',
        ];

        return view('home/index', $data);
    }
}
