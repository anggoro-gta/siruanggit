<?php

namespace App\Controllers;


use App\Models\Ruang;

class RuangController extends BaseController
{
    protected $ruang;

    public function __construct()
    {
        $this->ruang = new Ruang();
    }

    public function index(): string
    {
        $data = [
            'title' => 'Data Ruang'
        ];

        return view('ruang/index', $data);
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
                'id'         => 'id',
                'nama_ruang' => 'nama_ruang',
                'alamat'     => 'alamat',
                'peruntukan' => 'peruntukan'
            ][$orderBy] ?? 'id';

            $recordsTotal    = $this->ruang->countAll();
            $recordsFiltered = $this->ruang->countFiltered($search);
            $rows            = $this->ruang->getPage($search, $length, $start, $orderBy, $orderDir);

            $data = [];
            foreach ($rows as $r) {

                // btn
                $btn = '<div class="user-table-actions">
                            <a href="'.base_url('master-ruang/edit/'.$r['id']).'" class="btn btn-xs btn-outline-warning" title="Edit" aria-label="Edit">
                                <i class="bx bx-edit-alt"></i>
                            </a>
                            <a href="'.base_url('master-ruang/delete/'.$r['id']).'" class="btn btn-xs btn-outline-danger" title="Hapus" aria-label="Hapus" onclick="return confirmDelete(\''.base_url('master-ruang/delete/'.$r['id']).'\')">
                                <i class="bx bx-trash"></i>
                            </a>
                        </div>';

                //peruntukan
                $peruntukan = '-';
                if(!empty($r['peruntukan'])) {
                    if($r['peruntukan']=='dinas'){
                        $peruntukan = '<small><badge class="badge bg-label-primary">Dinas</badge></small>';
                    }else if($r['peruntukan']=='masyarakat'){
                        $peruntukan = '<small><badge class="badge bg-label-info">Masyarakat</badge></small>';
                    }
                }

                $data[] = [
                    'nama_ruang' => $r['nama_ruang'] ?? '-',
                    'alamat'     => $r['alamat'] ?? '-',
                    'peruntukan' => $peruntukan,
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
            'url'           => site_url('master-ruang/store'),
            'button'        => 'Simpan',
            'title'         => 'Tambah Ruang',
            'id'            => old('id'),
            'nama_ruang'    => old('nama_ruang'),
            'alamat'        => old('alamat'),
            'luas_ruang'    => old('luas_ruang'),
            'jml_kursi'     => old('jml_kursi'),
            'jml_meja'      => old('jml_meja'),
            'fasilitas'     => old('fasilitas'),
            'ukuran_banner' => old('ukuran_banner'),
            'foto1'         => old('foto1'),
            'foto2'         => old('foto2'),
            'foto3'         => old('foto3'),
            'foto4'         => old('foto4'),
            'peruntukan'    => old('peruntukan'),
            'namapj'        => old('namapj'),
            'telppj'        => old('telppj'),
            'harga_sewa'    => old('harga_sewa'),
            'latitude'      => old('latitude'),
            'longitude'     => old('longitude'),
        ];
        
        return view('ruang/form', $data);
    }

