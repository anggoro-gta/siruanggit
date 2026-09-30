<?php

namespace App\Models;

use CodeIgniter\Model;

class KontakKami extends Model
{
    protected $table = 'st_kontakkami';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    // protected $allowedFields = ['email', 'username'];

    protected $allowedFields = [
        'alamat',
        'email',
        'telp',
        'latitude',
        'longitude',
    ];
}
