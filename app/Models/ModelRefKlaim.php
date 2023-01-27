<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelRefKlaim extends Model
{
    protected $table      = 'ref_klaim';

    protected $returnType     = 'array';


    protected $allowedFields = [
        "idklaim",
        "kode_matakuliah",
        "no_dokumen",
        "lokasi_file",
        "nmfile_asli",
        "tglbuat",
        "tglubah"
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tglbuat';
    protected $updatedField  = 'tglubah';
    protected $validationRules = [
        'idklaim'     => 'required',
        'kode_matakuliah' => 'required',
        'no_dokumen' => 'required',
        'lokasi_file'     => 'required',
        'nmfile_asli'     => 'required',

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