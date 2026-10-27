<?php

namespace App\Controllers;



use App\Models\Ruang;
use App\Models\PeminjamanRuang;

class KalenderPinjamRuangController extends BaseController
{
    protected $ruang;
    protected $peminjamanRuang;

    public function __construct()
    {
        $this->ruang = new Ruang();
        $this->peminjamanRuang = new PeminjamanRuang();
    }

    public function index(): string
    {
        $role = '';

        if (in_groups('admin')) {
            $role = 'admin';
        } elseif (in_groups('useropd')) {
            $role = 'useropd';
        }
        
        $ruangId = trim((string) $this->request->getGet('ruang_id'));
        $getruang = $this->ruang->getAll();
        $getjadwal = $this->peminjamanRuang->getPublicCalendarEvents('', '', $ruangId);

        $data = [
            'title'      => 'Kalender Pinjam Ruang',
            'ruangdata'  => $getruang,
            'jadwaldata' => $getjadwal,
            'ruang_id'   => $ruangId,
            'role'       => $role
        ];

        return view('kalender-pinjam-ruang/index', $data);
    }
}
