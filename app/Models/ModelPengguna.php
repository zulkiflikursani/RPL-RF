<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPengguna extends Model
{
    protected $table      = 'tb_pengguna';
    protected $primaryKey = 'email';

    protected $returnType     = 'array';
    protected $allowedFields = [
        "idpengguna",
        "nmpengguna",
        "sttpengguna",
        "email",
        "ktkunci",
        "kode_prodi",
        "tglbuat",
        "tglubah",
    ];
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tglbuat';
    protected $updatedField  = 'tglubah';
    protected $validationRules = [
        "idpengguna" => 'required',
        "nmpengguna" => 'required',
        "sttpengguna" => 'required',
        "email" => 'required|valid_email|is_unique[tb_pengguna.email]',
        "ktkunci" => 'required',
        "kode_prodi" => 'required'
    ];
    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Sorry. Email sudah digunakan. Silahkan gunakan email yang lain.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}