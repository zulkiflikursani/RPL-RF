<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPtIndo extends Model
{
    protected $table      = 'perguruan_tinggi';
    protected $primaryKey = 'id_perguruan_tinggi';
    protected $allowedFields = [
        "id_perguruan_tinggi_dikti",
        "kode_perguruan_tinggi",
        "nama_perguruan_tinggi",
        "nama_singkat"
    ];

    protected $returnType     = 'array';
}