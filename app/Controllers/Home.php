<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $kategoriuser = user()->kategori;

         $data = [
            'title' => 'SiRuang | Kab. Kediri',
        ];
        
        if ($kategoriuser === 'admin') {
            return view('home/index', $data);
        } else if ($kategoriuser === 'opd') {
            return view('home/index_opd', $data);
        } else {
            return view('home/index_masyarakat', $data);
        }

        
    }
}
