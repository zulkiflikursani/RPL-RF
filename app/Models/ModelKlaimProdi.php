<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKlaimProdi extends Model
{
    protected $table      = 'mk_klaim_prodi';
    protected $primaryKey = 'idklaim';

    protected $returnType     = 'array';


    protected $allowedFields = [
        "idklaim",
        "ta_akademik",
        "kode_prodi",
        "idasessor",
        "tglbuat",
        "idpengguna",
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tglbuat';

    protected $validationRules = [
        'idklaim'     => 'required',
        'ta_akademik'     => 'required',
        'kode_prodi'     => 'required',
        'idasessor'     => 'required',
        'idpengguna'     => 'required',
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}