    public function store()
    {
        $rules = $this->rules();

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userId = user()->id ?? null;
        $now = date('Y-m-d H:i:s');
        $db = \Config\Database::connect();

        $movedFiles = [];

        $db->transBegin();

        try {
            $nomorBaru = null;
            $koderuang = null;

            $counter = $db->query("
                SELECT nomor
                FROM kode_counter
                WHERE nama_kode = 'ruang'
                FOR UPDATE
            ")->getRow();

            if (!$counter) {
                $row = $db->table('ms_ruang')
                    ->orderBy('kode_ruang', 'DESC')
                    ->get()
                    ->getRow();

                $lastCounter = 0;

                if ($row) {
                    $string = $row->kode_ruang;
                    $lastCounter = (int) preg_replace('/\D/', '', $string);
                }

                $db->table('kode_counter')->insert([
                    'nama_kode' => 'ruang',
                    'nomor' => $lastCounter,
                ]);

                // Tetapkan nilai counter setelah insert
                $counter = (object) [
                    'nomor' => $lastCounter,
                ];
            }

            $nomorBaru = (int) $counter->nomor + 1;
            $koderuang = 'RNG-' . str_pad(
                $nomorBaru,
                7,
                '0',
                STR_PAD_LEFT
            );

            $harga_sewa = $this->request->getPost('harga_sewa');

            $data = [
                'nama_ruang'    => trim((string) $this->request->getPost('nama_ruang')),
                'alamat'        => trim((string) $this->request->getPost('alamat')),
                'luas_ruang'    => (int) $this->request->getPost('luas_ruang'),
                'jml_kursi'     => (int) $this->request->getPost('jml_kursi'),
                'jml_meja'      => (int) $this->request->getPost('jml_meja'),
                'fasilitas'     => trim((string) $this->request->getPost('fasilitas')),
                'ukuran_banner' => trim((string) $this->request->getPost('ukuran_banner')),
                'peruntukan'    => trim((string) $this->request->getPost('peruntukan')),
                'namapj'        => trim((string) $this->request->getPost('namapj')),
                'telppj'        => trim((string) $this->request->getPost('telppj')),
                'harga_sewa'    => !empty($harga_sewa) ? $this->parseNumber($harga_sewa) : null,
                'latitude'      => trim((string) $this->request->getPost('latitude')),
                'longitude'     => trim((string) $this->request->getPost('longitude')),
                'kode_ruang'    => $koderuang,
                'created_at'    => $now,
                'created_by'    => $userId
            ];

            $ruangTable = $db->table('ms_ruang');

            if (!$ruangTable->insert($data)) {
                $error = $db->error();

                throw new \RuntimeException(
                    'Gagal insert ruang: ' . ($error['code'] ?? '') . ' - ' . ($error['message'] ?? '')
                );
            }

            $lastId = $db->insertID();

            if (!$lastId) {
                throw new \RuntimeException('ID ruang tidak ditemukan');
            }

            $updated = $db->table('kode_counter')
                ->where('nama_kode', 'ruang')
                ->update([
                    'nomor' => $nomorBaru,
                ]);

            if (!$updated) {
                throw new \RuntimeException('Counter ruang gagal diperbarui');
            }

            $dir = FCPATH . 'upload/ruang/';
            $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];

            $no = 1;
            foreach (['foto1', 'foto2', 'foto3', 'foto4'] as $field) {
                $foto = $this->request->getFile($field);

                // Foto bersifat opsional. Lewati field yang tidak diisi.
                if (!$foto || $foto->getError() === UPLOAD_ERR_NO_FILE) {
                    continue;
                }

                if (!$foto->isValid() || $foto->hasMoved()) {
                    throw new \RuntimeException("{$field} gagal diupload");
                }

                $ext = strtolower($foto->getClientExtension() ?? '');
                $mime = strtolower($foto->getMimeType() ?? '');

                if (!in_array($ext, $allowedExt, true) || !str_starts_with($mime, 'image/')) {
                    throw new \RuntimeException("{$field} harus berupa gambar");
                }

                if (!is_dir($dir) && !mkdir($dir, 0775, true)) {
                    throw new \RuntimeException('Folder upload gagal dibuat');
                }

                $newName = $no . '_' . $koderuang . '_' . date('YmdHis') . '.' . $ext;
                $foto->move($dir, $newName);
                $movedFiles[] = $dir . $newName;

                if (!$ruangTable->where('id', $lastId)->update([$field => $newName])) {
                    throw new \RuntimeException("Nama file {$field} gagal disimpan");
                }

                $no++;
            }

            if ($db->transStatus() === false) {
                throw new \RuntimeException('DB transaction failed');
            }

            $db->transCommit();

            return redirect()->to('/master-ruang')->with('success', 'Berhasil menambahkan ruang');

        } catch (\Throwable $e) {
            $db->transRollback();

            foreach ($movedFiles as $movedFile) {
                if (is_file($movedFile)) {
                    unlink($movedFile);
                }
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
        $row = $this->ruang->getById($id);

        $data = [
            'url'           => site_url('master-ruang/update'),
            'button'        => 'Simpan Perubahan',
            'title'         => 'Edit ruang',
            'id'            => old('id', $row['id']),
            'nama_ruang'    => old('nama_ruang', $row['nama_ruang']),
            'alamat'        => old('alamat', $row['alamat']),
            'luas_ruang'    => old('luas_ruang', $row['luas_ruang']),
            'jml_kursi'     => old('jml_kursi', $row['jml_kursi']),
            'jml_meja'      => old('jml_meja', $row['jml_meja']),
            'fasilitas'     => old('fasilitas', $row['fasilitas']),
            'ukuran_banner' => old('ukuran_banner', $row['ukuran_banner']),
            'foto1'         => old('foto1', $row['foto1']),
            'foto2'         => old('foto2', $row['foto2']),
            'foto3'         => old('foto3', $row['foto3']),
            'foto4'         => old('foto4', $row['foto4']),
            'peruntukan'    => old('peruntukan', $row['peruntukan']),
            'namapj'        => old('namapj', $row['namapj']),
            'telppj'        => old('telppj', $row['telppj']),
            'harga_sewa'    => old('harga_sewa', (int) $row['harga_sewa']),
            'latitude'      => old('latitude', $row['latitude']),
            'longitude'     => old('longitude', $row['longitude']),
        ];

        return view('ruang/form', $data);
    }

    public function update()
    {
        $id = (int) $this->request->getPost('id');

        if (!$id) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', [
                    'general' => 'ID ruang tidak valid',
                ]);
        }

