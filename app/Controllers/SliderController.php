<?php

namespace App\Controllers;


use App\Models\Slider;

class SliderController extends BaseController
{
    protected $slider;

    public function __construct()
    {
        $this->slider = new Slider();
    }

    public function index(): string
    {
        $data = [
            'title' => 'Data Slider'
        ];

        return view('slider/index', $data);
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
                'nourut'   => 'nourut',
            ][$orderBy] ?? 'nourut';

            $recordsTotal    = $this->slider->countAll();
            $recordsFiltered = $this->slider->countFiltered($search);
            $rows            = $this->slider->getPage($search, $length, $start, $orderBy, $orderDir);

            $data = [];
            foreach ($rows as $r) {

                // btn
                $btn = '<div class="user-table-actions">
                            <a href="'.base_url('master-slider/edit/'.$r['id']).'" class="btn btn-xs btn-outline-warning" title="Edit" aria-label="Edit">
                                <i class="bx bx-edit-alt"></i>
                            </a>
                            <a href="'.base_url('master-slider/delete/'.$r['id']).'" class="btn btn-xs btn-outline-danger" title="Hapus" aria-label="Hapus" onclick="return confirmDelete(\''.base_url('master-slider/delete/'.$r['id']).'\')">
                                <i class="bx bx-trash"></i>
                            </a>
                        </div>';

                // gambar slide
                $gambar_slide = '';
                if(!empty($r['file_slider'])) {
                    $gambar_slide = '<a href="' . base_url('upload/slider/' . $r['file_slider']) . '" target="_blank"><img src="' . base_url('upload/slider/' . $r['file_slider']) . '" width="50%" class="gambar"></a>';
                }
                $data[] = [
                    'nourut'       => $r['nourut'] ?? '-',
                    'gambar_slide' => $gambar_slide,
                    'is_show'      => $r['is_show']==1 ? '<small><badge class="badge bg-label-success">Ya</badge></small>' : '<small><badge class="badge bg-label-secondary">Tidak</badge></small>',
                    'action'       => $btn,
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
            'url'         => site_url('master-slider/store'),
            'button'      => 'Simpan',
            'title'       => 'Tambah Slider',
            'id'          => old('id'),
            'nourut'      => old('nourut'),
            'file_slider' => old('file_slider'),
            'is_show'     => old('is_show', 1)
        ];
        
        return view('slider/form', $data);
    }

