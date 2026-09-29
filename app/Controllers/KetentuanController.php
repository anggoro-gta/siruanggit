<?php

namespace App\Controllers;


use App\Models\Ketentuan;

class KetentuanController extends BaseController
{
    protected $ketentuan;

    public function __construct()
    {
        $this->ketentuan = new Ketentuan();
    }

    public function index(): string
    {
        $data = [
            'title' => 'Data Ketentuan'
        ];

        return view('ketentuan/index', $data);
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
                'ketentuan'   => 'ketentuan',
            ][$orderBy] ?? 'id';

            $recordsTotal    = $this->ketentuan->countAll();
            $recordsFiltered = $this->ketentuan->countFiltered($search);
            $rows            = $this->ketentuan->getPage($search, $length, $start, $orderBy, $orderDir);

            $data = [];
            foreach ($rows as $r) {

                // btn
                $btn = '<div class="user-table-actions">
                            <a href="'.base_url('master-ketentuan/edit/'.$r['id']).'" class="btn btn-xs btn-outline-warning" title="Edit" aria-label="Edit">
                                <i class="bx bx-edit-alt"></i>
                            </a>
                            <a href="'.base_url('master-ketentuan/delete/'.$r['id']).'" class="btn btn-xs btn-outline-danger" title="Hapus" aria-label="Hapus" onclick="return confirmDelete(\''.base_url('master-ketentuan/delete/'.$r['id']).'\')">
                                <i class="bx bx-trash"></i>
                            </a>
                        </div>';

                $data[] = [
                    'ketentuan' => $r['ketentuan'] ?? '-',
                    'action'    => $btn,
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
            'url'       => site_url('master-ketentuan/store'),
            'button'    => 'Simpan',
            'title'     => 'Tambah Ketentuan',
            'id'        => old('id'),
            'ketentuan' => old('ketentuan')
        ];
        
        return view('ketentuan/form', $data);
    }

    public function store()
    {
        $rules = [
            'ketentuan' => [
                'label' => 'Ketentuan',
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

        $movedFile = null;

        $db->transBegin();

        try {
            $data = [
                'ketentuan'  => $this->request->getPost('ketentuan'),
                'created_at' => $now,
                'created_by' => $userId
            ];

            $ketentuanTable = $db->table('ms_ketentuan');

            if (!$ketentuanTable->insert($data)) {
                $error = $db->error();

                throw new \RuntimeException(
                    'Gagal insert ketentuan: ' . ($error['code'] ?? '') . ' - ' . ($error['message'] ?? '')
                );
            }

            if ($db->transStatus() === false) {
                throw new \RuntimeException('DB transaction failed');
            }

            $db->transCommit();

            return redirect()->to('/master-ketentuan')->with('success', 'Berhasil menambahkan ketentuan');

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
        $row = $this->ketentuan->getById($id);

        $data = [
            'url'       => site_url('master-ketentuan/update'),
            'button'    => 'Simpan Perubahan',
            'title'     => 'Edit Ketentuan',
            'id'        => old('id', $row['id']),
            'ketentuan' => old('ketentuan', $row['ketentuan'])
        ];

        return view('ketentuan/form', $data);
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
            'ketentuan' => [
                'label' => 'Ketentuan',
                'rules' => 'required',
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $now = date('Y-m-d H:i:s');

        $db = \Config\Database::connect();
        $ketentuanTable = $db->table('ms_ketentuan');

        $db->transBegin();

        try {

            $existingketentuan = $ketentuanTable
                ->where('id', $id)
                ->get()
                ->getRow();

            if (!$existingketentuan) {
                throw new \RuntimeException('ketentuan tidak ditemukan');
            }

            $data = [
                'ketentuan'  => $this->request->getPost('ketentuan'),
                'updated_at' => $now
            ];

            $updated = $ketentuanTable
                ->where('id', $id)
                ->update($data);

            if (!$updated) {

                $error = $db->error();

                throw new \RuntimeException(
                    'Gagal update ketentuan: '
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

            return redirect()->to('/master-ketentuan')->with('success', 'Berhasil memperbarui data');

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

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {

            $row = $this->ketentuan->getById($id);

            if (!$row) {
                throw new \RuntimeException('ketentuan tidak ditemukan');
            }

            /*
            * Hapus ketentuan dari database
            */
            $deleted = $db->table('ms_ketentuan')
                ->where('id', $id)
                ->delete();

            if (!$deleted) {
                $error = $db->error();

                throw new \RuntimeException(
                    'Gagal menghapus ketentuan: '
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
                ->to('/master-ketentuan')
                ->with(
                    'success',
                    'Berhasil hapus data'
                );

        } catch (\Throwable $e) {

            $db->transRollback();

            log_message(
                'error',
                'Delete ketentuan gagal ID '
                . $id
                . ': '
                . $e->getMessage()
            );

            return redirect()
                ->to('/master-ketentuan')
                ->with(
                    'error',
                    'Gagal hapus data: ' . $e->getMessage()
                );
        }
    }
}
