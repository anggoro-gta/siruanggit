<?php

namespace App\Controllers;


use App\Models\PeminjamanRuang;
use App\Models\Ruang;

class VerifikasiPembayaranController extends BaseController
{
    protected $pinjam_ruang;
    protected $ruang;
    protected $userId = null;

    public function __construct()
    {
        $this->pinjam_ruang = new PeminjamanRuang();
        $this->ruang = new Ruang();
        $this->userId = function_exists('user') ? (user()->id ?? null) : null;
    }

    public function index(): string
    {
        $data = [
            'title' => 'Verifikasi Pembayaran'
        ];

        return view('pembayaran/index', $data);
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
            
            $status = '1';

            $is_verif_pembayaran = true;


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

            $recordsTotal = $this->pinjam_ruang->countAll('', '', $tanggalMulai, $tanggalSelesai, $status, $is_verif_pembayaran);
            $recordsFiltered = $this->pinjam_ruang->countFiltered('', '', $search, $tanggalMulai, $tanggalSelesai, $status, $is_verif_pembayaran);
            $rows = $this->pinjam_ruang->getPage($search, $length, $start, $orderBy, $orderDir, '', '', $tanggalMulai, $tanggalSelesai, $status, $is_verif_pembayaran);

            $data = [];
            foreach ($rows as $r) {

                $isVerifikasi      = (string) ($r['isverifikasi'] ?? '');
                $isVerifikasiBayar = isset($r['isverifikasibayar'])
                    ? (string) $r['isverifikasibayar']
                    : '';

                $id        = (int) $r['id'];
                $hargaSewa = (float) ($r['hargasewa'] ?? 0);


                /*
                |--------------------------------------------------------------------------
                | URL ACTION
                |--------------------------------------------------------------------------
                */

                $urlDetail = base_url('verifikasi-pembayaran/detail/' . $id);


                /*
                |--------------------------------------------------------------------------
                | STATUS VERIFIKASI
                |--------------------------------------------------------------------------
                */

                switch ($isVerifikasi) {
                    case '1':
                        $status = '
                            <span class="badge rounded-pill bg-label-success">
                                Disetujui
                            </span>';
                        break;

                    case '0':
                        $status = '
                            <span class="badge rounded-pill bg-label-danger">
                                Ditolak
                            </span>';
                        break;

                    case '2':
                        $status = '
                            <span class="badge rounded-pill bg-label-secondary">
                                Dibatalkan
                            </span>';
                        break;

                    default:
                        $status = '
                            <span class="badge rounded-pill bg-label-info">
                                Belum Verifikasi
                            </span>';
                        break;
                }


                /*
                |--------------------------------------------------------------------------
                | TOMBOL AKSI
                |--------------------------------------------------------------------------
                |
                | Semua status memiliki tombol Detail.
                | Tombol Cetak hanya muncul jika peminjaman sudah disetujui.
                |
                */

                $btn = '
                    <div class="user-table-actions">

                        <a href="' . $urlDetail . '"
                        class="btn btn-xs btn-outline-info"
                        title="Detail"
                        aria-label="Detail">
                            <i class="bx bx-detail"></i>
                        </a>';

                $btn .= '
                    </div>';


                /*
                |--------------------------------------------------------------------------
                | INFORMASI ACARA
                |--------------------------------------------------------------------------
                */

                $acara = '
                    <div class="acara-wrapper">

                        <div class="acara-item">

                            <span class="acara-icon">
                                <i class="bx bx-calendar"></i>
                            </span>

                            <div class="acara-text">

                                <div>
                                    ' . esc(tanggal_indo($r['tgljamacaramulai'])) . '
                                    ' . date('H:i', strtotime($r['tgljamacaramulai'])) . '
                                    s.d.
                                </div>

                                <div>
                                    ' . esc(tanggal_indo($r['tgljamacaraselesai'])) . '
                                    ' . date('H:i', strtotime($r['tgljamacaraselesai'])) . '
                                </div>

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


                /*
                |--------------------------------------------------------------------------
                | NAMA PEMINJAM
                |--------------------------------------------------------------------------
                */

                $nama_peminjam = '
                    ' . esc($r['namapeminjam'] ?? '-') . '
                    <br>
                    <small class="text-muted">
                        ' . esc($r['namaorganisasi'] ?? '-') . '
                    </small>';


                /*
                |--------------------------------------------------------------------------
                | HARGA SEWA
                |--------------------------------------------------------------------------
                */

                $harga_pinjam = 'Rp ' . number_format(
                    $hargaSewa,
                    0,
                    ',',
                    '.'
                );


                /*
                |--------------------------------------------------------------------------
                | STATUS PEMBAYARAN
                |--------------------------------------------------------------------------
                |
                | Status pembayaran ditampilkan apabila:
                | 1. Harga sewa > 0
                | 2. Peminjaman sudah disetujui atau dibatalkan
                |
                | isverifikasibayar:
                | 1    = Sudah Bayar
                | 0    = Menunggu Verifikasi Pembayaran
                | null = Belum Bayar
                |
                */

                $status_bayar = '';

                if (
                    $hargaSewa > 0 &&
                    in_array($isVerifikasi, ['1', '2'], true)
                ) {

                    switch ($isVerifikasiBayar) {
                        case '1':
                            $status_bayar = '
                                <br>
                                <span class="text-success">
                                    <i>Sudah Bayar</i>
                                </span>';
                            break;

                        case '0':
                            $status_bayar = '
                                <br>
                                <span class="text-info">
                                    <i>Menunggu Verifikasi Pembayaran</i>
                                </span>';
                            break;

                        default:
                            $status_bayar = '
                                <br>
                                <span class="text-warning">
                                    <i>Belum Bayar</i>
                                </span>';
                            break;
                    }
                }

                $data[] = [
                    'no_pinjam' => $r['nopinjam'] ?? '-',
                    'tgl_pinjam' => tanggal_indo($r['tglpinjam']) . ' ' . date('H:i:s', strtotime($r['tglpinjam'])) ?? '-',
                    'nama_peminjam' => $nama_peminjam,
                    'nama_ruang' => $r['nama_ruang'] ?? '-',
                    'acara' => $acara,
                    'harga_pinjam' => $harga_pinjam . $status_bayar,
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
            return redirect()->to('/verifikasi-pembayaran')->with('error', 'Data peminjaman tidak ditemukan.');
        }

        return view('pembayaran/detail', [
            'title' => 'Detail Peminjaman Ruang',
            'row' => $row
        ]);
    }
    
    public function update()
    {
        $id = (int) $this->request->getPost('id');
        $now = date('Y-m-d H:i:s');

        $rules = [
            'id'                        => 'required|is_natural_no_zero', 
            'isverifikasibayar'         => 'required', 
            'tglverifikasibayar'        => 'required', 
            'keteranganverifikasibayar' => 'permit_empty|string|max_length[500]',
        ];
        
        if (!$id || !$this->validate($rules))
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());

        $tglverifikasibayar   = date('Y-m-d H:i:s', strtotime($this->request->getPost('tglverifikasibayar')));
        $isverifikasibayar   = $this->request->getPost('isverifikasibayar');
        $keteranganverifikasibayar   = $this->request->getPost('keteranganverifikasibayar');

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            
            $existing = $this->pinjam_ruang->getById($id);
            if (!$existing)
                throw new \RuntimeException('Data peminjaman tidak ditemukan.');
            
            $data = [
                'isverifikasibayar'         => $isverifikasibayar,
                'tglverifikasibayar'        => $tglverifikasibayar,
                'keteranganverifikasibayar' => $keteranganverifikasibayar ?? NULL
            ];

            if (!$this->pinjam_ruang->update($id, $data)) {
                $dbError = $db->error();
                throw new \RuntimeException('Gagal verifikasi pembayaran : ' . ($dbError['message'] ?? 'query database gagal.'));
            }

            if ($db->transStatus() === false)
                throw new \RuntimeException('DB transaction failed.');

            $db->transCommit();

            return redirect()->to('/verifikasi-pembayaran')->with('success', 'Berhasil verifikasi pembayaran.');

        } catch (\Throwable $e) {
            $db->transRollback();

            log_message('error', $e->getMessage());

            return redirect()->back()->withInput()->with('errors', ['general' => $e->getMessage()]);
        }
    }
}
