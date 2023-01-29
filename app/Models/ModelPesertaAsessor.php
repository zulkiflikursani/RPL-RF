<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPesertaAsessor extends Model
{
    protected $table      = 'tb_peserta_asessor';
    protected $primaryKey = 'no_peserta';

    protected $returnType     = 'array';
    protected $allowedFields = [
        "ta_akademik",
        "no_peserta",
        "no_asessor",
        "tglbuat",
        "tglubah",
        "id_pengguna",

    ];
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tglbuat';
    protected $updatedField  = 'tglubah';
    protected $validationRules = [
        "ta_akademik" => 'required',
        "no_peserta" => 'required|is_unique[tb_peserta_asessor.no_peserta]',
        "no_asessor" => 'required',
        "id_pengguna" => 'required',
    ];
    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Asessor Peserta sudah ditentukan sebelumnya',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getDataPesertaByAsessor($no_asessor, $ta_akademik)
    {
        $db = \Config\Database::connect();
        $dataMahasiswa = $db->query("SELECT
                            tb_peserta_asessor.ta_akademik,
                            tb_peserta_asessor.no_peserta,
                            bio_peserta.nama,
                            bio_peserta.kode_prodi,
                            bio_peserta.jenis_rpl,
                            tb_peserta_asessor.no_asessor,
                            tb_pengguna.nmpengguna as nmasessor,
                            tb_pengguna.email as email_asessor
                            FROM
                            tb_peserta_asessor
                            LEFT JOIN bio_peserta ON tb_peserta_asessor.no_peserta = bio_peserta.no_peserta
                            LEFT JOIN tb_pengguna ON tb_peserta_asessor.no_asessor = tb_pengguna.idpengguna
                            WHERE 
                            bio_peserta.ta_akademik='$ta_akademik' and tb_peserta_asessor.no_asessor='$no_asessor'")->getResult();
        return $dataMahasiswa;
    }

    public function getdataPesertaBelumPunyaAsessor($ta_akademik)
    {
        $db = \Config\Database::connect();
        $dataMahasiswa = $db->query("SELECT
                                bio_peserta.no_peserta,
                                bio_peserta.nama,
                                tb_peserta_asessor.no_asessor,
                                bio_peserta.jenis_rpl,
                                bio_peserta.kode_prodi
                                FROM
                                bio_peserta
                                LEFT JOIN tb_peserta_asessor ON bio_peserta.no_peserta = tb_peserta_asessor.no_peserta
                                where
                                bio_peserta.ta_akademik='$ta_akademik' and tb_peserta_asessor.no_asessor is null")->getResult();
        return $dataMahasiswa;
    }

    public function getDataPesertaAsessroBelumValid($id_asessor, $ta_akademik)
    {
        $db = \Config\Database::connect();
        $dataMahasiswa = $db->query("SELECT
                                bio_peserta.ta_akademik,
                                bio_peserta.no_peserta,
                                bio_peserta.nama,
                                bio_peserta.alamat,
                                bio_peserta.kotkab,
                                bio_peserta.propinsi,
                                bio_peserta.instansi_asal,
                                bio_peserta.didikakhir,
                                bio_peserta.nohape,
                                bio_peserta.email,
                                bio_peserta.jenis_rpl,
                                bio_peserta.kode_prodi,
                                mk_klaim_asessor.idklaim,
                                mk_klaim_asessor.ta_akademik,
                                mk_klaim_asessor.idpengguna,
                                mk_klaim_asessor.kode_matakuliah,
                                mk_klaim_asessor.nilai,
                                mk_klaim_asessor.tanggapan,
                                mk_klaim_asessor.ket_tanggapan,
                                mk_klaim_asessor.no_peserta,
                                tb_peserta_asessor.no_peserta,
                                tb_peserta_asessor.no_asessor
                                FROM
                                bio_peserta
                                LEFT JOIN mk_klaim_asessor ON bio_peserta.no_peserta = mk_klaim_asessor.no_peserta
                                LEFT JOIN tb_peserta_asessor ON bio_peserta.no_peserta = tb_peserta_asessor.no_peserta
                                LEFT JOIN mk_klaim_header on bio_peserta.no_peserta= mk_klaim_header.no_peserta
                                WHERE
                                bio_peserta.ta_akademik='$ta_akademik' and tb_peserta_asessor.no_asessor='$id_asessor' and  mk_klaim_header.idklaim is not null and mk_klaim_asessor.idklaim is null
                                group by bio_peserta.no_peserta
                                ")->getResult();
        return $dataMahasiswa;
    }

    public function getDataPesertaAsessorSudahValid($id_asessor, $ta_akademik)
    {
        $db = \Config\Database::connect();
        $dataMahasiswa = $db->query("SELECT
                                bio_peserta.ta_akademik,
                                bio_peserta.no_peserta,
                                bio_peserta.nama,
                                bio_peserta.alamat,
                                bio_peserta.kotkab,
                                bio_peserta.propinsi,
                                bio_peserta.instansi_asal,
                                bio_peserta.didikakhir,
                                bio_peserta.nohape,
                                bio_peserta.email,
                                bio_peserta.jenis_rpl,
                                bio_peserta.kode_prodi,
                                mk_klaim_asessor.idklaim,
                                mk_klaim_asessor.ta_akademik,
                                mk_klaim_asessor.idpengguna,
                                mk_klaim_asessor.kode_matakuliah,
                                mk_klaim_asessor.nilai,
                                mk_klaim_asessor.tanggapan,
                                mk_klaim_asessor.ket_tanggapan,
                                mk_klaim_asessor.no_peserta,
                                tb_peserta_asessor.no_peserta,
                                tb_peserta_asessor.no_asessor
                                FROM
                                bio_peserta
                                LEFT JOIN mk_klaim_asessor ON bio_peserta.no_peserta = mk_klaim_asessor.no_peserta
                                LEFT JOIN tb_peserta_asessor ON bio_peserta.no_peserta = tb_peserta_asessor.no_peserta
                                LEFT JOIN mk_klaim_prodi ON mk_klaim_asessor.idklaim = mk_klaim_prodi.idklaim

                                WHERE
                                bio_peserta.ta_akademik='$ta_akademik' and tb_peserta_asessor.no_asessor=$id_asessor and mk_klaim_prodi.idklaim is null and mk_klaim_asessor.idklaim is not null
                                group by bio_peserta.no_peserta
                                ")->getResult();
        return $dataMahasiswa;
    }
    public function getDataPesertaAsessorSudahValidProdi($id_asessor, $ta_akademik)
    {
        $db = \Config\Database::connect();
        $dataMahasiswa = $db->query("SELECT
                                bio_peserta.ta_akademik,
                                bio_peserta.no_peserta,
                                bio_peserta.nama,
                                bio_peserta.alamat,
                                bio_peserta.kotkab,
                                bio_peserta.propinsi,
                                bio_peserta.instansi_asal,
                                bio_peserta.didikakhir,
                                bio_peserta.nohape,
                                bio_peserta.email,
                                bio_peserta.jenis_rpl,
                                bio_peserta.kode_prodi,
                                mk_klaim_prodi.idklaim,
                                mk_klaim_prodi.ta_akademik,
                                mk_klaim_prodi.idasessor
                                FROM
                                bio_peserta
                                LEFT JOIN mk_klaim_asessor ON bio_peserta.no_peserta = mk_klaim_asessor.no_peserta
                                LEFT JOIN mk_klaim_prodi ON mk_klaim_asessor.idklaim = mk_klaim_prodi.idklaim
                                LEFT JOIN tb_peserta_asessor ON bio_peserta.no_peserta = tb_peserta_asessor.no_peserta
                                WHERE
                                bio_peserta.ta_akademik='$ta_akademik' and tb_peserta_asessor.no_asessor='$id_asessor' and mk_klaim_prodi.idklaim is not null
                                group by bio_peserta.no_peserta")->getResult();
        return $dataMahasiswa;
    }
}