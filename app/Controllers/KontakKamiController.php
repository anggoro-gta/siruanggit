<?php

namespace App\Controllers;


use App\Models\KontakKami;

class KontakKamiController extends BaseController
{
    protected $kontak_kami;

    public function __construct()
    {
        $this->kontak_kami = new KontakKami();
    }

    public function index(): string
    {
        $row = $this->kontak_kami
            ->orderBy('id', 'ASC')
            ->first();

        $url = site_url('setting-kontak-kami/store');
        $button = 'Simpan';

        if ($row !== null) {
            $url = site_url('setting-kontak-kami/update');
            $button = 'Simpan Perubahan';
        }

        $data = [
            'title'  => 'Data Kontak Kami',
            'url'    => $url,
            'button' => $button,
            'row'    => $row ?? [],
        ];

        return view('kontak-kami/index', $data);
    }

    public function store()
    {
        $rules = [
            'email' => [
                'label' => 'Email',
                'rules' => 'required',
            ],
            'telp' => [
                'label' => 'Telepon',
                'rules' => 'required',
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required',
            ],
            'latitude' => [
                'label' => 'Latitude',
                'rules' => 'required',
            ],
            'longitude' => [
                'label' => 'Longitude',
                'rules' => 'required',
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userId = user()->id ?? null;
        $now = date('Y-m-d H:i:s');
        $db = \Config\Database::connect();

        $db->transBegin();

        try {
            $data = [
                'email'      => $this->request->getPost('email'),
                'telp'       => $this->request->getPost('telp'),
                'alamat'     => $this->request->getPost('alamat'),
                'latitude'   => $this->request->getPost('latitude'),
                'longitude'  => $this->request->getPost('longitude'),
                'created_at' => $now,
                'created_by' => $userId
            ];

            $kontakKamiTable = $db->table('st_kontakkami');

            if (!$kontakKamiTable->insert($data)) {
                $error = $db->error();

                throw new \RuntimeException(
                    'Gagal insert kontak kami: ' . ($error['code'] ?? '') . ' - ' . ($error['message'] ?? '')
                );
            }

            if ($db->transStatus() === false) {
                throw new \RuntimeException('DB transaction failed');
            }

            $db->transCommit();

            return redirect()->to('/setting-kontak-kami')->with('success', 'Berhasil simpan kontak kami');

        } catch (\Throwable $e) {
            $db->transRollback();

            log_message('error', $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', [
                    'general' => $e->getMessage(),
                ]);
        }
    }

    public function update()
    {
        $id = (int) $this->request->getPost('id');

        if (!$id) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', [
                    'general' => 'ID ketentuan tidak valid',
                ]);
        }

        $rules = [
            'email' => [
                'label' => 'Email',
                'rules' => 'required',
            ],
            'telp' => [
                'label' => 'Telepon',
                'rules' => 'required',
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required',
            ],
            'latitude' => [
                'label' => 'Latitude',
                'rules' => 'required',
            ],
            'longitude' => [
                'label' => 'Longitude',
                'rules' => 'required',
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userId = user()->id ?? null;
        $now = date('Y-m-d H:i:s');

        $db = \Config\Database::connect();
        $kontakKamiTable = $db->table('st_kontakkami');

        $db->transBegin();

        try {

            $existingkontakKamiTable = $kontakKamiTable
                ->where('id', $id)
                ->get()
                ->getRow();

            if (!$existingkontakKamiTable) {
                throw new \RuntimeException('kontak kami tidak ditemukan');
            }

            $data = [
                'email'      => $this->request->getPost('email'),
                'telp'       => $this->request->getPost('telp'),
                'alamat'     => $this->request->getPost('alamat'),
                'latitude'   => $this->request->getPost('latitude'),
                'longitude'  => $this->request->getPost('longitude'),
                'updated_at' => $now,
                'updated_by' => $userId,
            ];

            $updated = $kontakKamiTable
                ->where('id', $id)
                ->update($data);

            if (!$updated) {

                $error = $db->error();

                throw new \RuntimeException(
                    'Gagal update kontak kami: '
                    . ($error['code'] ?? '')
                    . ' - '
                    . ($error['message'] ?? '')
                );
            }

            if ($db->transStatus() === false) {
                throw new \RuntimeException(
                    'DB transaction failed'
                );
            }

            $db->transCommit();

            return redirect()->to('/setting-kontak-kami')->with('success', 'Berhasil memperbarui data');

        } catch (\Throwable $e) {

            $db->transRollback();

            log_message(
                'error',
                'Update ketentuan gagal: ' . $e->getMessage()
            );

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', [
                    'general' => $e->getMessage(),
                ]);
        }
    }
}
