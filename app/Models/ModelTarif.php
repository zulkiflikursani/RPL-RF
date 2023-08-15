<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTarif extends Model
{
    protected $table      = 'prodi';
    protected $allowedFields = ['id', 'kode_fakultas', 'id_jenjang', 'kode_prodi', 'nama_prodi', 'ka_prodi', 'sks', 'tarif', 'prakademik', 'bpp', 'spp', 'sks_max_rekognisi'];
    protected $primaryKey = 'id';
    protected $validationRules = [
        'id' => 'require',
        'kode_fakultas' => 'required',
        'id_jenjang' => 'required',
        'kode_prodi' => 'required',
        'nama_prodi' => 'required',
        'ka_prodi' => 'required',
        'sks' => 'required',
        'tarif' => 'required',
        'prakademik' => 'required',
        'bpp' => 'required',
        'spp' => 'required',
        'sks_max_rekognisi' => 'required'
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
