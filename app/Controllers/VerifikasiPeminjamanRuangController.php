<?php

namespace App\Controllers;


use App\Models\PeminjamanRuang;
use App\Models\Ruang;

class VerifikasiPeminjamanRuangController extends BaseController
{
    protected $pinjam_ruang;
    protected $ruang;
    protected $userId = null;

    public function __construct()
    {
        $this->pinjam_ruang = new PeminjamanRuang();
        $this->ruang = new Ruang();
        $this->userId = user()->id ?? null;
    }

    public function index(): string
    {
        $data = [
            'title' => 'Verifikasi Peminjaman Ruang'
        ];

        return view('peminjaman-ruangan/admin/index', $data);
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
            $tanggalMulai = trim((string) $this->request->getPost('tanggal_mulai'));
            $tanggalSelesai = trim((string) $this->request->getPost('tanggal_selesai'));
            $tanggalMulai = $this->normalizeFilterDate($tanggalMulai);
            $tanggalSelesai = $this->normalizeFilterDate($tanggalSelesai);
            $status = (string) $this->request->getPost('status');
            if (!in_array($status, ['all', 'pending', '', '0', '1'], true)) {
                $status = 'all';
            }
            if ($tanggalMulai !== '' && $tanggalSelesai !== '' && $tanggalMulai > $tanggalSelesai) {
                [$tanggalMulai, $tanggalSelesai] = [$tanggalSelesai, $tanggalMulai];
            }
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

            $recordsTotal = $this->pinjam_ruang->countAll('', $tanggalMulai, $tanggalSelesai, $status);
            $recordsFiltered = $this->pinjam_ruang->countFiltered('', $search, $tanggalMulai, $tanggalSelesai, $status);
            $rows = $this->pinjam_ruang->getPage($search, $length, $start, $orderBy, $orderDir, '', $tanggalMulai, $tanggalSelesai, $status);

            $data = [];
            foreach ($rows as $r) {

                $isVerifikasi = $r['isverifikasi'];

                $status = '<span class="badge rounded-pill bg-label-info">Belum Verifikasi</span>';

                $btn = '<div class="user-table-actions">
                            <a href="' . base_url('verifikasi-peminjaman-ruang/detail/' . $r['id']) . '" class="btn btn-xs btn-outline-info" title="Detail" aria-label="Detail">
                                <i class="bx bx-detail"></i>
                            </a>
                        </div>';

                if ($isVerifikasi === '1') {
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

                $nama_peminjam = $r['namapeminjam'].'<br><small class="text-muted">' . esc($r['namaorganisasi'] ?? '-') . '</small>';

                $data[] = [
                    'no_pinjam' => $r['nopinjam'] ?? '-',
                    'tgl_pinjam' => tanggal_indo($r['tglpinjam']) . ' ' . date('H:i:s', strtotime($r['tglpinjam'])) ?? '-',
                    'nama_peminjam' => $nama_peminjam,
                    'nama_ruang' => $r['nama_ruang'] ?? '-',
                    'acara' => $acara,
                    'harga_pinjam' => $r['hargasewa'] ?? '0',
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

    private function normalizeFilterDate(string $date): string
    {
        if ($date === '') {
            return '';
        }

        $parsed = \DateTimeImmutable::createFromFormat('!Y-m-d', $date);
        return $parsed && $parsed->format('Y-m-d') === $date ? $date : '';
    }

    public function detail($id)
    {
        $row = $this->pinjam_ruang->getById((int) $id);
        
        if (!$row) {
            return redirect()->to('/verifikasi-peminjaman-ruang')->with('error', 'Data peminjaman tidak ditemukan.');
        }

        return view('peminjaman-ruangan/admin/detail', [
            'title' => 'Detail Peminjaman Ruang',
            'row' => $row
        ]);
    }

    public function update()
    {
        $id = (int) $this->request->getPost('id');
        $now = date('Y-m-d H:i:s');

        $rules = [
            'id'                   => 'required|is_natural_no_zero', 
            'isverifikasi'         => 'required', 
            'tglverifikasi'        => 'required', 
            'keteranganverifikasi' => 'required'
        ];
        
        if (!$id || !$this->validate($rules))
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());

        $tglverifikasi   = date('Y-m-d H:i:s', strtotime($this->request->getPost('tglverifikasi')));
        $isverifikasi   = $this->request->getPost('isverifikasi');
        $hargasewa   = $this->request->getPost('hargasewa');
        $keteranganverifikasi   = $this->request->getPost('keteranganverifikasi');

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            
            $existing = $this->pinjam_ruang->getById($id);
            if (!$existing)
                throw new \RuntimeException('Data peminjaman tidak ditemukan.');
            
            $data = [
                'isverifikasi'         => $isverifikasi,
                'tglverifikasi'        => $tglverifikasi,
                'keteranganverifikasi' => $keteranganverifikasi ?? NULL,
                'hargasewa'            => $this->parseNumber($hargasewa)
            ];

            if (!$this->pinjam_ruang->update($id, $data)) {
                $dbError = $db->error();
                throw new \RuntimeException('Gagal memperbarui data peminjaman: ' . ($dbError['message'] ?? 'query database gagal.'));
            }

            if ($db->transStatus() === false)
                throw new \RuntimeException('DB transaction failed.');

            $db->transCommit();

            return redirect()->to('/verifikasi-peminjaman-ruang')->with('success', 'Berhasil verifikasi peminjaman ruang.');

        } catch (\Throwable $e) {
            $db->transRollback();

            log_message('error', $e->getMessage());

            return redirect()->back()->withInput()->with('errors', ['general' => $e->getMessage()]);
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
}
