<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelProv extends Model
{
    protected $table      = 'dikti_tb_tbpro';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $allowedFields = [
        "ID",
        "KDPROTBPRO",
        "NMPROTBPRO",
        "KDKABTBPRO",
        "NMKABTBPRO",
        "LUASSTBPRO",
        "JMDUKTBPRO",
        "JMDPTTBPRO",
    ];

    public function getProv()
    {
        return $this->select('*')
            ->groupBy("KDPROTBPRO")
            ->get()
            ->getResult();
    }
}