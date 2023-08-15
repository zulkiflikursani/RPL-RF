<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKeu extends Model
{
    protected $table      = 'tb_valid_keu';
    protected $primaryKey = 'no_peserta';

    protected $returnType     = 'array';


    protected $allowedFields = [
        "ta_akademik",
        "no_peserta",
        "tglbuat",
        "tglubah",
        "id_pengguna",
        "valid",
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tglbuat';
    protected $updatedField  = 'tglubah';
    protected $validationRules = [
        "ta_akademik" => 'required',
        "no_peserta" => 'required|is_unique[tb_valid_keu.no_peserta]',
        "id_pengguna" => 'required',

    ];
    protected $validationMessages = [
        'idcpmk' => [
            'is_unique' => 'Sorry. Nomor peserta sudah digunakan.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function cekvalidasi($noregis)
    {
        $db = \Config\Database::connect();
        $result = $db->query("select * from tb_valid_keu where no_peserta='$noregis'")->getResult();
        return $result;
    }
    public function setvalid($noregis)
    {
        $db = \Config\Database::connect();
        $result = $db->query("update bio_peserta set validasi_keu=0 where no_peserta='$noregis'");
        return $result;
    }
    public function setunvalid($noregis)
    {
        $db = \Config\Database::connect();
        $result = $db->query("update bio_peserta set validasi_keu=1 where no_peserta='$noregis'");
        return $result;
    }

    public function getvalidbayar($ta_akademik)
    {
        $db = \Config\Database::connect();
        $result = $db->query("SELECT
               bio_peserta.no_peserta,
                tb_valid_keu.valid,
                tb_valid_keu.tglubah,
                bio_peserta.nama,
                bio_peserta.nohape,
                bio_peserta.kode_prodi,
                prodi.nama_prodi
                FROM
                tb_valid_keu
                LEFT JOIN bio_peserta ON tb_valid_keu.no_peserta = bio_peserta.no_peserta
                LEFT JOIN prodi ON bio_peserta.kode_prodi = prodi.kode_prodi
                where 
                tb_valid_keu.valid=1 and bio_peserta.ta_akademik='$ta_akademik'
                order by bio_peserta.kode_prodi,tb_valid_keu.tglubah 
                ")->getResult();
        return $result;
    }

    public function getDataLulus($ta_akademik)
    {
        $db = \Config\Database::connect();
        $result = $db->query("SELECT
                        tb_valid_keu.ta_akademik,
                        bio_peserta.no_peserta,
                        tb_valid_keu.tglubah,
                        mk_klaim_dekan.idklaim,
                        bio_peserta.nama,
                        bio_peserta.nohape,
                        bio_peserta.kode_prodi,
                        prodi.nama_prodi
                        FROM
                        bio_peserta
                        LEFT JOIN tb_valid_keu ON tb_valid_keu.no_peserta = bio_peserta.no_peserta
                        LEFT JOIN mk_klaim_dekan ON tb_valid_keu.no_peserta = mid(mk_klaim_dekan.idklaim,6,10)
                        LEFT JOIN prodi on bio_peserta.kode_prodi=prodi.kode_prodi
                        WHERE
                        mk_klaim_dekan.idklaim is not null and bio_peserta.ta_akademik='$ta_akademik'
                        group by bio_peserta.no_peserta
                order by bio_peserta.no_peserta,bio_peserta.nama,bio_peserta.kode_prodi
                ")->getResult();
        return $result;
    }
    public function getDataLulusBelumBayar($ta_akademik)
    {
        $db = \Config\Database::connect();
        $result = $db->query("SELECT
                        tb_valid_keu.ta_akademik,
                        bio_peserta.no_peserta,
                        tb_valid_keu.tglubah,
                        mk_klaim_dekan.idklaim,
                        bio_peserta.nama,
                        bio_peserta.nohape,
                        bio_peserta.kode_prodi,
                        prodi.nama_prodi
                        FROM
                        bio_peserta
                        LEFT JOIN tb_valid_keu ON tb_valid_keu.no_peserta = bio_peserta.no_peserta
                        LEFT JOIN mk_klaim_dekan ON tb_valid_keu.no_peserta = mid(mk_klaim_dekan.idklaim,6,10)
                        LEFT JOIN prodi on bio_peserta.kode_prodi=prodi.kode_prodi
                        WHERE
                        mk_klaim_dekan.idklaim is not null and bio_peserta.ta_akademik='$ta_akademik' and tb_valid_keu.valid=0
                        group by bio_peserta.no_peserta
                order by bio_peserta.no_peserta,bio_peserta.nama,bio_peserta.kode_prodi
                ")->getResult();
        return $result;
    }
    public function getDataLulusSudahBayar($ta_akademik)
    {
        $db = \Config\Database::connect();
        $result = $db->query("SELECT
                        tb_valid_keu.ta_akademik,
                        bio_peserta.no_peserta,
                        tb_valid_keu.tglubah,
                        mk_klaim_dekan.idklaim,
                        bio_peserta.nama,
                        bio_peserta.nohape,
                        bio_peserta.kode_prodi,
                        prodi.nama_prodi
                        FROM
                        bio_peserta
                        LEFT JOIN tb_valid_keu ON tb_valid_keu.no_peserta = bio_peserta.no_peserta
                        LEFT JOIN mk_klaim_dekan ON tb_valid_keu.no_peserta = mid(mk_klaim_dekan.idklaim,6,10)
                        LEFT JOIN prodi on bio_peserta.kode_prodi=prodi.kode_prodi
                        WHERE
                        mk_klaim_dekan.idklaim is not null and bio_peserta.ta_akademik='$ta_akademik' and tb_valid_keu.valid=1
                        group by bio_peserta.no_peserta
                order by bio_peserta.no_peserta,bio_peserta.nama,bio_peserta.kode_prodi
                ")->getResult();
        return $result;
    }
}