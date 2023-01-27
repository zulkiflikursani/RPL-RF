<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKlaimMkDetail extends Model
{
    protected $table      = 'mk_klaim_detail';

    protected $returnType     = 'array';


    protected $allowedFields = [
        "idklaim",
        "idcpmk",
        "cpmk",
        "klaim",
        "statusklaim",
        "tglbuat",
        "tglubah"
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tglbuat';
    protected $updatedField  = 'tglubah';
    protected $validationRules = [
        'idklaim'     => 'required',
        'idcpmk'     => 'required',
        'cpmk'     => 'required',
        'klaim'     => 'required',
        'statusklaim'     => 'required',

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