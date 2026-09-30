<?php

namespace App\Models;

use CodeIgniter\Model;

class Pertanyaan extends Model
{
    protected $table = 'st_pertanyaanumum';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    // protected $allowedFields = ['email', 'username'];

    protected $allowedFields = [
        'pertanyaan',
        'jawaban'
    ];

    private function baseQuery(string $search = '')
    {
        $builder = $this->builder();
        $builder->select('*');

        $search = trim($search);

        if ($search !== '') {
            $builder->groupStart()
                ->like('pertanyaan', $search)
                ->orlike('jawaban', $search)
                ->groupEnd();
        }

        return $builder;
    }

    public function countAll(): int
    {
        return $this->baseQuery()->countAllResults();
    }

    public function countFiltered(string $search): int
    {
        return $this->baseQuery($search)->countAllResults();
    }

    public function getPage(
        string $search,
        int $limit = 10,
        int $offset = 0,
        string $orderBy = 'id',
        string $orderDir = 'ASC'
    ): array {
        $allowedOrder = [
            'id'
        ];

        $orderBy = in_array($orderBy, $allowedOrder, true)
            ? $orderBy
            : 'id';

        $orderDir = strtoupper($orderDir) === 'DESC'
            ? 'DESC'
            : 'ASC';

        return $this->baseQuery($search)
            ->orderBy($orderBy, $orderDir)
            ->limit($limit, $offset)
            ->get()
            ->getResultArray();
    }

    public function getAll(): array
    {
        return $this->orderBy('id', 'ASC')
            ->findAll();
    }

    public function getById(int $id): ?array
    {
        return $this->find($id);
    }
}
