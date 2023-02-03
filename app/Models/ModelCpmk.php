<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelCpmk extends Model
{
    protected $table      = 'mk_cpmk';
    protected $primaryKey = 'idcpmk';

    protected $returnType     = 'array';


    protected $allowedFields = [
        "kode_prodi",
        "kode_matakuliah",
        "idcpmk",
        "cpmk",
    ];

    // protected $useTimestamps = true;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'tglbuat';
    // protected $updatedField  = 'tglubah';
    protected $validationRules = [
        "kode_prodi" => 'required',
        "kode_matakuliah" => 'required',
        "idcpmk" => 'required|is_unique[mk_cpmk.idcpmk]',
        "cpmk" => 'required',

    ];
    protected $validationMessages = [
        'idcpmk' => [
            'is_unique' => 'Sorry. Nomor peserta sudah digunakan.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getAllprodi()
    {
        $db = \Config\Database::connect();
        $result = $db->query("select * from prodi")->getResult();
        return $result;
    }

    public function editcpmk($idcpmk, $kd_prodi, $nmcpmk)
    {
        $db = \Config\Database::connect();
        $result = $db->query("update mk_cpmk set cpmk='$nmcpmk' where kode_prodi='$kd_prodi' and idcpmk='$idcpmk'");
        return $result;
    }
    public function hapuscpmk($idcpmk, $kd_prodi, $nmcpmk)
    {
        $db = \Config\Database::connect();
        $result = $db->query("delete from mk_cpmk where kode_prodi='$kd_prodi' and idcpmk='$idcpmk'");
        return $result;
    }
    // public function update_by_noregis($data, $noregis)
    // {
    //     // $Modal = new ModelBiodata();

    // }
}
