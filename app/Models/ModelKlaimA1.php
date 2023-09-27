<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKlaimA1 extends Model
{
    protected $table      = 'mk_klaim_a1';

    protected $returnType     = 'array';


    protected $allowedFields = [
        "ta_akademik",
        "no_registrasi",
        "kode_matakuliah_asal",
        "kode_matakuliah",
        "nilai",
        "tglkirim"
    ];

    protected $useTimestamps = true;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'tglbuat';
    // protected $updatedField  = 'tglubah';
    protected $validationRules = [
        'ta_akademik'     => 'required',
        'no_registrasi'     => 'required',
        'kode_matakuliah_asal'     => 'required',
        'kode_matakuliah'     => 'required',
        'nilai'     => 'required',
        'tglkirim'     => 'required',

    ];
    // protected $validationMessages = [
    //     'idklaim' => [
    //         'is_unique' => 'Sorry id klaim sudah digunakan.Silahkan hubungi admin.',
    //     ],
    // ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // public function update_by_noregis($data, $noregis)
    // {
    //     // $Modal = new ModelBiodata();

    // }
}
