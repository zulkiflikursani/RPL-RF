<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMasterRpl extends Model
{
    protected $table      = 'master_rpl';
    // protected $primaryKey = 'kode_matakuliah';

    protected $allowedFields = [
        "kode_prodi",
        "jenis_rpl",

    ];

    protected $validationRules = [
        "kode_prodi" => 'required',
        "jenis_rpl" => 'required',
        // "kode_perguruan_tinggi" => 'required',
        // "nama_perguruan_tinggi" => 'required',
        // "kode_matakuliah" => 'required',
        // "nama_matakuliah" => 'required',
        // "jumlah_sks" => 'required',
        // "status" => 'required',
        // "nilai" => 'required',

    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $returnType     = 'array';

    public function getProdiByRpl($jenis_rpl)
    {
        $db      = \Config\Database::connect();
        $getProdi = $db->query("SELECT master_rpl.jenis_rpl,prodi.nama_prodi,master_rpl.kode_prodi FROM master_rpl left join prodi on master_rpl.kode_prodi = prodi.kode_prodi where master_rpl.jenis_rpl='$jenis_rpl'")->getResult();
        return $getProdi;
    }
}
