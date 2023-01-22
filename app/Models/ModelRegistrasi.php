<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelRegistrasi extends Model
{
    protected $table      = 'reg_peserta';
    protected $primaryKey = 'no_registrasi';

    protected $returnType     = 'array';


    protected $allowedFields = ['ta_akademik', 'no_registrasi', 'nama', 'alamat', 'kotkab', 'propinsi', 'instansi_asal', 'nohape', 'email', 'kode_prodi', 'validasi_keu', 'ktkunci'];

    protected $validationRules = [
        'ta_akademik'     => 'required',
        'no_registrasi'     => 'required',
        'nama'     => 'required',
        'alamat'     => 'required',
        'kotkab'     => 'required',
        'propinsi'     => 'required',
        'instansi_asal'     => 'required',
        'nohape'     => 'required',
        'email'        => 'required|valid_email|is_unique[reg_peserta.email]',
        'kode_prodi'        => 'required',
        'validasi_keu'        => 'required',
        'ktkunci'        => 'required',
    ];
    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Sorry. Email sudah digunakan. Silahkan gunakan email yang lain.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}