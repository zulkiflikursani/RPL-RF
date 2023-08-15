<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKonsentrasi extends Model
{
    protected $table      = 'tb_konsentrasi';
    protected $primaryKey = 'kode_konsentrasi';

    protected $allowedFields = [
        "prodi",
        "kode_konsentrasi",
        "konsentrasi",

    ];

    protected $validationRules = [
        "prodi" => 'required',
        "kode_konsentrasi" => 'required|is_unique[tb_konsentrasi.kode_konsentrasi]',
        "konsentrasi" => 'required',


    ];

    protected $validationMessages = [
        'kode_konsentrasi' => [
            'is_unique' => 'Maaf. Kode kodensentrasi sudah digunakan.',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $returnType     = 'array';
    public function getDataKonsentrasiByProdi($prodi)
    {
        $db      = \Config\Database::connect();
        $result = $db->query("SELECT tb_konsentrasi.prodi,tb_konsentrasi.kode_konsentrasi,tb_konsentrasi.konsentrasi, prodi.nama_prodi from tb_konsentrasi LEFT JOIN prodi on tb_konsentrasi.prodi = prodi.kode_prodi where tb_konsentrasi.prodi ='$prodi'")->getResult();

        return $result;
    }
}
