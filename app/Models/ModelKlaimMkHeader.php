<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKlaimMkHeader extends Model
{
    protected $table      = 'mk_klaim_header';
    protected $primaryKey = 'idklaim';

    protected $returnType     = 'array';


    protected $allowedFields = [
        "idklaim",
        "ta_akademik",
        "no_peserta",
        "kode_prodi",
        "kode_matakuliah",
        "nama_matakuliah",
        "sks",
        "tglbuat",
        "tglubah"
    ];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tglbuat';
    protected $updatedField  = 'tglubah';
    protected $validationRules = [
        'ta_akademik'     => 'required',
        'idklaim'     => 'required|is_unique[mk_klaim_header.idklaim]',
        'no_peserta'     => 'required',
        'kode_prodi'     => 'required',
        'kode_matakuliah'     => 'required',
        'nama_matakuliah'     => 'required',
        'sks'     => 'required',

    ];
    protected $validationMessages = [
        'idklaim' => [
            'is_unique' => 'Sorry id klaim sudah digunakan.Silahkan hubungi admin.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // public function update_by_noregis($data, $noregis)
    // {
    //     // $Modal = new ModelBiodata();

    // }
}