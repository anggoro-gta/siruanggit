<?php

namespace App\Controllers;

class Landing extends BaseController
{
    public function index(): string
    {
        $data = [
            'tittle' => 'Landing Page',
        ];

        return view('landing/index', $data);
    }
}
