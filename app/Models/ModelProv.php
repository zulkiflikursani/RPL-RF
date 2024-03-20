<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelProv extends Model
{
    protected $table      = 'wilayah';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $allowedFields = [
        "id",
        "idprov",
        "idkot",
        "idkec",
        "idkel",
        "kode_wilayah",
        "nama_wilayah",
        "tingkat",
        "kode_propinsi_dikti"
    ];

    public function getProv()
    {
        return $this->select('idprov as KDPROTBPRO,nama_wilayah as NMPROTBPRO, idkot as KDKABTBPRO')
            ->where('tingkat', '1')
            ->get()
            ->getResult();
    }
}
