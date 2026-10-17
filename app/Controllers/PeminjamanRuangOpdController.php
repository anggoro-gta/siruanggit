<?php

namespace App\Controllers;


use App\Models\PeminjamanRuang;
use App\Models\Ketentuan;
use App\Models\Ruang;

class PeminjamanRuangOpdController extends BaseController
{
    protected $pinjam_ruang;
    protected $ketentuan;
    protected $ruang;
    protected $userId = null;
    protected $kodeDinas = null;

    public function __construct()
    {
        $this->pinjam_ruang = new PeminjamanRuang();
        $this->ketentuan = new Ketentuan();
        $this->ruang = new Ruang();
        $this->userId = user()->id ?? null;
        $this->kodeDinas = user()->kode_dinas ?? null;
    }

    public function index(): string
    {
        $data = [
            'title' => 'Data Peminjaman Ruang'
        ];

        return view('peminjaman-ruangan/opd/index', $data);
    }

    public function getData()
    {
        try {
            if (!$this->request->isAJAX()) {
                return $this->response->setStatusCode(400)->setJSON(['data' => []]);
            }

            $draw = (int) $this->request->getPost('draw');
            $start = (int) $this->request->getPost('start');   // offset
            $length = (int) $this->request->getPost('length');  // limit
            $search = $this->request->getPost('search')['value'] ?? '';
            $order = $this->request->getPost('order')[0] ?? [];
            $columns = $this->request->getPost('columns');
            $orderIndex = (int) ($order['column'] ?? 0);
            $orderBy = $columns[$orderIndex]['data'] ?? 'tglpinjam';
            $orderDir = $order['dir'] ?? 'DESC';
            $orderBy = [
                'id' => 'id',
                'nopinjam' => 'nopinjam',
                'tglpinjam' => 'tglpinjam'
            ][$orderBy] ?? 'id';

            $recordsTotal = $this->pinjam_ruang->countAll($this->kodeDinas);
            $recordsFiltered = $this->pinjam_ruang->countFiltered($this->kodeDinas, $search);
            $rows = $this->pinjam_ruang->getPage($search, $length, $start, $orderBy, $orderDir, $this->kodeDinas);

            $data = [];
            foreach ($rows as $r) {

                $isVerifikasi = $r['isverifikasi'];

                $status = '<span class="badge rounded-pill bg-label-info">Belum Verifikasi</span>';

                $btn = '<div class="user-table-actions">
                            <a href="' . base_url('peminjaman-ruang-opd/edit/' . $r['id']) . '" class="btn btn-xs btn-outline-warning" title="Edit" aria-label="Edit">
                                <i class="bx bx-edit-alt"></i>
                            </a>
                            <a href="' . base_url('peminjaman-ruang-opd/delete/' . $r['id']) . '" class="btn btn-xs btn-outline-danger" title="Hapus" aria-label="Hapus" onclick="return confirmDelete(\'' . base_url('peminjaman-ruang-opd/delete/' . $r['id']) . '\')">
                                <i class="bx bx-trash"></i>
                            </a>
                        </div>';

                if ($isVerifikasi === '1') {
                    $btn = '<div class="user-table-actions">
                                <a href="' . base_url('peminjaman-ruang-opd/detail/' . $r['id']) . '" class="btn btn-xs btn-outline-info" title="Detail" aria-label="Detail">
                                    <i class="bx bx-detail"></i>
                                </a>
                            </div>';

                    $status = '<span class="badge rounded-pill bg-label-success">Disetujui</span>';
                } else if ($isVerifikasi === '0') {
                    $status = '<span class="badge rounded-pill bg-label-danger">Ditolak</span>';
                }

                $acara = '
                    <div class="acara-wrapper">
                        <div class="acara-item">
                            <span class="acara-icon">
                                <i class="bx bx-calendar"></i>
                            </span>

                            <div class="acara-text">
                                <div>' . esc(tanggal_indo($r['tgljamacaramulai'])) . ' ' . date('H:i', strtotime($r['tgljamacaramulai'])) . ' s.d. </div>
                                <div>' . esc(tanggal_indo($r['tgljamacaraselesai'])) . ' ' . date('H:i', strtotime($r['tgljamacaraselesai'])) . '</div>
                            </div>
                        </div>

                        <div class="acara-item">
                            <span class="acara-icon">
                                <i class="bx bx-note"></i>
                            </span>

                            <div class="acara-text">
                                ' . esc($r['acara'] ?? '-') . '
                            </div>
                        </div>
                    </div>';

                $data[] = [
                    'no_pinjam' => $r['nopinjam'] ?? '-',
                    'tgl_pinjam' => tanggal_indo($r['tglpinjam']) . ' ' . date('H:i:s', strtotime($r['tglpinjam'])) ?? '-',
                    'nama_peminjam' => $r['namapeminjam'] ?? '-',
                    'nama_ruang' => $r['nama_ruang'] ?? '-',
                    'acara' => $acara,
                    'harga_pinjam' => 'Rp ' . number_format($r['hargasewa'] ?? '0', 0, ',', '.'),
                    'status' => $status,
                    'action' => $btn,
                ];
            }

            return $this->response->setJSON([
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data,
                'csrf' => function_exists('csrf_hash') ? csrf_hash() : null,
            ]);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function create()
    {
        $ketentuan = $this->ketentuan->getAll();
        $ruang = $this->ruang->getAll();

        $data = [
            'url' => site_url('peminjaman-ruang-opd/store'),
            'button' => 'Simpan',
            'title' => 'Form Peminjaman Ruang',
            'id' => old('id'),
            'kode_dinas' => old('kode_dinas', $this->kodeDinas),
            'namaorganisasi' => old('namaorganisasi', user()->fullname ?? ''),
            'namapeminjam' => old('namapeminjam', user()->nama_pimpinan ?? ''),
            'nohp' => old('nohp', user()->wapj ?? ''),
            'acara' => old('acara'),
            'tgljamacaramulai' => old('tgljamacaramulai'),
            'tgljamacaraselesai' => old('tgljamacaraselesai'),
            'filesuratpinjam' => old('filesuratpinjam'),
            'kode_ruang' => old('kode_ruang'),
            'ref_ketentuan' => $ketentuan,
            'ref_ruang' => $ruang
        ];

        return view('peminjaman-ruangan/opd/form', $data);
    }

    public function timeline()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON([
                'message' => 'Invalid request.'
            ]);
        }

        $mulai = str_replace('T', ' ', trim((string) $this->request->getPost('mulai')));
        $selesai = str_replace('T', ' ', trim((string) $this->request->getPost('selesai')));
        $kodeRuang = trim((string) $this->request->getPost('kode_ruang'));
        $excludeId = (int) $this->request->getPost('id');

        if (!$mulai || !$selesai || !$kodeRuang || strtotime($selesai) < strtotime($mulai)) {
            return $this->response->setStatusCode(422)->setJSON([
                'message' => 'Rentang tanggal tidak valid.'
            ]);
        }

        return $this->response->setJSON([
            'data' => $this->pinjam_ruang->getTimelineByRange($mulai, $selesai, $kodeRuang, $excludeId ?: null)
        ]);
    }

