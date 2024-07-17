<?php

namespace App\Models;

use CodeIgniter\Model;
use PSpell\Config;

    class ModelMatakuliah extends Model
{
    protected $table      = 'matakuliah';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';


    protected $allowedFields = [
        "id",
        "status",
        "kode_prodi",
        "kode_matakuliah",
        "nama_matakuliah",
        'jenis_matakuliah',
        "sks",
        "id_kurikulum",

    ];

    protected $validationRules = [
        "kode_matakuliah" => 'required',
        "nama_matakuliah" => 'required',
        "sks" => 'required',
        "jenis_matakuliah" => 'required',
        "id_kurikulum" => 'required',

    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // public function update_by_noregis($data, $noregis)
    // {
    //     // $Modal = new ModelBiodata();

    // }

    public function getMatakuliahByprodi($kode_prodi)
    {
        // kode_prodi,kode_matakuliah,kode_konsentrasi,konsentrasi,nama_matakuliah,sks,id_kurikulum

        $db = \Config\Database::connect();
        $result = $db->query("select matakuliah.kode_prodi,matakuliah.kode_matakuliah,matakuliah.kode_konsentrasi,tb_konsentrasi.konsentrasi,matakuliah.nama_matakuliah, matakuliah.sks, matakuliah.id_kurikulum,matakuliah.jenis_matakuliah from  matakuliah left join tb_konsentrasi on matakuliah.kode_konsentrasi=tb_konsentrasi.kode_konsentrasi where kode_prodi = '$kode_prodi'")->getResult();
        return $result;
    }

    public function getMatakuliahAdmin()
    {
        $db = \Config\Database::connect();
        $result = $db->query("select matakuliah.kode_prodi,matakuliah.jenis_matakuliah,matakuliah.kode_matakuliah,matakuliah.kode_konsentrasi,tb_konsentrasi.konsentrasi,matakuliah.nama_matakuliah, matakuliah.sks, matakuliah.id_kurikulum from  matakuliah left join tb_konsentrasi on matakuliah.kode_konsentrasi=tb_konsentrasi.kode_konsentrasi where jenis_matakuliah='1' or jenis_matakuliah = '2'")->getResult();
        return $result;
    }

    public function getMatakuliahRplByprodi($kode_prodi, $ta_akademik)
    {
        $db = \Config\Database::connect();
        $result = $db->query("SELECT
                                    matakuliah.kode_prodi,
                                    matakuliah.kode_matakuliah,
                                    matakuliah.kode_konsentrasi,
                                    tb_konsentrasi.konsentrasi,
                                    matakuliah.nama_matakuliah,
                                    matakuliah.sks,
                                    matakuliah.id_kurikulum,
                                    mcpmk.idcpmk,
                                    mcpmk.cpmk,
                                    if(rplcpmk.idcpmk is NULL,0,1) AS status_rpl
                                    FROM
                                        matakuliah
                                    LEFT JOIN tb_konsentrasi ON matakuliah.kode_konsentrasi = tb_konsentrasi.kode_konsentrasi
                                    left join 
                                    (select * from
                                    master_cpmk where master_cpmk.kode_prodi='" . $kode_prodi . "')mcpmk
                                    on matakuliah.kode_matakuliah = mcpmk.kode_matakuliah 
                                    LEFT JOIN
                                    (select * from mk_cpmk where mk_cpmk.kode_prodi='" . $kode_prodi . "')rplcpmk
                                    on matakuliah.kode_matakuliah = rplcpmk.kode_matakuliah and rplcpmk.ta_akademik='" . $ta_akademik . "'
                                    WHERE
                                        matakuliah.kode_prodi = '" . $kode_prodi . "'
                                    AND jenis_matakuliah > 2 and mcpmk.kode_matakuliah is not null
                                    group by matakuliah.kode_matakuliah")->getResult();
        return $result;
    }
    public function getMatakuliahRplByAdmin($ta_akademik)
    {
        $db = \Config\Database::connect();
        $result = $db->query("SELECT
                                    matakuliah.kode_prodi,
                                    prodi.nama_prodi,
                                    matakuliah.kode_matakuliah,
                                    matakuliah.kode_konsentrasi,
                                    tb_konsentrasi.konsentrasi,
                                    matakuliah.nama_matakuliah,
                                    matakuliah.sks,
                                    matakuliah.id_kurikulum,
                                    mcpmk.idcpmk,
                                    mcpmk.cpmk,
                                    if(rplcpmk.idcpmk is NULL,0,1) AS status_rpl
                                    FROM
                                        matakuliah
                                    LEFT JOIN tb_konsentrasi ON matakuliah.kode_konsentrasi = tb_konsentrasi.kode_konsentrasi
                                    left join 
                                    prodi on matakuliah.kode_prodi = prodi.kode_prodi
                                    left join 
                                    (select * from
                                    master_cpmk )mcpmk
                                    on matakuliah.kode_matakuliah = mcpmk.kode_matakuliah
                                    LEFT JOIN
                                    (select * from mk_cpmk)rplcpmk
                                    on matakuliah.kode_matakuliah = rplcpmk.kode_matakuliah and rplcpmk.ta_akademik='" . $ta_akademik . "'
                                    WHERE
                                    (jenis_matakuliah = '1' or
                                         jenis_matakuliah = '2') and mcpmk.idcpmk is not null
                                    group by matakuliah.kode_matakuliah")->getResult();
        return $result;
    }
    public function checkduplikat($kode_matakuliah, $kode_prodi)
    {
        $db      = \Config\Database::connect();
        $result = $db->query("select kode_matakuliah from matakuliah where kode_matakuliah='$kode_matakuliah' and kode_prodi='$kode_prodi'")->getResult();
        return $result;
    }

    public function getJejang($kode_prodi)
    {
        $db      = \Config\Database::connect();
        $result = $db->query("select id_jenjang from  prodi  where kode_prodi='$kode_prodi'")->getRow();
        return $result->id_jenjang;
    }

    public function editmk($kdmk, $kd_prodi, $nmmk, $kdkons, $sks,  $idkur, $jenis_mk)
    {
        $db = \Config\Database::connect();
        $result = $db->query("update matakuliah set kode_konsentrasi='$kdkons',jenis_matakuliah='$jenis_mk' where kode_prodi='$kd_prodi' and kode_matakuliah='$kdmk'");
        return $result;
    }
    public function hapusmk($kdmk, $kd_prodi)
    {
        $db = \Config\Database::connect();
        $result = $db->query("delete from matakuliah where kode_prodi='$kd_prodi' and kode_matakuliah='$kdmk'");
        return $result;
    }
    public function hapuscpmk($kdmk, $kd_prodi)
    {
        $db = \Config\Database::connect();
        $result = $db->query("delete from master_cpmk where kode_prodi='$kd_prodi' and kode_matakuliah='$kdmk'");
        return $result;
    }


    public function cekcpmk($kode_matakuliah, $kode_prodi)
    {
        $db      = \Config\Database::connect();
        $result = $db->query("select kode_matakuliah from  master_cpmk  where kode_prodi='$kode_prodi' and kode_matakuliah='$kode_matakuliah'")->getRow();
        return $result;
    }
}