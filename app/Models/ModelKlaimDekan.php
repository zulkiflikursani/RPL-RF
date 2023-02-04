<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKlaimDekan extends Model
{
    protected $table      = 'mk_klaim_dekan';
    protected $primaryKey = 'idklaim';

    protected $returnType     = 'array';


    protected $allowedFields = [
        "idklaim",
        "kode_prodi",
        "tglbuat",
        "idpengguna",
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tglbuat';

    protected $validationRules = [
        'idklaim'     => 'required',
        'kode_prodi'     => 'required',
        'idpengguna'     => 'required',
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function validdekan($noregis, $idpengguna)
    {
        $db = \Config\Database::connect();
        $result = $db->query("insert into mk_klaim_dekan select idklaim,kode_prodi,now() as tglbuat,$idpengguna as idpengguna from mk_klaim_prodi where mid(idklaim,6,10)='$noregis'");
        return $result;
    }
    public function unvaliddekan($noregis, $idpengguna)
    {
        $db = \Config\Database::connect();
        $result = $db->query("delete from mk_klaim_dekan where mid(idklaim,6,10)='$noregis' and idpengguna='$idpengguna'");
        return $result;
    }

    public function chekstauspeserta($noregis)
    {
        $db = \Config\Database::connect();
        $result = $db->query("select idklaim from mk_klaim_dekan where mid(idklaim,6,10)='$noregis'")->getResult();
        return $result;
    }
    public function chekstauspesertaasessor($noregis)
    {
        $db = \Config\Database::connect();
        $result = $db->query("select idklaim from mk_klaim_asessor where mid(idklaim,6,10)='$noregis'")->getResult();
        return $result;
    }
    public function chekstauspesertaprodi($noregis)
    {
        $db = \Config\Database::connect();
        $result = $db->query("select idklaim from mk_klaim_prodi where mid(idklaim,6,10)='$noregis'")->getResult();
        return $result;
    }
    public function getDatatoPrint($noregis)
    {
        $db = \Config\Database::connect();
        $result = $db->query("select idklaim from mk_klaim_dekan wshere mid(mk_klaim_dekan.idklaim,6,10)='$noregis'")->getResult();
        return $result;
    }
}
