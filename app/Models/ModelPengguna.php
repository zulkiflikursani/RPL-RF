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
        "kode_fakultas",
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
        "email" => 'required|valid_email|is_unique[tb_pengguna.email]|is_unique[reg_peserta.email]',
        "ktkunci" => 'required',
        "kode_prodi" => 'required',
        "kode_fakultas" => 'required'
    ];
    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Email sudah digunakan. Silahkan gunakan email yang lain.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
