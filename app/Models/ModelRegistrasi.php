<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelRegistrasi extends Model
{
    protected $table      = 'bio_peserta';
    protected $primaryKey = 'no_peserta';

    protected $returnType     = 'array';


    protected $allowedFields = ['ta_akademik', 'no_peserta', 'nama', 'alamat', 'kode_konsentrasi', 'kotkab', 'propinsi', 'instansi_asal', 'nohape', 'email', 'kode_prodi', 'validasi_keu', 'ktkunci', 'nik', 't_lahir', 'ttl', 'ibu_kandung', 'jenis_rpl'];

    protected $validationRules = [
        'ta_akademik'     => 'required',
        'no_peserta'     => 'required',
        'nama'     => 'required',
        'alamat'     => 'required',
        'kotkab'     => 'required',
        'propinsi'     => 'required',
        'instansi_asal'     => 'required',
        'nohape'     => 'required',
        'email'        => 'required|valid_email|is_unique[bio_peserta.email]|is_unique[tb_pengguna.email]',
        'kode_prodi'        => 'required',
        'validasi_keu'        => 'required',
        'ktkunci'        => 'required',
        'nik' => 'required',
        't_lahir' => 'required',
        'ttl' => 'required',
        'ibu_kandung' => 'required',
        'jenis_rpl' => 'required',
    ];
    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Sorry. Email sudah digunakan. Silahkan gunakan email yang lain.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getvalid($ta_akademik)
    {
        $db = \Config\Database::connect();
        $result = $db->query("SELECT
                                tb_valid_keu.no_peserta,
                                bio_peserta.ta_akademik,
                                bio_peserta.no_peserta,
                                bio_peserta.nama,
                                prodi.nama_prodi,
                                bio_peserta.alamat,
                                bio_peserta.kotkab,
                                bio_peserta.propinsi,
                                bio_peserta.instansi_asal,
                                bio_peserta.nohape,
                                bio_peserta.email,
                                bio_peserta.kode_prodi,
                                bio_peserta.validasi_keu,
                                bio_peserta.ktkunci,
                                tb_valid_keu.valid
                                FROM
                                bio_peserta
                                LEFT JOIN tb_valid_keu ON bio_peserta.no_peserta = tb_valid_keu.no_peserta
                                LEFT JOIN prodi on bio_peserta.kode_prodi=prodi.kode_prodi
                                where 
                                tb_valid_keu.no_peserta is not null and bio_peserta.ta_akademik='$ta_akademik'")->getResult();
        return $result;
    }
    public function getnonvalid($ta_akademik)
    {
        $db = \Config\Database::connect();
        $result = $db->query("SELECT
                                tb_valid_keu.no_peserta,
                                bio_peserta.ta_akademik,
                                bio_peserta.no_peserta,
                                prodi.nama_prodi,
                                bio_peserta.nama,
                                bio_peserta.alamat,
                                bio_peserta.kotkab,
                                bio_peserta.propinsi,
                                bio_peserta.instansi_asal,
                                bio_peserta.nohape,
                                bio_peserta.email,
                                bio_peserta.kode_prodi,
                                bio_peserta.validasi_keu,
                                bio_peserta.ktkunci
                                FROM
                                bio_peserta
                                LEFT JOIN tb_valid_keu ON bio_peserta.no_peserta = tb_valid_keu.no_peserta
                                LEFT JOIN prodi on bio_peserta.kode_prodi=prodi.kode_prodi
                                where 
                                tb_valid_keu.no_peserta is null and bio_peserta.ta_akademik='$ta_akademik'")->getResult();
        return $result;
    }
    public function getDataPerFakultas($ta_akademik)
    {
        $db = \Config\Database::connect();
        $result = $db->query("SELECT
                                mfak.kode_fakultas,
                                mfak.nama_fakultas,
                                fakdaftar.JumlahDaftar,
                                lulus_rpl.JumlahLulus
                                FROM
                                    (
                                        SELECT
                                            fakultas.kode_fakultas,
                                            fakultas.nama_fakultas
                                        FROM
                                            bio_peserta
                                        LEFT JOIN prodi ON (
                                            bio_peserta.kode_prodi = prodi.kode_prodi
                                        )
                                        LEFT JOIN fakultas ON (
                                            fakultas.kode_fakultas = prodi.kode_fakultas
                                        )
                                        WHERE
                                            bio_peserta.ta_akademik = '$ta_akademik'
                                        GROUP BY
                                            fakultas.nama_fakultas
                                        ORDER BY
                                            fakultas.kode_fakultas
                                    ) mfak
                                LEFT JOIN (
                                    SELECT
                                        fakultas.kode_fakultas,
                                        COUNT(bio_peserta.no_peserta) AS JumlahDaftar
                                    FROM
                                        bio_peserta
                                    LEFT JOIN prodi ON (
                                        bio_peserta.kode_prodi = prodi.kode_prodi
                                    )
                                    LEFT JOIN fakultas ON (
                                        fakultas.kode_fakultas = prodi.kode_fakultas
                                    )
                                    WHERE
                                        bio_peserta.ta_akademik = '$ta_akademik'
                                    GROUP BY
                                        fakultas.kode_fakultas
                                ) fakdaftar ON (
                                    mfak.kode_fakultas = fakdaftar.kode_fakultas
                                )
                                LEFT JOIN (
                                    SELECT
                                        fakultas.kode_fakultas,
                                        COUNT(valid_dekan.no_peserta) AS JumlahLulus
                                    FROM
                                        (
                                            SELECT
                                                mk_klaim_dekan.kode_prodi,
                                                LEFT (mk_klaim_dekan.idklaim, 10) AS no_peserta
                                            FROM
                                                mk_klaim_dekan
                                            WHERE
                                                LEFT (mk_klaim_dekan.idklaim, 5) = '$ta_akademik'
                                            GROUP BY
                                                LEFT (mk_klaim_dekan.idklaim, 15)
                                        ) valid_dekan
                                    LEFT JOIN prodi ON (
                                        valid_dekan.kode_prodi = prodi.kode_prodi
                                    )
                                    LEFT JOIN fakultas ON (
                                        fakultas.kode_fakultas = prodi.kode_fakultas
                                    )
                                    GROUP BY
                                        fakultas.kode_fakultas
                                ) lulus_rpl ON (
                                    lulus_rpl.kode_fakultas = mfak.kode_fakultas
                                )")->getResult();
        return $result;
    }
    public function getDataPerProdi($ta_akademik)
    {
        $db = \Config\Database::connect();
        $result = $db->query("SELECT
                                    mprodi.kode_prodi,
                                    mprodi.nama_prodi,
                                    mprodi.nama_fakultas,
                                    prodi_daftar.JumlahDaftar,
                                    lulus_rpl.JumlahLulus
                                FROM
                                    (
                                        SELECT
                                            prodi.kode_prodi,
                                            prodi.nama_prodi,
                                            fakultas.nama_fakultas
                                        FROM
                                            bio_peserta
                                        LEFT JOIN prodi ON (
                                            bio_peserta.kode_prodi = prodi.kode_prodi
                                        )
                                        LEFT JOIN fakultas ON (
                                            fakultas.kode_fakultas = prodi.kode_fakultas
                                        )
                                        WHERE
                                            bio_peserta.ta_akademik = '$ta_akademik'
                                        GROUP BY
                                            prodi.kode_prodi
                                        ORDER BY
                                            fakultas.kode_fakultas,
                                            prodi.kode_prodi
                                    ) mprodi
                                LEFT JOIN (
                                    SELECT
                                        bio_peserta.kode_prodi,
                                        COUNT(bio_peserta.no_peserta) AS JumlahDaftar
                                    FROM
                                        bio_peserta
                                    LEFT JOIN prodi ON (
                                        bio_peserta.kode_prodi = prodi.kode_prodi
                                    )
                                    WHERE
                                        bio_peserta.ta_akademik = '$ta_akademik'
                                    GROUP BY
                                        prodi.kode_prodi
                                ) prodi_daftar ON (
                                    mprodi.kode_prodi = prodi_daftar.kode_prodi
                                )
                                LEFT JOIN (
                                    SELECT
                                        prodi.kode_prodi,
                                        COUNT(valid_dekan.no_peserta) AS JumlahLulus
                                    FROM
                                        (
                                            SELECT
                                                mk_klaim_dekan.kode_prodi,
                                                LEFT (mk_klaim_dekan.idklaim, 10) AS no_peserta
                                            FROM
                                                mk_klaim_dekan
                                            WHERE
                                                LEFT (mk_klaim_dekan.idklaim, 5) = '$ta_akademik'
                                            GROUP BY
                                                LEFT (mk_klaim_dekan.idklaim, 15)
                                        ) valid_dekan
                                    LEFT JOIN prodi ON (
                                        valid_dekan.kode_prodi = prodi.kode_prodi
                                    )
                                    GROUP BY
                                        prodi.kode_prodi
                                ) lulus_rpl ON (
                                    lulus_rpl.kode_prodi = mprodi.kode_prodi
                                )")->getResult();
        return $result;
    }
}