        $rules = $this->rules();

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $loginUserId = user()->id ?? null;
        $now = date('Y-m-d H:i:s');

        $db = \Config\Database::connect();
        $ruangTable = $db->table('ms_ruang');

        $movedFiles = [];
        $oldFiles = [];

        $db->transBegin();

        try {

            $existingruang = $ruangTable
                ->where('id', $id)
                ->get()
                ->getRow();

            if (!$existingruang) {
                throw new \RuntimeException('Ruang tidak ditemukan');
            }

            $koderuang = null;

            if (!empty($existingruang->kode_ruang)) {

                $koderuang = $existingruang->kode_ruang;

            }
            /*
            * ============================
            * DATA UPDATE
            * ============================
            */
            $harga_sewa = $this->request->getPost('harga_sewa');
            $data = [
                'nama_ruang'    => trim((string) $this->request->getPost('nama_ruang')),
                'alamat'        => trim((string) $this->request->getPost('alamat')),
                'luas_ruang'    => (int) $this->request->getPost('luas_ruang'),
                'jml_kursi'     => (int) $this->request->getPost('jml_kursi'),
                'jml_meja'      => (int) $this->request->getPost('jml_meja'),
                'fasilitas'     => trim((string) $this->request->getPost('fasilitas')),
                'ukuran_banner' => trim((string) $this->request->getPost('ukuran_banner')),
                'peruntukan'    => trim((string) $this->request->getPost('peruntukan')),
                'namapj'        => trim((string) $this->request->getPost('namapj')),
                'telppj'        => trim((string) $this->request->getPost('telppj')),
                'harga_sewa'    => !empty($harga_sewa) ? $this->parseNumber($harga_sewa) : null,
                'latitude'      => trim((string) $this->request->getPost('latitude')),
                'longitude'     => trim((string) $this->request->getPost('longitude')),
                'updated_at'    => $now
            ];

            $updated = $ruangTable
                ->where('id', $id)
                ->update($data);

            if (!$updated) {

                $error = $db->error();

                throw new \RuntimeException(
                    'Gagal update ruang: '
                    . ($error['code'] ?? '')
                    . ' - '
                    . ($error['message'] ?? '')
                );
            }

            $dir = FCPATH . 'upload/ruang/';
            $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];

