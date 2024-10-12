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
        $cekuser = $db->query("select * from mk_klaim_dekan where mid(idklaim,6,10)='$noregis' and idpengguna='$idpengguna'")->getResult();
        if ($cekuser != null) {
            $result = $db->query("delete from mk_klaim_dekan where mid(idklaim,6,10)='$noregis' and idpengguna='$idpengguna'");
            return $result;
        } else {
            return "user false";
        }
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
                                LEFT JOIN bio_peserta ON bio_peserta.no_peserta = mk_klaim_asessor.no_peserta where mid(mk_klaim_dekan.idklaim,6,10)='$noregis' and mk_klaim_prodi.idklaim is not null  and mk_klaim_asessor.idklaim is not null and mk_klaim_asessor.nilai != 'E' and mk_klaim_dekan.idklaim is not null
                                ")->getResult();
        return $result;
    }
    public function getDatatoSiska($noregis)
    {
        $db = \Config\Database::connect();
        $result = $db->query("SELECT
                                mk_klaim_dekan.idklaim,
                                mk_klaim_dekan.kode_prodi,
                                mk_klaim_dekan.idpengguna,
                                mk_klaim_asessor.ta_akademik,
                                mk_klaim_asessor.no_peserta,
                                klaim_a1.kode_matakuliah_asal,
                                klaim_a1.nama_matakuliah_asal,
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
                                bio_peserta.jenis_rpl,
                                1 as entry_count
                                -- (SELECT COUNT(*) FROM mk_klaim_a1 as it 
                                -- WHERE CONCAT(it.ta_akademik,it.no_registrasi,it.kode_matakuliah) =  CONCAT(klaim_a1.ta_akademik,klaim_a1.no_registrasi,klaim_a1.kode_matakuliah)) as entry_count
                                FROM
                                mk_klaim_dekan
                                LEFT JOIN mk_klaim_asessor ON mk_klaim_dekan.idklaim = mk_klaim_asessor.idklaim
                                LEFT JOIN (SELECT
                                            mk_klaim_a1.ta_akademik,
                                            mk_klaim_a1.no_registrasi,
                                            mk_klaim_a1.kode_matakuliah_asal,
                                            dok_a1.nama_matakuliah as nama_matakuliah_asal,
                                            mk_klaim_a1.kode_matakuliah,
                                            mk_klaim_a1.nilai,
                                            mk_klaim_a1.tglklaim
                                        FROM mk_klaim_a1
                                        left JOIN
                                        dok_a1 on mk_klaim_a1.no_registrasi = dok_a1.no_registrasi and TRIM(mk_klaim_a1.kode_matakuliah_asal) = TRIM(dok_a1.kode_matakuliah)
                                        ) klaim_a1 on mk_klaim_dekan.idklaim = CONCAT(klaim_a1.ta_akademik,klaim_a1.no_registrasi,klaim_a1.kode_matakuliah)
                                LEFT JOIN mk_klaim_prodi ON mk_klaim_prodi.idklaim = mk_klaim_asessor.idklaim
                                LEFT JOIN mk_klaim_header ON mk_klaim_asessor.idklaim = mk_klaim_header.idklaim and mk_klaim_asessor.idklaim is not null
                                LEFT JOIN prodi ON mk_klaim_header.kode_prodi = prodi.kode_prodi
                                LEFT JOIN fakultas ON prodi.kode_fakultas = fakultas.kode_fakultas
                                LEFT JOIN bio_peserta ON bio_peserta.no_peserta = mk_klaim_asessor.no_peserta where mid(mk_klaim_dekan.idklaim,6,10)='$noregis' and mk_klaim_prodi.idklaim is not null  and mk_klaim_asessor.idklaim is not null and mk_klaim_asessor.nilai != 'E' and mk_klaim_header.idklaim is not null
                                GROUP BY mk_klaim_asessor.idklaim
                                ORDER BY mk_klaim_asessor.kode_matakuliah
                                ")->getResult();
        return $result;
    }
}