<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMatakuliahx extends Model
{
    protected $table      = 'matakuliah';
    protected $primaryKey = 'no_peserta';

    protected $returnType     = 'array';


    protected $allowedFields = [
        'id', 'status',
        'kode_prodi',
        'kode_matakuliah',
        'kode_konsentrasi',
        'nama_matakuliah',
        'sks',
        'id_kurikulum'
    ];

    protected $validationRules = [
        'id' => 'required',
        'status' => 'required',
        'kode_prodi' => 'required',
        'kode_matakuliah' => 'required',
        'kode_konsentrasi' => 'required',
        'nama_matakuliah' => 'required',
        'sks' => 'required',
        'id_kurikulum' => 'required'
    ];
    protected $validationMessages = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getMatakuliahByprodi($kode_prodi)
    {
        $db = \Config\Database::connect();
        $result = $db->query("select matakuliah.kode_prodi,matakuliah.kode_matakuliah,matakuliah.kode_konsentrasi,matakuliah.nama_matakuliah, matakuliah.sks, matakuliah.id_kurikulum from  matakuliah where kode_prodi = '$kode_prodi'")->getResult();
        return $result;
    }
    public function getMatakuliahRplByprodi($kode_prodi)
    {
        $db = \Config\Database::connect();
        $result = $db->query("select matakuliah.kode_prodi,matakuliah.kode_matakuliah,matakuliah.kode_konsentrasi,matakuliah.nama_matakuliah, matakuliah.sks, matakuliah.id_kurikulum from  matakuliah where kode_prodi = '$kode_prodi'")->getResult();
        return $result;
    }
}
