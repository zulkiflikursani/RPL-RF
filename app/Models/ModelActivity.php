<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelActivity extends Model
{
    protected $table      = 'tb_log_activity';
    protected $allowedFields = ['id', 'user_id', 'tgl_activity', 'jenis_activity'];
    protected $primaryKey = 'id';
    protected $validationRules = [
        'user_id' => 'required',
        'jenis_activity' => 'required',
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
