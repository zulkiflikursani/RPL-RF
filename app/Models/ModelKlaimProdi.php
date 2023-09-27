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

    public function getDataMahasiswaOkper($ta_akademik, $kode_prodi)
    {
        $db = \Config\Database::connect();
        $result = $db->query("SELECT
        mk_klaim_dekan.idklaim,
        mk_klaim_asessor.ta_akademik,
        mk_klaim_asessor.no_peserta,
        bio_peserta.nama,
        mk_klaim_asessor.kode_matakuliah,
        mk_klaim_asessor.nilai,
        matakuliah.sks,
        mk_klaim_header.nama_matakuliah,
        mk_klaim_asessor.kode_prodi,
        bio_peserta.jenis_rpl,
        bio_peserta.instansi_asal,
        prodi.nama_prodi,
        prodi.id_jenjang,
        fakultas.nama_fakultas,
        fakultas.kode_fakultas,
        (SELECT COUNT(*) FROM mk_klaim_asessor as it 
                                WHERE mid(it.idklaim,6,10) = mid(mk_klaim_asessor.idklaim,6,10)  and it.nilai !='E') as jbaris
        FROM
        mk_klaim_dekan
        LEFT JOIN mk_klaim_asessor ON mk_klaim_dekan.idklaim = mk_klaim_asessor.idklaim
        LEFT JOIN bio_peserta ON mid(mk_klaim_dekan.idklaim,6,10)= bio_peserta.no_peserta
        LEFT JOIN matakuliah ON mk_klaim_asessor.kode_matakuliah = matakuliah.kode_matakuliah AND mk_klaim_asessor.kode_prodi = matakuliah.kode_prodi
        LEFT JOIN prodi ON mk_klaim_asessor.kode_prodi = prodi.kode_prodi
        LEFT JOIN fakultas ON prodi.kode_fakultas = fakultas.kode_fakultas       
        left join mk_klaim_header on mk_klaim_asessor.idklaim= mk_klaim_header.idklaim
        where mk_klaim_asessor.kode_prodi='$kode_prodi' and mk_klaim_asessor.idklaim is not null and mk_klaim_asessor.ta_akademik ='$ta_akademik' and mk_klaim_asessor.nilai != 'E'
        order by mk_klaim_dekan.idklaim
        ")->getResult();
        return $result;
    }
}
