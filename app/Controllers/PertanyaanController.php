<?php

namespace App\Controllers;


use App\Models\Pertanyaan;

class PertanyaanController extends BaseController
{
    protected $pertanyaan;

    public function __construct()
    {
        $this->pertanyaan = new Pertanyaan();
    }

    public function index(): string
    {
        $data = [
            'title' => 'Data Pertanyaan'
        ];

        return view('pertanyaan/index', $data);
    }

    public function getData()
    {
        try {
            if (!$this->request->isAJAX()) {
                return $this->response->setStatusCode(400)->setJSON(['data'=>[]]);
            }

            $draw   = (int) $this->request->getPost('draw');
            $start  = (int) $this->request->getPost('start');   // offset
            $length = (int) $this->request->getPost('length');  // limit
            $search = $this->request->getPost('search')['value'] ?? '';
            $order = $this->request->getPost('order')[0] ?? [];
            $columns = $this->request->getPost('columns');
            $orderIndex = (int) ($order['column'] ?? 0);
            $orderBy = $columns[$orderIndex]['data'] ?? 'id';
            $orderDir = $order['dir'] ?? 'ASC';
            $orderBy = [
                'pertanyaan' => 'pertanyaan',
                'jawaban'    => 'jawaban',
            ][$orderBy] ?? 'id';

            $recordsTotal    = $this->pertanyaan->countAll();
            $recordsFiltered = $this->pertanyaan->countFiltered($search);
            $rows            = $this->pertanyaan->getPage($search, $length, $start, $orderBy, $orderDir);

            $data = [];
            foreach ($rows as $r) {

                // btn
                $btn = '<div class="user-table-actions">
                            <a href="'.base_url('setting-pertanyaan/edit/'.$r['id']).'" class="btn btn-xs btn-outline-warning" title="Edit" aria-label="Edit">
                                <i class="bx bx-edit-alt"></i>
                            </a>
                            <a href="'.base_url('setting-pertanyaan/delete/'.$r['id']).'" class="btn btn-xs btn-outline-danger" title="Hapus" aria-label="Hapus" onclick="return confirmDelete(\''.base_url('setting-pertanyaan/delete/'.$r['id']).'\')">
                                <i class="bx bx-trash"></i>
                            </a>
                        </div>';

                $data[] = [
                    'pertanyaan' => $r['pertanyaan'] ?? '-',
                    'jawaban'    => $r['jawaban'] ?? '-',
                    'action'     => $btn,
                ];
            }

            return $this->response->setJSON([
                'draw'            => $draw,
                'recordsTotal'    => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data'            => $data,
                'csrf'            => function_exists('csrf_hash') ? csrf_hash() : null,
            ]);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function create()
    {
        $data = [
            'url'       => site_url('setting-pertanyaan/store'),
            'button'    => 'Simpan',
            'title'     => 'Tambah Pertanyaan',
            'id'        => old('id'),
            'pertanyaan' => old('pertanyaan'),
            'jawaban' => old('jawaban')
        ];
        
        return view('pertanyaan/form', $data);
    }

    public function store()
    {
        $rules = [
            'pertanyaan' => [
                'label' => 'Pertanyaan',
                'rules' => 'required',
            ],
            'jawaban' => [
                'label' => 'Jawaban',
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
                'pertanyaan' => $this->request->getPost('pertanyaan'),
                'jawaban'    => $this->request->getPost('jawaban'),
                'created_at' => $now,
                'created_by' => $userId
            ];

            $pertanyaanTable = $db->table('st_pertanyaanumum');

            if (!$pertanyaanTable->insert($data)) {
                $error = $db->error();

                throw new \RuntimeException(
                    'Gagal insert pertanyaan: ' . ($error['code'] ?? '') . ' - ' . ($error['message'] ?? '')
                );
            }

            if ($db->transStatus() === false) {
                throw new \RuntimeException('DB transaction failed');
            }

            $db->transCommit();

            return redirect()->to('/setting-pertanyaan')->with('success', 'Berhasil menambahkan pertanyaan');

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

    public function edit($id)
    {
        $db  = \Config\Database::connect();
        $row = $this->pertanyaan->getById($id);

        $data = [
            'url'        => site_url('setting-pertanyaan/update'),
            'button'     => 'Simpan Perubahan',
            'title'      => 'Edit Pertanyaan',
            'id'         => old('id', $row['id']),
            'pertanyaan' => old('pertanyaan', $row['pertanyaan']),
            'jawaban'    => old('jawaban', $row['jawaban'])
        ];

        return view('pertanyaan/form', $data);
    }

    public function update()
    {
        $id = (int) $this->request->getPost('id');

        if (!$id) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', [
                    'general' => 'ID pertanyaan tidak valid',
                ]);
        }

        $rules = [
            'pertanyaan' => [
                'label' => 'Pertanyaan',
                'rules' => 'required',
            ],
            'jawaban' => [
                'label' => 'Jawaban',
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
        $pertanyaanTable = $db->table('st_pertanyaanumum');

        $db->transBegin();

        try {

            $existingpertanyaan = $pertanyaanTable
                ->where('id', $id)
                ->get()
                ->getRow();

            if (!$existingpertanyaan) {
                throw new \RuntimeException('pertanyaan tidak ditemukan');
            }

            $data = [
                'pertanyaan' => $this->request->getPost('pertanyaan'),
                'jawaban'    => $this->request->getPost('jawaban'),
                'updated_at' => $now,
                'updated_by' => $userId
            ];

            $updated = $pertanyaanTable
                ->where('id', $id)
                ->update($data);

            if (!$updated) {

                $error = $db->error();

                throw new \RuntimeException(
                    'Gagal update pertanyaan: '
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

            return redirect()->to('/setting-pertanyaan')->with('success', 'Berhasil memperbarui data');

        } catch (\Throwable $e) {

            $db->transRollback();

            log_message(
                'error',
                'Update pertanyaan gagal: ' . $e->getMessage()
            );

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', [
                    'general' => $e->getMessage(),
                ]);
        }
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {

            $row = $this->pertanyaan->getById($id);

            if (!$row) {
                throw new \RuntimeException('pertanyaan tidak ditemukan');
            }

            /*
            * Hapus pertanyaan dari database
            */
            $deleted = $db->table('st_pertanyaanumum')
                ->where('id', $id)
                ->delete();

            if (!$deleted) {
                $error = $db->error();

                throw new \RuntimeException(
                    'Gagal menghapus pertanyaan: '
                    . ($error['code'] ?? '')
                    . ' - '
                    . ($error['message'] ?? '')
                );
            }

            /*
            * Pastikan transaksi sehat
            */
            if ($db->transStatus() === false) {
                throw new \RuntimeException(
                    'Database transaction failed'
                );
            }

            /*
            * Commit DB dahulu
            */
            $db->transCommit();

            return redirect()
                ->to('/setting-pertanyaan')
                ->with(
                    'success',
                    'Berhasil hapus data'
                );

        } catch (\Throwable $e) {

            $db->transRollback();

            log_message(
                'error',
                'Delete pertanyaan gagal ID '
                . $id
                . ': '
                . $e->getMessage()
            );

            return redirect()
                ->to('/setting-pertanyaan')
                ->with(
                    'error',
                    'Gagal hapus data: ' . $e->getMessage()
                );
        }
    }
}
