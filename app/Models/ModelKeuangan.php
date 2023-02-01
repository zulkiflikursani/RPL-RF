<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKeuangan extends Model
{
    protected $table      = 'tb_valid_keu';
    protected $primaryKey = 'no_peserta';

    protected $returnType     = 'array';


    protected $allowedFields = [
        "ta_akademik",
        "no_peserta",
        "tglbuat",
        "tglubah",
        "id_pengguna"

    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tglbuat';
    protected $updatedField  = 'tglubah';
    protected $validationRules = [
        "ta_akademik" => 'required',
        "no_peserta" => 'required|is_unique[tb_valid_keu.no_peserta]',
        "id_pengguna" => 'required'
    ];
    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Sorry. Nomor peserta sudah digunakan.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // public function update_by_noregis($data, $noregis)
    // {
    //     // $Modal = new ModelBiodata();

    // }
}