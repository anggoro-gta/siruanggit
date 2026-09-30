<?php

namespace App\Controllers;


use App\Models\TentangKami;

class TentangKamiController extends BaseController
{
    protected $tentang_kami;

    public function __construct()
    {
        $this->tentang_kami = new TentangKami();
    }

    public function index(): string
    {
        $row = $this->tentang_kami
            ->orderBy('id', 'ASC')
            ->first();

        $url = site_url('setting-tentang-kami/store');
        $button = 'Simpan';

        if ($row !== null) {
            $url = site_url('setting-tentang-kami/update');
            $button = 'Simpan Perubahan';
        }

        $data = [
            'title'  => 'Data Tentang Kami',
            'url'    => $url,
            'button' => $button,
            'row'    => $row ?? [],
        ];

        return view('tentang-kami/index', $data);
    }

    public function store()
    {
        $rules = [
            'judul' => [
                'label' => 'Judul',
                'rules' => 'required',
            ],
            'isi' => [
                'label' => 'Isi',
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
                'judul'      => $this->request->getPost('judul'),
                'isi'        => $this->request->getPost('isi'),
                'created_at' => $now,
                'created_by' => $userId
            ];

            $tentangKamiTable = $db->table('st_tentangkami');

            if (!$tentangKamiTable->insert($data)) {
                $error = $db->error();

                throw new \RuntimeException(
                    'Gagal insert tentang kami: ' . ($error['code'] ?? '') . ' - ' . ($error['message'] ?? '')
                );
            }

            if ($db->transStatus() === false) {
                throw new \RuntimeException('DB transaction failed');
            }

            $db->transCommit();

            return redirect()->to('/setting-tentang-kami')->with('success', 'Berhasil simpan tentang kami');

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
            'judul' => [
                'label' => 'Judul',
                'rules' => 'required',
            ],
            'isi' => [
                'label' => 'Isi',
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
        $tentangKamiTable = $db->table('st_tentangkami');

        $db->transBegin();

        try {

            $existingtentangKamiTable = $tentangKamiTable
                ->where('id', $id)
                ->get()
                ->getRow();

            if (!$existingtentangKamiTable) {
                throw new \RuntimeException('tentang kami tidak ditemukan');
            }

            $data = [
                'judul'      => $this->request->getPost('judul'),
                'isi'        => $this->request->getPost('isi'),
                'updated_at' => $now,
                'updated_by' => $userId,
            ];

            $updated = $tentangKamiTable
                ->where('id', $id)
                ->update($data);

            if (!$updated) {

                $error = $db->error();

                throw new \RuntimeException(
                    'Gagal update tentang kami: '
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

            return redirect()->to('/setting-tentang-kami')->with('success', 'Berhasil memperbarui data');

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
