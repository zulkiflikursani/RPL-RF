<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelNilai extends Model
{
    protected $table = 'nilai';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        "id", "kode_nilai", "bobot"
    ];



    protected $validationRules = [
        "id" => 'required|is_unique[nilai.id]',
        "kode_nilai" => 'required|is_unique[nilai.kode_nilai]',
        "bobot" => 'required',
    ];
    protected $validationMessages = [
        'kode_nilai' => [
            'is_unique' => 'Sorry. Nilai yang anda masukkan sudah digunakan.',
        ],
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    protected $returnType = 'array';
}