            $no = 1;
            foreach (['foto1', 'foto2', 'foto3', 'foto4'] as $field) {
                $file = $this->request->getFile($field);

                // Foto bersifat opsional; field kosong tidak diproses.
                if (!$file || $file->getError() === UPLOAD_ERR_NO_FILE) {
                    continue;
                }

                if (!$file->isValid() || $file->hasMoved()) {
                    throw new \RuntimeException("{$field} gagal diupload");
                }

                $ext = strtolower($file->getClientExtension() ?? '');
                $mime = strtolower($file->getMimeType() ?? '');

                if (!in_array($ext, $allowedExt, true) || !str_starts_with($mime, 'image/')) {
                    throw new \RuntimeException("{$field} harus berupa gambar");
                }

                if (!is_dir($dir) && !mkdir($dir, 0775, true)) {
                    throw new \RuntimeException('Folder upload gagal dibuat');
                }

                $oldFiles[$field] = $existingruang->{$field} ?? null;
                $newName = $no . '_' . $koderuang . '_' . date('YmdHis') . '.' . $ext;

                $file->move($dir, $newName);
                $movedFiles[] = $dir . $newName;

                if (!$ruangTable->where('id', $id)->update([$field => $newName])) {
                    throw new \RuntimeException("Nama file {$field} gagal disimpan");
                }

                $no++;
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
            foreach ($oldFiles as $oldFileName) {
                if ($oldFileName) {
                    $oldPath = FCPATH . 'upload/ruang/' . $oldFileName;

                    if (is_file($oldPath)) {
                        unlink($oldPath);
                    }
                }
            }
            
            return redirect()->to('/master-ruang')->with('success', 'Berhasil memperbarui data');

        } catch (\Throwable $e) {

            $db->transRollback();

            /*
            * Kalau file baru sudah dipindah
            * tetapi DB gagal, hapus file baru.
            */
            foreach ($movedFiles as $movedFile) {
                if (is_file($movedFile)) {
                    unlink($movedFile);
                }
            }

            log_message(
                'error',
                'Update ruang gagal: ' . $e->getMessage()
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

        $filesToDelete = [];

        try {

            $row = $this->ruang->getById($id);

            if (!$row) {
                throw new \RuntimeException('Ruang tidak ditemukan');
            }

            /*
            * Simpan path file dulu,
            * jangan dihapus sebelum commit.
            */
            foreach (['foto1', 'foto2', 'foto3', 'foto4'] as $field) {
                if (!empty($row[$field])) {
                    $filesToDelete[] = FCPATH
                        . 'upload/ruang/'
                        . $row[$field];
                }
            }

            /*
            * Hapus ruang dari database
            */
            $deleted = $db->table('ms_ruang')
                ->where('id', $id)
                ->delete();

            if (!$deleted) {
                $error = $db->error();

                throw new \RuntimeException(
                    'Gagal menghapus ruang: '
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
            foreach ($filesToDelete as $fileToDelete) {
                if (is_file($fileToDelete) && !unlink($fileToDelete)) {
                    log_message(
                        'error',
                        'Gagal menghapus file ruang: ' . $fileToDelete
                    );
                }
            }

            return redirect()
                ->to('/master-ruang')
                ->with(
                    'success',
                    'Berhasil hapus data'
                );

        } catch (\Throwable $e) {

            $db->transRollback();

            log_message(
                'error',
                'Delete ruang gagal ID '
                . $id
                . ': '
                . $e->getMessage()
            );

            return redirect()
                ->to('/master-ruang')
                ->with(
                    'error',
                    'Gagal hapus data: ' . $e->getMessage()
                );
        }
    }

    private function parseNumber($value)
    {
        // Hapus semua titik (pemisah ribuan)
        $value = str_replace('.', '', $value);

        // Ubah koma menjadi titik (untuk desimal)
        $value = str_replace(',', '.', $value);

        return $value;
    }

    private function rules(){
        $rules = [
            'nama_ruang' => [
                'label' => 'Nama Ruang',
                'rules' => 'required',
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required',
            ],
            'luas_ruang' => [
                'label' => 'Luas Ruang',
                'rules' => 'required',
            ],
            'jml_kursi' => [
                'label' => 'Jumlah Kursi',
                'rules' => 'required',
            ],
            'jml_meja' => [
                'label' => 'Jumlah Meja',
                'rules' => 'required',
            ],
            'fasilitas' => [
                'label' => 'Fasilitas',
                'rules' => 'required',
            ],
            'foto1' => [
                'label' => 'Foto 1',
                'rules' => 'permit_empty|is_image[foto1]|mime_in[foto1,image/jpg,image/jpeg,image/png,image/webp]|max_size[foto1,2048]',
            ],
            'foto2' => [
                'label' => 'Foto 2',
                'rules' => 'permit_empty|is_image[foto2]|mime_in[foto2,image/jpg,image/jpeg,image/png,image/webp]|max_size[foto2,2048]',
            ],
            'foto3' => [
                'label' => 'Foto 3',
                'rules' => 'permit_empty|is_image[foto3]|mime_in[foto3,image/jpg,image/jpeg,image/png,image/webp]|max_size[foto3,2048]',
            ],
            'foto4' => [
                'label' => 'Foto 4',
                'rules' => 'permit_empty|is_image[foto4]|mime_in[foto4,image/jpg,image/jpeg,image/png,image/webp]|max_size[foto4,2048]',
            ],
            'peruntukan' => [
                'label' => 'Peruntukan',
                'rules' => 'required',
            ],
            'namapj' => [
                'label' => 'Nama Penanggung Jawab',
                'rules' => 'required',
            ],
            'telppj' => [
                'label' => 'Telepon Penanggung Jawab',
                'rules' => 'required',
            ],
            'harga_sewa' => [
                'label' => 'Harga Sewa',
                'rules' => 'required',
            ],
            'latitude' => [
                'label' => 'Latitude',
                'rules' => 'required',
            ],
            'longitude' => [
                'label' => 'Longitude',
                'rules' => 'required',
            ],
        ];

        return $rules;
    }
}
