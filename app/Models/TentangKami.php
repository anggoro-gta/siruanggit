<?php

namespace App\Models;

use CodeIgniter\Model;

class TentangKami extends Model
{
    protected $table = 'st_tentangkami';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    // protected $allowedFields = ['email', 'username'];

    protected $allowedFields = [
        'judul',
        'isi',
    ];

    //method tambahan GTA
    public function gettentangkami()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('st_tentangkami');

        $builder->select('*');

        $query = $builder->get();

        $total = $query->getResultArray();

        return $total;
    }
}
