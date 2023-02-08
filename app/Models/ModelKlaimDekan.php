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
        $result = $db->query("insert into mk_klaim_dekan select idklaim,kode_prodi,now() as tglbuat,'$idpengguna' as idpengguna from mk_klaim_prodi where mid(idklaim,6,10)='$noregis'");
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
        $result = $db->query("SELECT
                                mk_klaim_dekan.idklaim,
                                mk_klaim_dekan.kode_prodi,
                                mk_klaim_dekan.idpengguna,
                                mk_klaim_asessor.ta_akademik,
                                mk_klaim_asessor.no_peserta,
                                mk_klaim_asessor.kode_matakuliah,
                                mk_klaim_header.nama_matakuliah,
                                prodi.nama_prodi,
                                fakultas.nama_fakultas,
                                mk_klaim_asessor.nilai,
                                mk_klaim_header.sks,
                                prodi.id_jenjang,
                                bio_peserta.nama,
                                bio_peserta.instansi_asal,
                                bio_peserta.didikakhir,
                                bio_peserta.jenis_rpl
                                FROM
                                mk_klaim_dekan
                                LEFT JOIN mk_klaim_asessor ON mk_klaim_dekan.idklaim = mk_klaim_asessor.idklaim
                                LEFT JOIN mk_klaim_prodi ON mk_klaim_prodi.idklaim = mk_klaim_asessor.idklaim
                                LEFT JOIN mk_klaim_header ON mk_klaim_asessor.idklaim = mk_klaim_header.idklaim
                                LEFT JOIN prodi ON mk_klaim_header.kode_prodi = prodi.kode_prodi
                                LEFT JOIN fakultas ON prodi.kode_fakultas = fakultas.kode_fakultas
                                LEFT JOIN bio_peserta ON bio_peserta.no_peserta = mk_klaim_asessor.no_peserta where mid(mk_klaim_dekan.idklaim,6,10)='$noregis' and mk_klaim_prodi.idklaim is not null  and mk_klaim_asessor.idklaim is not null  and mk_klaim_dekan.idklaim is not null
                                ")->getResult();
        return $result;
    }
}