    public function store()
    {
        $rules = [
            'nourut' => [
                'label' => 'No. Urut',
                'rules' => 'required',
            ],
            'file_slider' => [
                'label' => 'Gambar',
                'rules' => 'uploaded[file_slider]|is_image[file_slider]|mime_in[file_slider,image/jpg,image/jpeg,image/png,image/webp]|max_size[file_slider,2048]',
            ],
            'is_show' => [
                'label' => 'Ditampilkan',
                'rules' => 'required',
            ],
        ];

        if (!$this->validate($rules)) {
            dd($this->validator->getErrors());
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
            $nomorBaru = null;
            $kodeSlider = null;

            $counter = $db->query("
                SELECT nomor
                FROM kode_counter
                WHERE nama_kode = 'slider'
                FOR UPDATE
            ")->getRow();

            if (!$counter) {
                $row = $db->table('ms_slider')
                    ->orderBy('kode_slider', 'DESC')
                    ->get()
                    ->getRow();

                $lastSlideCounter = 0;

                if ($row) {
                    $string = $row->kode_slider;
                    $lastSlideCounter = (int) preg_replace('/\D/', '', $string);
                }

                $db->table('kode_counter')->insert([
                    'nama_kode' => 'slider',
                    'nomor' => $lastSlideCounter,
                ]);

                // Tetapkan nilai counter setelah insert
                $counter = (object) [
                    'nomor' => $lastSlideCounter,
                ];
            }

            $nomorBaru = (int) $counter->nomor + 1;
            $kodeSlider = 'SLD-' . str_pad(
                $nomorBaru,
                7,
                '0',
                STR_PAD_LEFT
            );

            $data = [
                'nourut'     => $this->request->getPost('nourut'),
                'is_show'    => $this->request->getPost('is_show'),
                'kode_slider' => $kodeSlider,
                'created_at' => $now,
                'created_by' => $userId
            ];

            $sliderTable = $db->table('ms_slider');

            if (!$sliderTable->insert($data)) {
                $error = $db->error();

                throw new \RuntimeException(
                    'Gagal insert slider: ' . ($error['code'] ?? '') . ' - ' . ($error['message'] ?? '')
                );
            }

            $lastId = $db->insertID();

            if (!$lastId) {
                throw new \RuntimeException('ID user tidak ditemukan');
            }

            $updated = $db->table('kode_counter')
                ->where('nama_kode', 'slider')
                ->update([
                    'nomor' => $nomorBaru,
                ]);

            if (!$updated) {
                throw new \RuntimeException('Counter slider gagal diperbarui');
            }

            $file = $this->request->getFile('file_slider');

            if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
                if (!$file->isValid() || $file->hasMoved()) {
                    throw new \RuntimeException('File gagal diupload');
                }

                $allowedExt = [
                    'jpg',
                    'jpeg',
                    'png',
                    'webp'
                ];

                $ext = strtolower($file->getClientExtension() ?? '');
                $mime = strtolower($file->getMimeType() ?? '');

                $isAllowed = in_array($ext, $allowedExt, true)
                    && (
                        str_starts_with($mime, 'image/')
                    );

                if (!$isAllowed) {
                    throw new \RuntimeException(
                        'File harus berupa gambar'
                    );
                }

                $dir = FCPATH . 'upload/slider/';

                if (!is_dir($dir) && !mkdir($dir, 0775, true)) {
                    throw new \RuntimeException(
                        'Folder upload gagal dibuat'
                    );
                }

                $newName = $kodeSlider . '_'
                    . date('YmdHis')
                    . '.' . $ext;

                $file->move($dir, $newName);
                $movedFile = $dir . $newName;

                if (!$sliderTable
                    ->where('id', $lastId)
                    ->update([
                        'file_slider' => $newName,
                    ])
                ) {
                    throw new \RuntimeException(
                        'Nama file gagal disimpan'
                    );
                }
            }

            if ($db->transStatus() === false) {
                throw new \RuntimeException('DB transaction failed');
            }

            $db->transCommit();

            return redirect()->to('/master-slider')->with('success', 'Berhasil menambahkan slider');

        } catch (\Throwable $e) {
            $db->transRollback();

            if ($movedFile && is_file($movedFile)) {
                unlink($movedFile);
            }

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
        $row = $this->slider->getById($id);

        $data = [
            'url'         => site_url('master-slider/update'),
            'button'      => 'Simpan Perubahan',
            'title'       => 'Edit Slider',
            'id'          => old('id', $row['id']),
            'nourut'      => old('nourut', $row['nourut']),
            'file_slider' => old('file_slider', $row['file_slider']),
            'is_show'     => old('is_show', $row['is_show'])
        ];

        return view('slider/form', $data);
    }

    public function update()
    {
        $id = (int) $this->request->getPost('id');

        if (!$id) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', [
                    'general' => 'ID slider tidak valid',
                ]);
        }

        $rules = [
            'nourut' => [
                'label' => 'No. Urut',
                'rules' => 'required',
            ],
            'file_slider' => [
                'label' => 'Gambar',
                'rules' => 'permit_empty|is_image[file_slider]|mime_in[file_slider,image/jpg,image/jpeg,image/png,image/webp]|max_size[file_slider,2048]',
            ],
            'is_show' => [
                'label' => 'Ditampilkan',
                'rules' => 'required',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $loginUserId = user()->id ?? null;
        $now = date('Y-m-d H:i:s');

        $db = \Config\Database::connect();
        $sliderTable = $db->table('ms_slider');

        $movedFile = null;
        $newName = null;
        $oldFileName = null;

        $db->transBegin();

        try {

            $existingSlider = $sliderTable
                ->where('id', $id)
                ->get()
                ->getRow();

            if (!$existingSlider) {
                throw new \RuntimeException('Slider tidak ditemukan');
            }

            $kodeSlider = null;

            $nomorBaru = null;
            $generateKodeBaru = false;

            if (!empty($existingSlider->kode_slider)) {

                $kodeSlider = $existingSlider->kode_slider;

            } else {
                $counter = $db->query("
                    SELECT nomor
                    FROM kode_counter
                    WHERE nama_kode = 'slider'
                    FOR UPDATE
                ")->getRow();

                if (!$counter) {
                    throw new \RuntimeException(
                        'Counter slider belum tersedia'
                    );
                }

                $nomorBaru = (int) $counter->nomor + 1;

                $kodeSlider = 'SLD-' . str_pad(
                    $nomorBaru,
                    7,
                    '0',
                    STR_PAD_LEFT
                );

                $generateKodeBaru = true;
            }
            /*
            * ============================
            * DATA UPDATE
            * ============================
            */

            $data = [
                'nourut'     => $this->request->getPost('nourut'),
                'is_show'    => $this->request->getPost('is_show'),
                'kode_slider' => $kodeSlider,
                'updated_at' => $now
            ];

            $updated = $sliderTable
                ->where('id', $id)
                ->update($data);

            if (!$updated) {

                $error = $db->error();

                throw new \RuntimeException(
                    'Gagal update slider: '
                    . ($error['code'] ?? '')
                    . ' - '
                    . ($error['message'] ?? '')
                );
            }

            /*
            * ============================
            * UPDATE COUNTER
            * ============================
            */

            if ($generateKodeBaru) {

                $counterUpdated = $db->table('kode_counter')
                    ->where('nama_kode', 'slider')
                    ->update([
                        'nomor' => $nomorBaru,
                    ]);

                if (!$counterUpdated) {
                    throw new \RuntimeException(
                        'Counter slider gagal diperbarui'
                    );
                }
            }

            $file = $this->request->getFile('file_slider');

            if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {

                if (!$file->isValid() || $file->hasMoved()) {
                    throw new \RuntimeException(
                        'File gagal diupload'
                    );
                }

                $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];

                $ext = strtolower($file->getClientExtension() ?? '');

                $mime = strtolower($file->getMimeType() ?? '');

                $isAllowed = in_array($ext, $allowedExt, true) && (str_starts_with($mime, 'image/'));

                if (!$isAllowed) {
                    throw new \RuntimeException(
                        'File harus berupa gambar'
                    );
                }

                $dir = FCPATH . 'upload/slider/';

                if (!is_dir($dir) && !mkdir($dir, 0775, true)) {
                    throw new \RuntimeException(
                        'Folder upload gagal dibuat'
                    );
                }

                $oldFileName = $existingSlider->file_slider ?? null;

                $newName = $kodeSlider . '_' . date('YmdHis') . '.' . $ext;

                $file->move($dir, $newName);

                $movedFile = $dir . $newName;

                $fileUpdated = $sliderTable->where('id', $id)->update(['file_slider' => $newName]);

                if (!$fileUpdated) {
                    throw new \RuntimeException(
                        'Nama file gagal disimpan'
                    );
                }
            }

            /*
            * ============================
            * CEK TRANSAKSI
            * ============================
            */

            if ($db->transStatus() === false) {
                throw new \RuntimeException(
                    'DB transaction failed'
                );
            }

            $db->transCommit();

            /*
            * Hapus file lama SETELAH commit.
            */
            if ($oldFileName && $newName && $oldFileName !== $newName) {
                $oldPath =
                    FCPATH
                    . 'upload/slider/'
                    . $oldFileName;

                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
            }
            
            return redirect()->to('/master-slider')->with('success', 'Berhasil memperbarui data');

        } catch (\Throwable $e) {

            $db->transRollback();

            /*
            * Kalau file baru sudah dipindah
            * tetapi DB gagal, hapus file baru.
            */
            if (
                $movedFile &&
                is_file($movedFile)
            ) {
                unlink($movedFile);
            }

            log_message(
                'error',
                'Update slider gagal: ' . $e->getMessage()
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

        $fileToDelete = null;

        try {

            $row = $this->slider->getById($id);

            if (!$row) {
                throw new \RuntimeException('User tidak ditemukan');
            }

            /*
            * Simpan path file dulu,
            * jangan dihapus sebelum commit.
            */
            if (!empty($row['file_slider'])) {
                $fileToDelete = FCPATH
                    . 'upload/slider/'
                    . $row['file_slider'];
            }

            /*
            * Hapus user dari database
            */
            $deleted = $db->table('ms_slider')
                ->where('id', $id)
                ->delete();

            if (!$deleted) {
                $error = $db->error();

                throw new \RuntimeException(
                    'Gagal menghapus slider: '
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

            /*
            * Baru hapus file fisik
            */
            if ($fileToDelete && is_file($fileToDelete)) {

                if (!unlink($fileToDelete)) {
                    log_message(
                        'error',
                        'Gagal menghapus file slider: '
                        . $fileToDelete
                    );
                }
            }

            return redirect()
                ->to('/master-slider')
                ->with(
                    'success',
                    'Berhasil hapus data'
                );

        } catch (\Throwable $e) {

            $db->transRollback();

            log_message(
                'error',
                'Delete slider gagal ID '
                . $id
                . ': '
                . $e->getMessage()
            );

            return redirect()
                ->to('/master-slider')
                ->with(
                    'error',
                    'Gagal hapus data: ' . $e->getMessage()
                );
        }
    }
}
