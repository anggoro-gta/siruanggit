<?php

namespace App\Models;

use CodeIgniter\Model;

class Slider extends Model
{
    protected $table = 'ms_slider';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    // protected $allowedFields = ['email', 'username'];

    protected $allowedFields = [
        'nourut',
        'kode_slider',
        'file_slider',
        'is_show'
    ];

    private function baseQuery(string $search = '')
    {
        $builder = $this->builder();
        $builder->select('*');

        $search = trim($search);

        if ($search !== '') {
            $builder->groupStart()
                ->like('nourut', $search)
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
        string $orderBy = 'nourut',
        string $orderDir = 'ASC'
    ): array {
        $allowedOrder = [
            'nourut'
        ];

        $orderBy = in_array($orderBy, $allowedOrder, true)
            ? $orderBy
            : 'nourut';

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
        return $this->orderBy('nourut', 'ASC')
            ->findAll();
    }

    public function getById(int $id): ?array
    {
        return $this->find($id);
    }

    //method tambahan GTA
    public function getsliderisshow()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_slider');

        $builder->select('*');

        $array = ['is_show' => 1];
        $builder->where($array);

        $builder->orderBy('nourut', 'ASC');
        $query = $builder->get();

        $total = $query->getResultArray();

        return $total;
    }
}
