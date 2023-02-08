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

    public function validprodi($noregis, $idpengguna)
    {
        $db = \Config\Database::connect();
        $result = $db->query("insert into mk_klaim_prodi select idklaim,ta_akademik,kode_prodi,idpengguna as idasessor,now() as tglbuat,'$idpengguna' as idpengguna from mk_klaim_asessor where no_peserta='$noregis'");
        return $result;
    }
    public function unvalidprodi($noregis, $idpengguna)
    {
        $db = \Config\Database::connect();
        $result = $db->query("delete from mk_klaim_prodi where mid(idklaim,6,10)='$noregis' and idpengguna='$idpengguna'");
        return $result;
    }

    public function chekstauspeserta($noregis)
    {
        $db = \Config\Database::connect();
        $result = $db->query("select idklaim from mk_klaim_prodi where mid(idklaim,6,10)='$noregis'")->getResult();
        return $result;
    }
}