    public function store()
    {
        $rules = [
            'namapeminjam' => 'required',
            'nohp' => 'required',
            'tgljamacaramulai' => 'required',
            'tgljamacaraselesai' => 'required',
            'kode_ruang' => 'required',
            'filesuratpinjam' => 'permit_empty|uploaded[filesuratpinjam]|max_size[filesuratpinjam,5120]|ext_in[filesuratpinjam,pdf,jpg,jpeg,png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $mulai = str_replace('T', ' ', trim((string) $this->request->getPost('tgljamacaramulai')));
        $selesai = str_replace('T', ' ', trim((string) $this->request->getPost('tgljamacaraselesai')));
        $kodeRuang = trim((string) $this->request->getPost('kode_ruang'));

        if (strtotime($selesai) < strtotime($mulai)) {
            return redirect()->back()->withInput()->with('errors', [
                'general' => 'Ruangan sudah digunakan atau rentang tanggal tidak valid.'
            ]);
        }

        $durasiSewa = $this->hitungDurasiSewa($mulai, $selesai);

        $db = \Config\Database::connect();
        $movedFile = null;
        $roomLockAcquired = false;
        $db->transBegin();

        try {
            // Serialisasi request untuk ruangan yang sama. Tanpa lock ini,
            // dua request bersamaan dapat sama-sama lolos hasConflict().
            // Nama GET_LOCK maksimal 64 karakter. MD5 32 karakter sudah
            // cukup untuk membuat lock key per ruangan secara konsisten.
            $lockName = 'pinjamruang:' . md5($kodeRuang);
            $lockQuery = $db->query(
                'SELECT GET_LOCK(' . $db->escape($lockName) . ', 10) AS acquired'
            );
            if ($lockQuery === false) {
                $dbError = $db->error();
                throw new \RuntimeException(
                    'Gagal mengunci proses ruangan: ' . ($dbError['message'] ?? 'query database gagal.')
                );
            }
            $lock = $lockQuery->getRow();
            $roomLockAcquired = ((int) ($lock->acquired ?? 0) === 1);
            if (!$roomLockAcquired) {
                throw new \RuntimeException('Ruangan sedang diproses oleh pengguna lain. Silakan coba lagi.');
            }

            // Cek bentrok harus berada setelah lock diperoleh dan sebelum insert.
            if ($this->pinjam_ruang->hasConflict($mulai, $selesai, $kodeRuang)) {
                throw new \RuntimeException('Ruangan sudah digunakan pada rentang waktu tersebut.');
            }

            // Pastikan row counter ada sebelum SELECT ... FOR UPDATE agar
            // pembuatan counter pertama juga aman dari race condition.
            $db->query(
                "INSERT IGNORE INTO kode_counter (nama_kode, nomor) VALUES ('pinjamruang', 0)"
            );
            $counterQuery = $db->query("SELECT nomor FROM kode_counter WHERE nama_kode = 'pinjamruang' FOR UPDATE");
            if ($counterQuery === false) {
                $dbError = $db->error();
                throw new \RuntimeException(
                    'Gagal membaca counter peminjaman: ' . ($dbError['message'] ?? 'query database gagal.')
                );
            }
            $counter = $counterQuery->getRow();
            if (!$counter) {
                throw new \RuntimeException('Counter nomor peminjaman tidak tersedia.');
            }
            $nomor = (int) $counter->nomor;

            // Recovery jika counter pernah dibuat/reset ke 0: lanjutkan dari
            // nomor TRP terbesar yang sudah tersimpan di tabel.
            $lastNumberQuery = $db->query(
                "SELECT COALESCE(MAX(CAST(SUBSTRING(nopinjam, 5) AS UNSIGNED)), 0) AS nomor
                 FROM tb_pinjamruang
                 WHERE nopinjam LIKE 'TRP-%'"
            );
            if ($lastNumberQuery === false) {
                $dbError = $db->error();
                throw new \RuntimeException(
                    'Gagal membaca nomor peminjaman terakhir: ' . ($dbError['message'] ?? 'query database gagal.')
                );
            }
            $lastNumber = (int) ($lastNumberQuery->getRow()->nomor ?? 0);
            $nomor = max($nomor, $lastNumber);
            $nomor++;
            $noPinjam = 'TRP-' . str_pad($nomor, 7, '0', STR_PAD_LEFT);
            $now = date('Y-m-d H:i:s');

            $data = [
                'nopinjam' => $noPinjam,
                'tglpinjam' => $now,
                'namaorganisasi' => trim((string) $this->request->getPost('namaorganisasi')),
                'namapeminjam' => trim((string) $this->request->getPost('namapeminjam')),
                'nohp' => trim((string) $this->request->getPost('nohp')),
                'acara' => trim((string) $this->request->getPost('acara')),
                'tgljamacaramulai' => $mulai,
                'tgljamacaraselesai' => $selesai,
                'kode_ruang' => $kodeRuang,
                'kode_dinas' => $this->request->getPost('kode_dinas') ?: $this->kodeDinas,
                'isverifikasi' => null,
                'wasatuhari' => 0,
                'waduajam' => 0,
                'durasisewa' => $durasiSewa,
                'hargasewa' => 0,
                'totalhargasewa' => 0,
                'username' => user()->username ?? null,
                'created_by' => $this->userId ?? null,
                'created_at' => $now,
            ];

            $file = $this->request->getFile('filesuratpinjam');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $dir = FCPATH . 'upload/surat/';
                if (!is_dir($dir) && !mkdir($dir, 0775, true)) {
                    throw new \RuntimeException('Folder upload gagal dibuat.');
                }
                $name = $noPinjam . '_' . date('YmdHis') . '.' . strtolower($file->getClientExtension());
                $file->move($dir, $name);
                $movedFile = $dir . $name;
                $data['filesuratpinjam'] = $name;
            }

            if (!$this->pinjam_ruang->insert($data)) {
                $dbError = $db->error();
                throw new \RuntimeException(
                    'Gagal menyimpan data peminjaman: ' . ($dbError['message'] ?? 'query database gagal.')
                );
            }
            if (!$db->table('kode_counter')->where('nama_kode', 'pinjamruang')->update(['nomor' => $nomor])) {
                throw new \RuntimeException('Counter nomor peminjaman gagal diperbarui.');
            }
            if ($db->transStatus() === false)
                throw new \RuntimeException('DB transaction failed.');
            $db->transCommit();
            $db->query('SELECT RELEASE_LOCK(?)', [$lockName]);
            return redirect()->to('/peminjaman-ruang-opd')->with('success', 'Berhasil menyimpan peminjaman ruang.');
        } catch (\Throwable $e) {
            $db->transRollback();
            if ($roomLockAcquired) {
                $db->query('SELECT RELEASE_LOCK(?)', [$lockName]);
            }
            if ($movedFile && is_file($movedFile))
                unlink($movedFile);
            log_message('error', $e->getMessage());
            return redirect()->back()->withInput()->with('errors', ['general' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $row = $this->pinjam_ruang->getById((int) $id);
        if (!$row)
            return redirect()->to('/peminjaman-ruang-opd')->with('errors', ['general' => 'Data tidak ditemukan.']);
        return view('peminjaman-ruangan/opd/form', [
            'url' => site_url('peminjaman-ruang-opd/update'),
            'button' => 'Simpan Perubahan',
            'title' => 'Edit Peminjaman Ruang',
            'id' => old('id', $row['id']),
            'kode_dinas' => old('kode_dinas', $row['kode_dinas']),
            'namaorganisasi' => old('namaorganisasi', $row['namaorganisasi']),
            'namapeminjam' => old('namapeminjam', $row['namapeminjam']),
            'nohp' => old('nohp', $row['nohp']),
            'acara' => old('acara', $row['acara']),
            'tgljamacaramulai' => old('tgljamacaramulai', date('Y-m-d\TH:i', strtotime($row['tgljamacaramulai']))),
            'tgljamacaraselesai' => old('tgljamacaraselesai', date('Y-m-d\TH:i', strtotime($row['tgljamacaraselesai']))),
            'filesuratpinjam' => old('filesuratpinjam', $row['filesuratpinjam']),
            'kode_ruang' => old('kode_ruang', $row['kode_ruang']),
            'ref_ketentuan' => $this->ketentuan->getAll(),
            'ref_ruang' => $this->ruang->getAll()
        ]);

    }

    public function detail($id)
    {
        $row = $this->pinjam_ruang->getById((int) $id);
        if (!$row) {
            return redirect()->to('/peminjaman-ruang-opd')->with('error', 'Data peminjaman tidak ditemukan.');
        }

        return view('peminjaman-ruangan/opd/detail', [
            'title' => 'Detail Peminjaman Ruang',
            'row' => $row
        ]);
    }

    
    public function cetak($id)
    {
        $row = $this->pinjam_ruang->getById((int) $id);

        if (!$row || (string) $row['isverifikasi'] !== '1') {
            return redirect()->back()->with('error', 'Bukti pemesanan hanya tersedia untuk pemesanan yang disetujui.');
        }

        $html = view('peminjaman-ruangan/admin/cetak', [
            'row' => $row,
            'ketentuan' => $this->ketentuan->getAll(),
            'qrCode' => $this->createBookingQrCode($row),
        ]);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->render();

        return $this->response
            ->setContentType('application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="bukti-pemesanan-' . ($row['nopinjam'] ?: $row['id']) . '.pdf"')
            ->setBody($dompdf->output());
    }

    private function createBookingQrCode(array $row): string
    {
        $writer = new \Endroid\QrCode\Writer\PngWriter();
        $qrCode = new \Endroid\QrCode\QrCode(
            data: base_url('bukti-pemesanan/' . $this->encryptBookingId((int) $row['id'])),
            size: 180,
            margin: 8
        );

        return $writer->write($qrCode)->getDataUri();
    }

    private function encryptBookingId(int $id): string
    {
        $encrypted = service('encrypter')->encrypt((string) $id);

        return rtrim(strtr(base64_encode($encrypted), '+/', '-_'), '=');
    }

    public function update()
    {
        $id = (int) $this->request->getPost('id');
        $now = date('Y-m-d H:i:s');

        $rules = [
            'id'                 => 'required|is_natural_no_zero', 
            'namapeminjam'       => 'required', 
            'nohp'               => 'required', 
            'tgljamacaramulai'   => 'required', 
            'tgljamacaraselesai' => 'required', 
            'kode_ruang'         => 'required',
            'filesuratpinjam'    => 'permit_empty|uploaded[filesuratpinjam]|max_size[filesuratpinjam,5120]|ext_in[filesuratpinjam,pdf,doc,docx,jpg,jpeg,png]'
        ];
        
        if (!$id || !$this->validate($rules))
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());

        $mulai   = str_replace('T', ' ', trim((string) $this->request->getPost('tgljamacaramulai')));
        $selesai = str_replace('T', ' ', trim((string) $this->request->getPost('tgljamacaraselesai')));
        $kode    = trim((string) $this->request->getPost('kode_ruang'));

        if (strtotime($selesai) < strtotime($mulai))
            return redirect()->back()->withInput()->with('errors', ['general' => 'Rentang tanggal tidak valid.']);

        $durasiSewa = $this->hitungDurasiSewa($mulai, $selesai);

        $db = \Config\Database::connect();
        $lockName = 'pinjamruang:' . md5($kode);
        $db->transBegin();
        $locked = false;
        $newFilePath = null;
        $oldFilePath = null;

        try {
            $q = $db->query('SELECT GET_LOCK(' . $db->escape($lockName) . ', 10) AS acquired');

            if (!$q || (int) $q->getRow()->acquired !== 1)
                throw new \RuntimeException('Ruangan sedang diproses pengguna lain.');

            $locked = true;

            if ($this->pinjam_ruang->hasConflict($mulai, $selesai, $kode, $id))
                throw new \RuntimeException('Ruangan sudah digunakan pada rentang waktu tersebut.');

            $existing = $this->pinjam_ruang->getById($id);
            if (!$existing)
                throw new \RuntimeException('Data peminjaman tidak ditemukan.');

            $isVerifikasi = $existing['isverifikasi'] ?? null;
            $tglVerifikasi = $existing['tglverifikasi'] ?? null;
            $keteranganVerifikasi = $existing['keteranganverifikasi'] ?? null;

            if($isVerifikasi === '1')
                throw new \RuntimeException('Peminjaman sudah diverifikasi, tidak dapat diubah.');

            if($isVerifikasi === '0'){
                $isVerifikasi = null;
                $tglVerifikasi = null;
                $keteranganVerifikasi = null;
            }

            $data = [
                'namaorganisasi'       => trim((string) $this->request->getPost('namaorganisasi')),
                'namapeminjam'         => trim((string) $this->request->getPost('namapeminjam')),
                'nohp'                 => trim((string) $this->request->getPost('nohp')),
                'acara'                => trim((string) $this->request->getPost('acara')),
                'tgljamacaramulai'     => $mulai,
                'tgljamacaraselesai'   => $selesai,
                'durasisewa'           => $durasiSewa,
                'kode_ruang'           => $kode,
                'updated_at'           => $now,
                'updated_by'           => $this->userId,
                'isverifikasi'         => $isVerifikasi,
                'tglverifikasi'        => $tglVerifikasi,
                'keteranganverifikasi' => $keteranganVerifikasi
            ];

            $file = $this->request->getFile('filesuratpinjam');
            if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
                if (!$file->isValid() || $file->hasMoved())
                    throw new \RuntimeException('File surat izin tidak valid.');

                $dir = FCPATH . 'upload/surat/';
                if (!is_dir($dir) && !mkdir($dir, 0775, true))
                    throw new \RuntimeException('Folder upload gagal dibuat.');

                $ext = strtolower($file->getClientExtension() ?? '');
                $name = $existing['nopinjam'] . '_' . date('YmdHis') . '.' . $ext;
                $file->move($dir, $name);
                $newFilePath = $dir . $name;
                $data['filesuratpinjam'] = $name;

                if (!empty($existing['filesuratpinjam']))
                    $oldFilePath = $dir . $existing['filesuratpinjam'];
            }

            if (!$this->pinjam_ruang->update($id, $data)) {
                $dbError = $db->error();
                throw new \RuntimeException('Gagal memperbarui data peminjaman: ' . ($dbError['message'] ?? 'query database gagal.'));
            }

            if ($db->transStatus() === false)
                throw new \RuntimeException('DB transaction failed.');

            $db->transCommit();
            
            if ($locked)
                $db->query('SELECT RELEASE_LOCK(?)', [$lockName]);

            if ($oldFilePath && is_file($oldFilePath))
                unlink($oldFilePath);

            return redirect()->to('/peminjaman-ruang-opd')->with('success', 'Berhasil memperbarui peminjaman ruang.');

        } catch (\Throwable $e) {
            $db->transRollback();
            if ($locked)
                $db->query('SELECT RELEASE_LOCK(?)', [$lockName]);

            if ($newFilePath && is_file($newFilePath))
                unlink($newFilePath);

            log_message('error', $e->getMessage());

            return redirect()->back()->withInput()->with('errors', ['general' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        $id = (int) $id;
        $db = \Config\Database::connect();
        $db->transBegin();
        $locked = false;
        $filePath = null;

        try {
            $row = $this->pinjam_ruang->getById($id);
            if (!$row) throw new \RuntimeException('Data peminjaman tidak ditemukan.');

            $lockName = 'pinjamruang:' . md5($row['kode_ruang']);
            $lockQuery = $db->query('SELECT GET_LOCK(' . $db->escape($lockName) . ', 10) AS acquired');
            if (!$lockQuery || (int) $lockQuery->getRow()->acquired !== 1)
                throw new \RuntimeException('Ruangan sedang diproses pengguna lain.');
            $locked = true;

            if (!empty($row['filesuratpinjam']))
                $filePath = FCPATH . 'upload/surat/' . basename($row['filesuratpinjam']);

            if (!$this->pinjam_ruang->delete($id)) {
                $error = $db->error();
                throw new \RuntimeException('Gagal menghapus data peminjaman: ' . ($error['message'] ?? 'query database gagal.'));
            }
            if ($db->transStatus() === false) throw new \RuntimeException('DB transaction failed.');

            $db->transCommit();
            if ($locked) $db->query('SELECT RELEASE_LOCK(?)', [$lockName]);
            if ($filePath && is_file($filePath) && !unlink($filePath))
                log_message('error', 'Gagal menghapus file surat: ' . $filePath);

            return redirect()->to('/peminjaman-ruang-opd')->with('success', 'Berhasil menghapus data peminjaman.');
        } catch (\Throwable $e) {
            $db->transRollback();
            if ($locked) $db->query('SELECT RELEASE_LOCK(?)', [$lockName]);
            log_message('error', 'Delete peminjaman gagal ID ' . $id . ': ' . $e->getMessage());
            return redirect()->to('/peminjaman-ruang-opd')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }


    /**
     * Menghitung durasi sewa berdasarkan hari kalender secara inklusif.
     */
    private function hitungDurasiSewa(string $mulai, string $selesai): int
    {
        $tanggalMulai = new \DateTimeImmutable($mulai);
        $tanggalSelesai = new \DateTimeImmutable($selesai);

        return (int) $tanggalMulai->setTime(0, 0)->diff(
            $tanggalSelesai->setTime(0, 0)
        )->days + 1;
    }

    private function parseNumber($value)
    {
        // Hapus semua titik (pemisah ribuan)
        $value = str_replace('.', '', $value);

        // Ubah koma menjadi titik (untuk desimal)
        $value = str_replace(',', '.', $value);

        return $value;
    }

    private function rules()
    {
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
