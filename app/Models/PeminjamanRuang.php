<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanRuang extends Model
{
    protected $table = 'tb_pinjamruang';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    // Tabel tb_pinjamruang tidak memiliki kolom created_at/updated_at.
    protected $useTimestamps = false;
    // protected $allowedFields = ['email', 'username'];

    protected $allowedFields = [
        'nopinjam',
        'tglpinjam',
        'namaorganisasi',
        'namapeminjam',
        'nohp',
        'acara',
        'tgljamacaramulai',
        'tgljamacaraselesai',
        'filesuratpinjam',
        'kode_ruang',
        'isverifikasi',
        'tglverifikasi',
        'keteranganverifikasi',
        'kode_dinas',
        'username',
        'keteranganpembatalan',
        'nik',
        'wasatuhari',
        'waduajam',
        'rating',
        'testimoni',
        'durasisewa',
        'hargasewa',
        'totalhargasewa',
        'isverifikasibayar',
        'keteranganverifikasibayar',
        'buktibayar',
        'dokskrd',
        'dokizinpenggunaan',
        'doktdp',
        'dokpinjamruang',
        'dokskrdpeminjam',
        'doktdppeminjam',
        'dokpinjamruangpeminjam',
        'iskirimrating',
        'issuratizin',
        'istampilkantestimoni',
        'fototestimoni',
        'iskirimnotifbayar',
        'created_by',
        'created_at',
        'updated_at',
        'updated_by'
    ];

    private function baseQuery(string $kodeDinas = '', string $search = '', string $tanggalMulai = '', string $tanggalSelesai = '', string $status = '')
    {
        $builder = $this->builder();
        $builder
            ->select([
                'tb_pinjamruang.*',
                'ms_ruang.nama_ruang',
                'ms_ruang.alamat AS alamat_ruang',
                'ms_ruang.luas_ruang',
                'ms_ruang.jml_kursi',
                'ms_ruang.jml_meja',
                'ms_ruang.fasilitas',
                'ms_ruang.peruntukan',
                'ms_ruang.namapj AS namapj_ruang',
                'ms_ruang.telppj AS telppj_ruang',
                'users.alamat AS alamat_organisasi',
                'users.nip AS nip'
            ])
            ->join(
                'ms_ruang',
                'ms_ruang.kode_ruang COLLATE utf8mb4_general_ci = tb_pinjamruang.kode_ruang COLLATE utf8mb4_general_ci',
                'left',
                false
            )->join(
                'users',
                'users.kode_dinas COLLATE utf8mb4_general_ci = tb_pinjamruang.kode_dinas COLLATE utf8mb4_general_ci',
                'left',
                false
            );

        $search = trim($search);

        $kodeDinas = trim($kodeDinas);

        if($kodeDinas !== ''){
            $builder->where('tb_pinjamruang.kode_dinas', $kodeDinas);
        }

        if ($tanggalMulai !== '') {
            $builder->where('tb_pinjamruang.tglpinjam >=', $tanggalMulai . ' 00:00:00');
        }

        if ($tanggalSelesai !== '') {
            $builder->where('tb_pinjamruang.tglpinjam <=', $tanggalSelesai . ' 23:59:59');
        }

        if (in_array($status, ['pending'], true)) {
            // Kosong berarti belum diverifikasi: NULL atau string kosong.
            $builder->where(
                '(tb_pinjamruang.isverifikasi IS NULL)',
                null,
                false
            );
        } elseif (in_array($status, ['0', '1'], true)) {
            $builder->where('tb_pinjamruang.isverifikasi', $status);
        }

        if ($search !== '') {
            $builder->groupStart()
                ->like('tb_pinjamruang.nopinjam', $search)
                ->orLike('tb_pinjamruang.namaorganisasi', $search)
                ->orLike('tb_pinjamruang.namapeminjam', $search)
                ->orLike('ms_ruang.nama_ruang', $search)
                ->groupEnd();
        }

        return $builder;
    }

    public function countAll(string $kodeDinas = '', string $tanggalMulai = '', string $tanggalSelesai = '', string $status = ''): int
    {
        return $this->baseQuery($kodeDinas, '', $tanggalMulai, $tanggalSelesai, $status)->countAllResults();
    }

    public function countFiltered(string $kodeDinas = '', string $search = '', string $tanggalMulai = '', string $tanggalSelesai = '', string $status = ''): int
    {
        return $this->baseQuery($kodeDinas, $search, $tanggalMulai, $tanggalSelesai, $status)->countAllResults();
    }

    public function countBelumVerifikasi(): int
    {
        return $this->builder()
            ->where('isverifikasi IS NULL', null, false)
            ->countAllResults();
    }

    public function getPage(
        string $search,
        int $limit = 10,
        int $offset = 0,
        string $orderBy = 'tglpinjam',
        string $orderDir = 'DESC',
        string $kodeDinas = '',
        string $tanggalMulai = '',
        string $tanggalSelesai = '',
        string $status = ''
    ): array {
        $allowedOrder = [
            'tglpinjam'
        ];

        $orderBy = in_array($orderBy, $allowedOrder, true)
            ? $orderBy
            : 'tglpinjam';

        $orderDir = strtoupper($orderDir) === 'DESC'
            ? 'DESC'
            : 'ASC';

        return $this->baseQuery($kodeDinas, $search, $tanggalMulai, $tanggalSelesai, $status)
            ->orderBy($orderBy, $orderDir)
            ->limit($limit, $offset)
            ->get()
            ->getResultArray();
    }

    public function getAll(): array
    {
        return $this->baseQuery()
            ->orderBy('tb_pinjamruang.tglpinjam', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getById(int $id): ?array
    {
        return $this->baseQuery()
            ->where('tb_pinjamruang.id', $id)
            ->get()
            ->getRowArray() ?: null;
    }

    public function getTimelineByRange(string $mulai, string $selesai, string $kodeRuang = '', ?int $excludeId = null): array
    {
        return $this->baseQuery()
            ->select([
                'tb_pinjamruang.id',
                'tb_pinjamruang.nopinjam',
                'tb_pinjamruang.namapeminjam',
                'tb_pinjamruang.acara',
                'tb_pinjamruang.tgljamacaramulai',
                'tb_pinjamruang.tgljamacaraselesai',
                'tb_pinjamruang.isverifikasi',
                'ms_ruang.nama_ruang'
            ])
            ->where('tb_pinjamruang.tgljamacaramulai <=', $selesai)
            ->where('tb_pinjamruang.tgljamacaraselesai >=', $mulai)
            ->where('tb_pinjamruang.kode_ruang', $kodeRuang)
            ->groupStart()
                ->where('tb_pinjamruang.isverifikasi', 1)
                ->orWhere('tb_pinjamruang.isverifikasi IS NULL', null, false)
            ->groupEnd()
            ->when($excludeId, static function ($query) use ($excludeId) {
                $query->where('tb_pinjamruang.id !=', $excludeId);
            })
            ->orderBy('tb_pinjamruang.tgljamacaramulai', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function hasConflict(string $mulai, string $selesai, string $kodeRuang, ?int $excludeId = null): bool
    {
        $query = $this->builder()
            ->select('id')
            ->where('kode_ruang', $kodeRuang)
            ->where('tgljamacaramulai <=', $selesai)
            ->where('tgljamacaraselesai >=', $mulai)
            ->groupStart()
                ->where('isverifikasi', 1)
                ->orWhere('isverifikasi IS NULL', null, false)
            ->groupEnd();

        if ($excludeId) {
            $query->where('id !=', $excludeId);
        }

        return $query->countAllResults() > 0;
    }
}
