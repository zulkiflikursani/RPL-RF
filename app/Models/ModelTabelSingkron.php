<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTabelSingkron extends Model
{
    protected $table      = 'tb_singkron_simba';
    protected $allowedFields = ['id', 'no_peserta', 'no_tes_simba'];
    protected $primaryKey = 'id';
    protected $validationRules = [
        'no_peserta' => 'required',
        'no_tes_simba' => 'required',
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
