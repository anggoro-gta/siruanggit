<?php

namespace App\Controllers;

use Myth\Auth\Password;
use App\Models\User;

class UserController extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function index(): string
    {
        $data = [
            'title' => 'Data User'
        ];

        return view('user/index', $data);
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
                'username'   => 'username',
                'organisasi' => 'fullname',
                'pimpinan'   => 'nama_pimpinan',
                'pj'         => 'nama_pj',
            ][$orderBy] ?? 'id';

            $recordsTotal    = $this->user->countAll();
            $recordsFiltered = $this->user->countFiltered($search);
            $rows            = $this->user->getPage($search, $length, $start, $orderBy, $orderDir);

            $data = [];
            foreach ($rows as $r) {

                // btn
                $btn = '<div class="user-table-actions">
                            <a href="'.base_url('master-user/edit/'.$r['id']).'" class="btn btn-xs btn-outline-warning" title="Edit" aria-label="Edit">
                                <i class="bx bx-edit-alt"></i>
                            </a>
                            <a href="'.base_url('master-user/delete/'.$r['id']).'" class="btn btn-xs btn-outline-danger" title="Hapus" aria-label="Hapus" onclick="return confirmDelete(\''.base_url('master-user/delete/'.$r['id']).'\')">
                                <i class="bx bx-trash"></i>
                            </a>
                        </div>';

                // pimpinan
                $pimpinan = '-';
                if(!empty($r['nama_pimpinan'])) {
                    $no_hp = '';
                    if(!empty($r['nohp'])){
                        $no_hp = '<br><span class="text-success">'.$r['nohp'].'</span>';
                    }
                    
                    $pimpinan = '<div class="d-flex flex-column justify-content-center">
                                    <span class="text-heading text-wrap fw-medium">'.$r['nama_pimpinan'].'</span>
                                    <span class="text-truncate mb-0 d-none d-sm-block">
                                        <small style="font-size: 9pt">
                                            <span class="text-primary">'.$r['nip'].'</span>'.$no_hp.'
                                        </small>
                                    </span>
                                </div>';
                }

                // pj
                $pj = '-';
                if(!empty($r['namapj'])) {
                    $jabatan = '';
                    if(!empty($r['jabatanpj'])){
                        $jabatan = '<br><span class="text-warning">'.$r['jabatanpj'].'</span>';
                    }

                    $no_hp = '';
                    if(!empty($r['wapj'])){
                        $no_hp = '<br><span class="text-success">'.$r['wapj'].'</span>';
                    }

                    $pj = '<div class="d-flex flex-column justify-content-center">
                                    <span class="text-heading text-wrap fw-medium">'.$r['namapj'].'</span>
                                    <span class="text-truncate mb-0 d-none d-sm-block">
                                        <small style="font-size: 9pt">
                                            <span class="text-primary">'.$r['nippj'].'</span>'.$jabatan.$no_hp.'
                                        </small>
                                    </span>
                                </div>';
                }

                // kategori
                $kategori = '-';
                if(!empty($r['kategori'])) {
                    if($r['kategori']=='admin'){
                        $kategori = '<small><badge class="badge bg-label-danger">Admin</badge></small>';
                    }else if($r['kategori']=='opd'){
                        $kategori = '<small><badge class="badge bg-label-info">Opd</badge></small>';
                    }
                }

                // surat penugasan
                $surat_penugasan = '';
                if(!empty($r['suratpenugasanpj'])) {
                    $surat_penugasan = '<a href="' . base_url('upload/sp/' . $r['suratpenugasanpj']) . '"
                        class="btn btn-sm btn-outline-primary"
                        title="Download"
                        aria-label="Download"
                        download="' . esc($r['suratpenugasanpj']) . '">
                        <i class="bx bx-download"></i>
                    </a>';
                }
                $data[] = [
                    'username'        => $r['username'] ?? '-',
                    'organisasi'      => $r['fullname'] ?? '-',
                    'pimpinan'        => $pimpinan,
                    'pj'              => $pj,
                    'kategori'        => $kategori,
                    'surat_penugasan' => $surat_penugasan,
                    'action'          => $btn,
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
            'url'              => site_url('master-user/store'),
            'button'           => 'Simpan',
            'title'           => 'Tambah User',
            'id'               => old('id'),
            'email'            => old('email'),
            'username'         => old('username'),
            'fullname'         => old('fullname'),
            'alamat'           => old('alamat'),
            'nohp'             => old('nohp'),
            'nama_pimpinan'    => old('nama_pimpinan'),
            'nip'              => old('nip'),
            'namapj'           => old('namapj'),
            'nippj'            => old('nippj'),
            'wapj'             => old('wapj'),
            'jabatanpj'        => old('jabatanpj'),
            'suratpenugasanpj' => old('suratpenugasanpj'),
            'kategori'         => old('kategori')
        ];
        
        return view('user/form', $data);
    }

    public function store()
    {
        $rules = [
            'kategori' => [
                'label' => 'Kategori',
                'rules' => 'required|in_list[admin,opd]',
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|is_unique[users.username]',
            ],
            'fullname' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required|max_length[150]',
            ],
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
            $kategori = trim((string) $this->request->getPost('kategori'));

            $nomorBaru = null;
            $kodeDinas = null;

            if ($kategori === 'opd') {
                $email = trim((string) $this->request->getPost('email'));
                $counter = $db->query("
                    SELECT nomor
                    FROM kode_counter
                    WHERE nama_kode = 'dinas'
                    FOR UPDATE
                ")->getRow();

                if (!$counter) {
                    $row = $db->table('users')
                        ->orderBy('kode_dinas', 'DESC')
                        ->get()
                        ->getRow();

                    $lastKodeDinasCounter = 0;

                    if ($row) {
                        $string = $row->kode_dinas;
                        $lastKodeDinasCounter = (int) preg_replace('/\D/', '', $string);
                    }

                    $db->table('kode_counter')->insert([
                        'nama_kode' => 'dinas',
                        'nomor' => $lastKodeDinasCounter,
                    ]);

                    // Tetapkan nilai counter setelah insert
                    $counter = (object) [
                        'nomor' => $lastKodeDinasCounter,
                    ];
                }

                $nomorBaru = (int) $counter->nomor + 1;
                $kodeDinas = 'DNS-' . str_pad(
                    $nomorBaru,
                    7,
                    '0',
                    STR_PAD_LEFT
                );
            }else{
                $email = trim((string) $this->request->getPost('username')) .'@mail.com';
            }
            
            $data = [
                'kategori'         => $kategori,
                'username'         => trim((string) $this->request->getPost('username')),
                // 'password_hash'    => password_hash('kedirikab123@#', PASSWORD_DEFAULT),
                'password_hash'    => Password::hash('kedirikab123@#'),
                'fullname'         => $this->request->getPost('fullname'),
                'alamat'           => $this->request->getPost('alamat'),
                'nohp'             => $this->request->getPost('nohp'),
                'email'            => $email,
                'nama_pimpinan'    => $this->request->getPost('nama_pimpinan'),
                'nip'              => $this->request->getPost('nip'),
                'namapj'           => $this->request->getPost('namapj'),
                'nippj'            => $this->request->getPost('nippj'),
                'wapj'             => $this->request->getPost('wapj'),
                'jabatanpj'        => $this->request->getPost('jabatanpj'),
                'kode_dinas'       => $kodeDinas,
                'active'           => 1,
                'force_pass_reset' => 0,
                'created_at'       => $now
            ];

            // dd($data);

            $userTable = $db->table('users');

            if (!$userTable->insert($data)) {
                $error = $db->error();

                throw new \RuntimeException(
                    'Gagal insert user: ' . ($error['code'] ?? '') . ' - ' . ($error['message'] ?? '')
                );
            }

            $lastId = $db->insertID();

            if (!$lastId) {
                throw new \RuntimeException('ID user tidak ditemukan');
            }

            if ($kategori === 'admin') {
                $db->table('auth_groups_users')->insert([
                    'group_id' => 1,
                    'user_id' => $lastId
                ]);
            }else if ($kategori === 'opd') {
                $db->table('auth_groups_users')->insert([
                    'group_id' => 2,
                    'user_id' => $lastId
                ]);
            }

            if ($kategori === 'opd') {
                $updated = $db->table('kode_counter')
                    ->where('nama_kode', 'dinas')
                    ->update([
                        'nomor' => $nomorBaru,
                    ]);

                if (!$updated) {
                    throw new \RuntimeException('Counter dinas gagal diperbarui');
                }

                $file = $this->request->getFile('suratpenugasanpj');

                if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
                    if (!$file->isValid() || $file->hasMoved()) {
                        throw new \RuntimeException('File gagal diupload');
                    }

                    $allowedExt = [
                        'jpg',
                        'jpeg',
                        'png',
                        'webp',
                        'pdf',
                    ];

                    $ext = strtolower($file->getClientExtension() ?? '');
                    $mime = strtolower($file->getMimeType() ?? '');

                    $isAllowed = in_array($ext, $allowedExt, true)
                        && (
                            str_starts_with($mime, 'image/')
                            || $mime === 'application/pdf'
                        );

                    if (!$isAllowed) {
                        throw new \RuntimeException(
                            'File harus berupa gambar atau PDF'
                        );
                    }

                    $dir = FCPATH . 'upload/sp/';

                    if (!is_dir($dir) && !mkdir($dir, 0775, true)) {
                        throw new \RuntimeException(
                            'Folder upload gagal dibuat'
                        );
                    }

                    $newName = $userId . '_'
                        . $kodeDinas . '_'
                        . date('YmdHis')
                        . '.' . $ext;

                    $file->move($dir, $newName);
                    $movedFile = $dir . $newName;

                    if (!$userTable
                        ->where('id', $lastId)
                        ->update([
                            'suratpenugasanpj' => $newName,
                        ])
                    ) {
                        throw new \RuntimeException(
                            'Nama file gagal disimpan'
                        );
                    }
                }
            }

            if ($db->transStatus() === false) {
                throw new \RuntimeException('DB transaction failed');
            }

            $db->transCommit();

            return redirect()->to('/master-user')->with('success', 'Berhasil menambahkan user');

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
        $row = $this->user->getById($id);

        $data = [
            'url'              => site_url('master-user/update'),
            'button'           => 'Simpan Perubahan',
            'title'           => 'Edit User',
            'id'               => old('id', $row['id']),
            'email'            => old('email', $row['email']),
            'username'         => old('username', $row['username']),
            'fullname'         => old('fullname', $row['fullname']),
            'alamat'           => old('alamat', $row['alamat']),
            'nohp'             => old('nohp', $row['nohp']),
            'nama_pimpinan'    => old('nama_pimpinan', $row['nama_pimpinan']),
            'nip'              => old('nip', $row['nip']),
            'namapj'           => old('namapj', $row['namapj']),
            'nippj'            => old('nippj', $row['nippj']),
            'wapj'             => old('wapj', $row['wapj']),
            'jabatanpj'        => old('jabatanpj', $row['jabatanpj']),
            'suratpenugasanpj' => old('suratpenugasanpj', $row['suratpenugasanpj']),
            'kategori'         => old('kategori', $row['kategori'])
        ];

        return view('user/form', $data);
    }

    public function update()
    {
        $id = (int) $this->request->getPost('id');

        if (!$id) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', [
                    'general' => 'ID user tidak valid',
                ]);
        }

        $rules = [
            'kategori' => [
                'label' => 'Kategori',
                'rules' => 'required|in_list[admin,opd]',
            ],
            'username' => [
                'label' => 'Username',
                'rules' => "required|min_length[4]|max_length[50]|is_unique[users.username,id,{$id}]",
            ],
            'fullname' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required|max_length[150]',
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'permit_empty|min_length[8]',
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
        $userTable = $db->table('users');

        $movedFile = null;
        $newName = null;
        $oldFileName = null;

        $db->transBegin();

        try {

            $existingUser = $userTable
                ->where('id', $id)
                ->get()
                ->getRow();

            if (!$existingUser) {
                throw new \RuntimeException('User tidak ditemukan');
            }

            $kategori = trim((string) $this->request->getPost('kategori'));

            $username = trim((string) $this->request->getPost('username'));

            $email = null;
            $kodeDinas = null;

            $nomorBaru = null;
            $generateKodeBaru = false;

            if ($kategori === 'admin') {
                $db->table('auth_groups_users')
                    ->where('user_id', $existingUser->id)
                    ->update([
                        'group_id' => 1,
                    ]);
            }else if ($kategori === 'opd') {
                $db->table('auth_groups_users')
                    ->where('user_id', $existingUser->id)
                    ->update([
                        'group_id' => 2,
                    ]);
            }

            /*
            * ============================
            * KATEGORI / KODE DINAS
            * ============================
            */
            if ($kategori === 'opd') {

                $email = trim((string) $this->request->getPost('email'));

                /*
                * Kalau sudah mempunyai kode dinas,
                * pertahankan.
                */
                if (!empty($existingUser->kode_dinas)) {

                    $kodeDinas = $existingUser->kode_dinas;

                } else {

                    /*
                    * Baru generate kode kalau user
                    * sebelumnya belum mempunyai kode.
                    */
                    $counter = $db->query("
                        SELECT nomor
                        FROM kode_counter
                        WHERE nama_kode = 'dinas'
                        FOR UPDATE
                    ")->getRow();

                    if (!$counter) {
                        throw new \RuntimeException(
                            'Counter dinas belum tersedia'
                        );
                    }

                    $nomorBaru = (int) $counter->nomor + 1;

                    $kodeDinas = 'DNS-' . str_pad(
                        $nomorBaru,
                        7,
                        '0',
                        STR_PAD_LEFT
                    );

                    $generateKodeBaru = true;
                }

            } else {

                $email = $username . '@mail.com';
                $kodeDinas = null;
            }

            /*
            * ============================
            * DATA UPDATE
            * ============================
            */

            $data = [
                'kategori' => $kategori,
                'username' => $username,
                'fullname' => trim((string) $this->request->getPost('fullname')),
                'alamat' => trim((string) $this->request->getPost('alamat')),
                'nohp' => trim((string) $this->request->getPost('nohp')),
                'email' => $email,
                'nama_pimpinan' => $kategori === 'opd' ? trim((string) $this->request->getPost('nama_pimpinan')) : null,
                'nip' => $kategori === 'opd' ? trim((string) $this->request->getPost('nip')) : null,
                'namapj' => $kategori === 'opd' ? trim((string) $this->request->getPost('namapj')) : null,
                'nippj' => $kategori === 'opd' ? trim((string) $this->request->getPost('nippj')) : null,
                'wapj' => $kategori === 'opd' ? trim((string) $this->request->getPost('wapj')) : null,
                'jabatanpj' => $kategori === 'opd' ? trim((string) $this->request->getPost('jabatanpj')) : null,
                'kode_dinas' => $kodeDinas,
                'updated_at' => $now
            ];

            /*
            * ============================
            * PASSWORD OPTIONAL
            * ============================
            */

            $password = trim((string) $this->request->getPost('password'));

            if ($password !== '') {
                // $data['password_hash'] = password_hash(
                //     $password,
                //     PASSWORD_DEFAULT
                // );
                $data['password_hash'] = Password::hash($password);
            }

            /*
            * ============================
            * UPDATE USER
            * ============================
            */

            $updated = $userTable
                ->where('id', $id)
                ->update($data);

            if (!$updated) {

                $error = $db->error();

                throw new \RuntimeException(
                    'Gagal update user: '
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
                    ->where('nama_kode', 'dinas')
                    ->update([
                        'nomor' => $nomorBaru,
                    ]);

                if (!$counterUpdated) {
                    throw new \RuntimeException(
                        'Counter dinas gagal diperbarui'
                    );
                }
            }

            /*
            * ============================
            * FILE OPD
            * ============================
            */

            if ($kategori === 'opd') {

                $file = $this->request->getFile('suratpenugasanpj');

                if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {

                    if (!$file->isValid() || $file->hasMoved()) {
                        throw new \RuntimeException(
                            'File gagal diupload'
                        );
                    }

                    $allowedExt = ['jpg', 'jpeg', 'png', 'webp', 'pdf',];

                    $ext = strtolower($file->getClientExtension() ?? '');

                    $mime = strtolower($file->getMimeType() ?? '');

                    $isAllowed = in_array($ext, $allowedExt, true) && (str_starts_with($mime, 'image/') || $mime === 'application/pdf');

                    if (!$isAllowed) {
                        throw new \RuntimeException(
                            'File harus berupa gambar atau PDF'
                        );
                    }

                    $dir = FCPATH . 'upload/sp/';

                    if (!is_dir($dir) && !mkdir($dir, 0775, true)) {
                        throw new \RuntimeException(
                            'Folder upload gagal dibuat'
                        );
                    }

                    $oldFileName = $existingUser->suratpenugasanpj ?? null;

                    $newName = $loginUserId . '_' . $kodeDinas . '_' . date('YmdHis') . '.' . $ext;

                    $file->move($dir, $newName);

                    $movedFile = $dir . $newName;

                    $fileUpdated = $userTable->where('id', $id)->update(['suratpenugasanpj' => $newName]);

                    if (!$fileUpdated) {
                        throw new \RuntimeException(
                            'Nama file gagal disimpan'
                        );
                    }
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
                    . 'upload/sp/'
                    . $oldFileName;

                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
            }
            
            return redirect()->to('/master-user')->with('success', 'Berhasil memperbarui data');

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
                'Update user gagal: ' . $e->getMessage()
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

            $row = $this->user->getById($id);

            if (!$row) {
                throw new \RuntimeException('User tidak ditemukan');
            }

            /*
            * Simpan path file dulu,
            * jangan dihapus sebelum commit.
            */
            if (!empty($row['suratpenugasanpj'])) {
                $fileToDelete = FCPATH
                    . 'upload/sp/'
                    . $row['suratpenugasanpj'];
            }

            /*
            * Hapus user dari database
            */
            $deleted = $db->table('users')
                ->where('id', $id)
                ->delete();

            if (!$deleted) {
                $error = $db->error();

                throw new \RuntimeException(
                    'Gagal menghapus user: '
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
                        'Gagal menghapus file surat penugasan: '
                        . $fileToDelete
                    );
                }
            }

            return redirect()
                ->to('/master-user')
                ->with(
                    'success',
                    'Berhasil hapus data'
                );

        } catch (\Throwable $e) {

            $db->transRollback();

            log_message(
                'error',
                'Delete user gagal ID '
                . $id
                . ': '
                . $e->getMessage()
            );

            return redirect()
                ->to('/master-user')
                ->with(
                    'error',
                    'Gagal hapus data: ' . $e->getMessage()
                );
        }
    }
}
