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
        "no_peserta" => 'required|trim|is_unique[tb_peserta_asessor.no_peserta]',
        "no_asessor" => 'required',
        "id_pengguna" => 'required',
    ];
    protected $validationMessages = [
        'no_peserta' => [
            'is_unique' => 'Asessor Peserta sudah ditentukan sebelumnya',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getnamaasessor($noregis)
    {
        $db = \Config\Database::connect();
        $result = $db->query("select tb_pengguna.nmpengguna from tb_peserta_asessor left join tb_pengguna on tb_peserta_asessor.no_asessor = tb_pengguna.idpengguna 
        where tb_peserta_asessor.no_peserta= '$noregis'")->getRow();
        return $result->nmpengguna;
    }
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
                            tb_pengguna.email as email_asessor,
                            prodi.nama_prodi
                            FROM
                            tb_peserta_asessor
                            LEFT JOIN bio_peserta ON tb_peserta_asessor.no_peserta = bio_peserta.no_peserta
                            LEFT JOIN tb_pengguna ON tb_peserta_asessor.no_asessor = tb_pengguna.idpengguna
                            left join prodi on
                                bio_peserta.kode_prodi= prodi.kode_prodi
                            WHERE 
                            bio_peserta.ta_akademik='$ta_akademik' and tb_peserta_asessor.no_asessor='$no_asessor'")->getResult();
        return $dataMahasiswa;
    }

    public function getdataPesertaBelumPunyaAsessor($ta_akademik)
    {
        $db = \Config\Database::connect();
        $dataMahasiswa = $db->query("(SELECT
        bio_peserta.no_peserta,
        bio_peserta.nama,
        tb_peserta_asessor.no_asessor,
        bio_peserta.jenis_rpl,
        bio_peserta.kode_prodi,
        prodi.nama_prodi
        FROM
        bio_peserta
        left join
        mk_klaim_detail
        on bio_peserta.no_peserta = mid(mk_klaim_detail.idklaim,6,10) and mk_klaim_detail.statusklaim =2
        LEFT JOIN tb_peserta_asessor ON bio_peserta.no_peserta = tb_peserta_asessor.no_peserta
        left join prodi on
        bio_peserta.kode_prodi= prodi.kode_prodi
        where
        mk_klaim_detail.idklaim is not null and
        bio_peserta.ta_akademik='$ta_akademik' and tb_peserta_asessor.no_asessor is null 
        group by bio_peserta.no_peserta)
        union
        (select bio_peserta.no_peserta,
        bio_peserta.nama,
        tb_peserta_asessor.no_asessor,
        bio_peserta.jenis_rpl,
        bio_peserta.kode_prodi,prodi.nama_prodi from bio_peserta
        left join tb_peserta_asessor on bio_peserta.no_peserta=tb_peserta_asessor.no_peserta
        left join dok_a1 on bio_peserta.no_peserta=dok_a1.no_registrasi and dok_a1.status=0
        left join prodi on
        bio_peserta.kode_prodi= prodi.kode_prodi
        where bio_peserta.jenis_rpl='1' and dok_a1.no_registrasi is not null  and bio_peserta.ta_akademik='$ta_akademik' and tb_peserta_asessor.no_asessor is null)")->getResult();
        return $dataMahasiswa;
    }
    public function getdataPesertaBelumPunyaAsessorByProdi($kode_prodi, $ta_akademik)
    {
        $db = \Config\Database::connect();
        $dataMahasiswa = $db->query(
            "(SELECT
                                bio_peserta.no_peserta,
                                bio_peserta.nama,
                                tb_peserta_asessor.no_asessor,
                                bio_peserta.jenis_rpl,
                                bio_peserta.kode_prodi,
                                prodi.nama_prodi
                                FROM
                                bio_peserta
                                left join
                                mk_klaim_detail
                                on bio_peserta.no_peserta = mid(mk_klaim_detail.idklaim,6,10) and mk_klaim_detail.statusklaim =2
                                LEFT JOIN tb_peserta_asessor ON bio_peserta.no_peserta = tb_peserta_asessor.no_peserta
                                left join prodi on
                                bio_peserta.kode_prodi= prodi.kode_prodi
                                where
                                mk_klaim_detail.idklaim is not null and
                                bio_peserta.ta_akademik='$ta_akademik' and tb_peserta_asessor.no_asessor is null and bio_peserta.kode_prodi='$kode_prodi'
                                group by bio_peserta.no_peserta)
                                union
                                (select bio_peserta.no_peserta,
                                bio_peserta.nama,
                                tb_peserta_asessor.no_asessor,
                                bio_peserta.jenis_rpl,
                                bio_peserta.kode_prodi,prodi.kode_prodi from bio_peserta
                                left join tb_peserta_asessor on bio_peserta.no_peserta=tb_peserta_asessor.no_peserta
                                left join dok_a1 on bio_peserta.no_peserta=dok_a1.no_registrasi and dok_a1.status=0
                                left join prodi on
                                bio_peserta.kode_prodi= prodi.kode_prodi
                                where bio_peserta.jenis_rpl='1' and dok_a1.no_registrasi is not null  and bio_peserta.ta_akademik='$ta_akademik' and tb_peserta_asessor.no_asessor is null and bio_peserta.kode_prodi='$kode_prodi')"
        )->getResult();
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
                                        tb_peserta_asessor.no_asessor,
                                        mk_klaim_detail.statusklaim,
                                        mk_klaim_detail.tglubah,
                                        prodi.nama_prodi
                                    FROM
                                        bio_peserta
                                    LEFT JOIN mk_klaim_asessor ON bio_peserta.no_peserta = mk_klaim_asessor.no_peserta
                                    LEFT JOIN tb_peserta_asessor ON bio_peserta.no_peserta = tb_peserta_asessor.no_peserta
                                    LEFT JOIN mk_klaim_detail ON mid(mk_klaim_detail.idklaim,6,10)= bio_peserta.no_peserta
                                    LEFT JOIN prodi ON bio_peserta.kode_prodi = prodi.kode_prodi
                                    LEFT JOIN (
                                        SELECT
                                            no_peserta,
                                            tanggapan
                                        FROM
                                            mk_klaim_asessor
                                        WHERE
                                            tanggapan != 0
                                    ) AS st ON st.no_peserta = bio_peserta.no_peserta
                                    WHERE
                                        bio_peserta.ta_akademik = '$ta_akademik'
                                    AND tb_peserta_asessor.no_asessor = '$id_asessor'
                                    AND mk_klaim_detail.idklaim IS NOT NULL
                                    AND (
                                        mk_klaim_asessor.idklaim IS NULL
                                        OR st.no_peserta IS NOT NULL
                                    )
                                    AND mk_klaim_detail.statusklaim IS NOT NULL
                                    AND mk_klaim_detail.statusklaim != 1
                                    GROUP BY
                                        bio_peserta.no_peserta
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
                                       
                                        bio_peserta.nohape,
                                        bio_peserta.email,
                                        bio_peserta.jenis_rpl,
                                        bio_peserta.kode_prodi,
                                        mk_klaim_asessorx.idklaim,
                                        mk_klaim_asessorx.ta_akademik,
                                        mk_klaim_asessorx.idpengguna,
                                        mk_klaim_asessorx.kode_matakuliah,
                                        mk_klaim_asessorx.nilai,
                                        mk_klaim_asessorx.tanggapan,
                                        mk_klaim_asessorx.ket_tanggapan,
                                        mk_klaim_asessorx.no_peserta,
                                        tb_peserta_asessor.no_peserta,
                                        tb_peserta_asessor.no_asessor,
                                        mk_klaim_asessorx.tglubah AS tglvalid,
                                        mk_klaim_header.tglubah AS tglpengajuan,
                                        st.tanggapan,
                                        prodi.nama_prodi
                                    FROM
                                        bio_peserta
                                    LEFT JOIN (
                                        SELECT
                                            mk_klaim_asessor.ta_akademik,
                                            mk_klaim_asessor.idpengguna,
                                            mk_klaim_asessor.idklaim,
                                            mk_klaim_asessor.kode_matakuliah,
                                            mk_klaim_asessor.nilai,
                                            mk_klaim_asessor.tanggapan,
                                            mk_klaim_asessor.ket_tanggapan,
                                            mk_klaim_asessor.no_peserta,
                                            mk_klaim_asessor.tglubah
                                        FROM
                                            mk_klaim_asessor
                                        WHERE
                                            mk_klaim_asessor.idpengguna = '$id_asessor'
                                    ) mk_klaim_asessorx ON bio_peserta.no_peserta = mk_klaim_asessorx.no_peserta
                                    LEFT JOIN mk_klaim_header ON bio_peserta.no_peserta = mk_klaim_header.no_peserta
                                    LEFT JOIN tb_peserta_asessor ON bio_peserta.no_peserta = tb_peserta_asessor.no_peserta
                                    LEFT JOIN (
                                        SELECT
                                            mk_klaim_prodi.idklaim
                                        FROM
                                            mk_klaim_prodi
                                        WHERE
                                            mk_klaim_prodi.idasessor = '$id_asessor'
                                    ) mk_klaim_prodix ON mk_klaim_asessorx.idklaim = mk_klaim_prodix.idklaim
                                    LEFT JOIN prodi ON bio_peserta.kode_prodi = prodi.kode_prodi
                                    LEFT JOIN (
                                        SELECT
                                            no_peserta,
                                            tanggapan
                                        FROM
                                            mk_klaim_asessor
                                        WHERE
                                            tanggapan != 0
                                        AND mk_klaim_asessor.idpengguna = '$id_asessor'
                                    ) AS st ON (
                                        st.no_peserta = bio_peserta.no_peserta
                                    )
                                    WHERE
                                        bio_peserta.ta_akademik = '$ta_akademik'
                                    AND tb_peserta_asessor.no_asessor = '$id_asessor'
                                    AND mk_klaim_prodix.idklaim IS NULL
                                    AND mk_klaim_asessorx.idklaim IS NOT NULL
                                    AND st.tanggapan IS NULL
                                    GROUP BY
                                        bio_peserta.no_peserta
                                ")->getResult();
        return $dataMahasiswa;
    }
    public function getDataPesertaAsessorSudahValidProdiByAsessor($id, $kode_prodi, $ta_akademik)
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
                              
                                bio_peserta.nohape,
                                bio_peserta.email,
                                bio_peserta.jenis_rpl,
                                bio_peserta.kode_prodi,
                                mk_klaim_prodi.idklaim,
                                mk_klaim_prodi.ta_akademik,
                                mk_klaim_prodi.idasessor,
                                prodi.nama_prodi
                                FROM
                                bio_peserta
                                LEFT JOIN mk_klaim_asessor ON bio_peserta.no_peserta = mk_klaim_asessor.no_peserta
                                LEFT JOIN mk_klaim_prodi ON mk_klaim_asessor.idklaim = mk_klaim_prodi.idklaim
                                LEFT JOIN tb_peserta_asessor ON bio_peserta.no_peserta = tb_peserta_asessor.no_peserta
                                left join prodi on
                                bio_peserta.kode_prodi= prodi.kode_prodi
                                WHERE
                                bio_peserta.ta_akademik='$ta_akademik' and bio_peserta.kode_prodi='$kode_prodi' and tb_peserta_asessor.no_asessor='$id' and mk_klaim_prodi.idklaim is not null
                                group by bio_peserta.no_peserta")->getResult();
        return $dataMahasiswa;
    }
    public function getDataPesertaStatusKlaim($id, $kode_prodi, $ta_akademik)
    {
        $db = \Config\Database::connect();
        $dataMahasiswa = $db->query("SELECT
                                        mk_klaim_headerx.no_peserta,
                                        bio_peserta.nama,
                                        IFNULL(
                                            tb_pengguna.nmpengguna,
                                            'Belum Ada Asessor'
                                            ) AS asessor,
                                            mk_klaim_detailx.statusklaim
                                        FROM
                                            (
                                                SELECT
                                                    mk_klaim_header.ta_akademik,
                                                    mk_klaim_header.kode_prodi,
                                                    mk_klaim_header.no_peserta
                                                FROM
                                                    mk_klaim_header
                                                WHERE
                                                    mk_klaim_header.ta_akademik = '$ta_akademik'
                                                AND mk_klaim_header.kode_prodi = '$kode_prodi'
                                                GROUP BY
                                                    mk_klaim_header.no_peserta
                                            ) mk_klaim_headerx
                                        LEFT JOIN bio_peserta ON (
                                            mk_klaim_headerx.no_peserta = bio_peserta.no_peserta
                                        )
                                        LEFT JOIN (
                                            SELECT
                                                mk_klaim_asessor.idklaim,
                                                mk_klaim_asessor.ta_akademik,
                                                mk_klaim_asessor.kode_prodi,
                                                mk_klaim_asessor.no_peserta,
                                                mk_klaim_asessor.idpengguna
                                            FROM
                                                mk_klaim_asessor
                                            WHERE
                                                mk_klaim_asessor.ta_akademik = '$ta_akademik'
                                            AND mk_klaim_asessor.kode_prodi = '$kode_prodi'
                                            GROUP BY
                                                mk_klaim_asessor.no_peserta
                                        ) mk_klaim_asessorx ON (
                                            mk_klaim_headerx.no_peserta = mk_klaim_asessorx.no_peserta
                                        )
                                        LEFT JOIN (
                                            SELECT
                                                mk_klaim_detail.statusklaim,
                                                mid(
                                                    mk_klaim_detail.idklaim,
                                                    6,
                                                    10
                                                ) AS no_peserta
                                            FROM
                                                mk_klaim_detail
                                            GROUP BY
                                                mid(
                                                    mk_klaim_detail.idklaim,
                                                    6,
                                                    10
                                                )
                                        ) mk_klaim_detailx ON mk_klaim_detailx.no_peserta = mk_klaim_headerx.no_peserta
                                        LEFT JOIN tb_peserta_asessor ON (
                                            mk_klaim_headerx.no_peserta = tb_peserta_asessor.no_peserta
                                        )
                                        LEFT JOIN tb_pengguna ON (
                                            tb_pengguna.idpengguna = tb_peserta_asessor.no_asessor
                                        )
                                        WHERE
                                            mk_klaim_asessorx.no_peserta IS NULL
                                        ORDER BY
                                            mk_klaim_headerx.no_peserta")->getResult();
        return $dataMahasiswa;
    }
    public function getDataPesertaBelumValidProdi($id, $kode_prodi, $ta_akademik)
    {
        $db = \Config\Database::connect();
        $dataMahasiswa = $db->query("SELECT bio_pesertax.ta_akademik,
                                        bio_pesertax.no_peserta,
                                        bio_pesertax.nama,
                                        bio_pesertax.alamat,
                                        bio_pesertax.kotkab,
                                        bio_pesertax.propinsi,
                                        bio_pesertax.instansi_asal,
                                      
                                        bio_pesertax.nohape,
                                        bio_pesertax.email,
                                        bio_pesertax.jenis_rpl,
                                        bio_pesertax.kode_prodi,
                                        status_klaim_valid.idklaim AS klaim_valid,
                                        status_klaim_nonvalid.idklaim AS klaim_non_valid,
                                        mk_klaim_prodix.idklaim,
                                        prodi.nama_prodi
                                    FROM
                                        (
                                            SELECT
                                                bio_peserta.ta_akademik,
                                                bio_peserta.no_peserta,
                                                bio_peserta.nama,
                                                bio_peserta.alamat,
                                                bio_peserta.kotkab,
                                                bio_peserta.propinsi,
                                                bio_peserta.instansi_asal,
                                              
                                                bio_peserta.nohape,
                                                bio_peserta.email,
                                                bio_peserta.jenis_rpl,
                                                bio_peserta.kode_prodi
                                            FROM
                                                bio_peserta
                                            WHERE
                                                bio_peserta.kode_prodi = '$kode_prodi'
                                            AND bio_peserta.ta_akademik = '$ta_akademik'
                                        ) bio_pesertax
                                    LEFT JOIN (
                                        SELECT
                                            mk_klaim_asessor.no_peserta,
                                            mk_klaim_asessor.idklaim
                                        FROM
                                            mk_klaim_asessor
                                        WHERE
                                            (
                                                mk_klaim_asessor.kode_prodi = '$kode_prodi'
                                            )
                                        AND (
                                            mk_klaim_asessor.ta_akademik = '$ta_akademik'
                                        )
                                        AND (
                                            mk_klaim_asessor.tanggapan = 0
                                        )
                                    ) AS status_klaim_valid ON bio_pesertax.no_peserta = status_klaim_valid.no_peserta
                                    LEFT JOIN (
                                        SELECT
                                            mk_klaim_asessor.no_peserta,
                                            mk_klaim_asessor.idklaim
                                        FROM
                                            mk_klaim_asessor
                                        WHERE
                                            mk_klaim_asessor.kode_prodi = '$kode_prodi'
                                        AND mk_klaim_asessor.ta_akademik = '$ta_akademik'
                                        AND mk_klaim_asessor.tanggapan = 1
                                    ) AS status_klaim_nonvalid ON bio_pesertax.no_peserta = status_klaim_nonvalid.no_peserta
                                    LEFT JOIN (
                                        SELECT
                                            mk_klaim_asessor.idklaim,
                                            mk_klaim_asessor.no_peserta
                                        FROM
                                            mk_klaim_asessor
                                        WHERE
                                            mk_klaim_asessor.kode_prodi = '$kode_prodi'
                                        AND mk_klaim_asessor.ta_akademik = '$ta_akademik'
                                    ) mk_klaim_asessorx ON bio_pesertax.no_peserta = mk_klaim_asessorx.no_peserta
                                    LEFT JOIN (
                                        SELECT
                                            mk_klaim_prodi.idklaim
                                        FROM
                                            mk_klaim_prodi
                                        WHERE
                                            mk_klaim_prodi.ta_akademik = '$ta_akademik'
                                        AND mk_klaim_prodi.kode_prodi = '$kode_prodi'
                                    ) mk_klaim_prodix ON mk_klaim_asessorx.idklaim = mk_klaim_prodix.idklaim
                                    LEFT JOIN tb_peserta_asessor ON bio_pesertax.no_peserta = tb_peserta_asessor.no_peserta
                                    LEFT JOIN prodi ON bio_pesertax.kode_prodi = prodi.kode_prodi
                                    WHERE
                                        status_klaim_nonvalid.idklaim IS NULL
                                    AND status_klaim_valid.idklaim IS NOT NULL
                                    AND mk_klaim_prodix.idklaim IS NULL
                                    GROUP BY
                                        bio_pesertax.no_peserta")->getResult();
        return $dataMahasiswa;
    }

    public function getDataPesertaAsessorSudahValidProdi($id, $kode_prodi, $ta_akademik)
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
                              
                                bio_peserta.nohape,
                                bio_peserta.email,
                                bio_peserta.jenis_rpl,
                                bio_peserta.kode_prodi,
                                mk_klaim_prodi.idklaim,
                                mk_klaim_prodi.ta_akademik,
                                mk_klaim_prodi.idasessor,
                                prodi.nama_prodi
                                FROM
                                bio_peserta
                                LEFT JOIN mk_klaim_asessor ON bio_peserta.no_peserta = mk_klaim_asessor.no_peserta
                                LEFT JOIN mk_klaim_prodi ON mk_klaim_asessor.idklaim = mk_klaim_prodi.idklaim
                                left join mk_klaim_dekan on mk_klaim_dekan.idklaim= mk_klaim_asessor.idklaim
                                left join prodi on
                                bio_peserta.kode_prodi= prodi.kode_prodi
                                LEFT JOIN tb_peserta_asessor ON bio_peserta.no_peserta = tb_peserta_asessor.no_peserta
                                WHERE
                                bio_peserta.ta_akademik='$ta_akademik' and bio_peserta.kode_prodi='$kode_prodi' and mk_klaim_prodi.idklaim is not null and mk_klaim_dekan.idklaim is null
                                group by bio_peserta.no_peserta")->getResult();
        return $dataMahasiswa;
    }

    public function getDataPesertaAsessorSudahValidDekanPerprodi($id, $kode_prodi, $ta_akademik)
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
                          
                                bio_peserta.nohape,
                                bio_peserta.email,
                                bio_peserta.jenis_rpl,
                                bio_peserta.kode_prodi,
                                prodi.nama_prodi
                            
                                FROM
                                bio_peserta
                                LEFT JOIN mk_klaim_asessor ON bio_peserta.no_peserta = mk_klaim_asessor.no_peserta
                                LEFT JOIN mk_klaim_dekan ON mk_klaim_asessor.idklaim = mk_klaim_dekan.idklaim
                                LEFT JOIN tb_peserta_asessor ON bio_peserta.no_peserta = tb_peserta_asessor.no_peserta
                                left join prodi on
                                bio_peserta.kode_prodi= prodi.kode_prodi
                                WHERE
                                bio_peserta.ta_akademik='$ta_akademik' 
                                and bio_peserta.kode_prodi='$kode_prodi'
                                and mk_klaim_dekan.idklaim is not null
                                group by bio_peserta.no_peserta")->getResult();
        return $dataMahasiswa;
    }
    public function getDataPesertaAsessorSudahValidProdiDekan($id, $kode_fakultas, $ta_akademik)
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
              
                        bio_peserta.nohape,
                        bio_peserta.email,
                        bio_peserta.jenis_rpl,
                        bio_peserta.kode_prodi,
                        prodi.kode_fakultas,
                        prodi.nama_prodi,
                        mk_klaim_asessor.idklaim as klaim_asessor,
                        mk_klaim_prodi.idklaim as klaim_prdodi,
                        mk_klaim_dekan.idklaim as klaim_dekan
                        FROM
                        bio_peserta
                        LEFT JOIN prodi ON prodi.kode_prodi = bio_peserta.kode_prodi
                        LEFT JOIN fakultas ON fakultas.kode_fakultas = prodi.kode_fakultas
                        LEFT JOIN mk_klaim_asessor ON bio_peserta.no_peserta = mk_klaim_asessor.no_peserta
                        LEFT JOIN mk_klaim_prodi ON mk_klaim_prodi.idklaim = mk_klaim_asessor.idklaim
                        LEFT JOIN mk_klaim_dekan ON mk_klaim_asessor.idklaim = mk_klaim_dekan.idklaim
                        LEFT JOIN tb_peserta_asessor ON bio_peserta.no_peserta = tb_peserta_asessor.no_peserta
                        WHERE
                        bio_peserta.ta_akademik = '$ta_akademik' 
                        AND fakultas.kode_fakultas='$kode_fakultas'
                        AND mk_klaim_dekan.idklaim IS NULL
                        AND mk_klaim_prodi.idklaim IS NOT NULL
                        GROUP BY
                        bio_peserta.no_peserta")->getResult();
        return $dataMahasiswa;
    }

    public function getDataPesertaAsessorSudahValidDekan($id, $kode_fakultas, $ta_akademik)
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
                  
                        bio_peserta.nohape,
                        bio_peserta.email,
                        bio_peserta.jenis_rpl,
                        bio_peserta.kode_prodi,
                        prodi.kode_fakultas,
                        prodi.nama_prodi,
                        mk_klaim_asessor.idklaim as klaim_asessor,
                        mk_klaim_prodi.idklaim as klaim_prdodi,
                        mk_klaim_dekan.idklaim as klaim_dekan
                        FROM
                        bio_peserta
                        LEFT JOIN prodi ON prodi.kode_prodi = bio_peserta.kode_prodi
                        LEFT JOIN fakultas ON fakultas.kode_fakultas = prodi.kode_fakultas
                        LEFT JOIN mk_klaim_asessor ON bio_peserta.no_peserta = mk_klaim_asessor.no_peserta
                        LEFT JOIN mk_klaim_prodi ON mk_klaim_prodi.idklaim = mk_klaim_asessor.idklaim
                        LEFT JOIN mk_klaim_dekan ON mk_klaim_asessor.idklaim = mk_klaim_dekan.idklaim
                        LEFT JOIN tb_peserta_asessor ON bio_peserta.no_peserta = tb_peserta_asessor.no_peserta
                        WHERE
                        bio_peserta.ta_akademik = '$ta_akademik' 
                        AND fakultas.kode_fakultas='$kode_fakultas'
                        AND mk_klaim_dekan.idklaim IS NOT NULL
                        AND mk_klaim_prodi.idklaim IS NOT NULL
                        GROUP BY
                        bio_peserta.no_peserta")->getResult();
        return $dataMahasiswa;
    }
    public function getDataPesertaAsessorSudahValidKeu($id, $kode_fakultas, $ta_akademik)
    {
        $db = \Config\Database::connect();
        $dataMahasiswa = $db->query("SELECT
        bio_peserta.no_peserta,
        bio_peserta.nama,
        ifnull(sum(mk_klaim_header.sks), 0) AS Jumlah_SKS,
        bio_peserta.nohape AS kontak,
        prodi.nama_prodi
    FROM
        bio_peserta
    LEFT JOIN prodi ON (
        bio_peserta.kode_prodi = prodi.kode_prodi
    )
    LEFT JOIN tb_valid_keu ON (
        tb_valid_keu.no_peserta = bio_peserta.no_peserta
    )
    LEFT JOIN mk_klaim_header ON (
        mk_klaim_header.no_peserta = bio_peserta.no_peserta
    )
    LEFT JOIN mk_klaim_asessor ON (
        mk_klaim_asessor.idklaim = mk_klaim_header.idklaim and mk_klaim_asessor.nilai !='E'
    )
    WHERE
        tb_valid_keu.no_peserta IS NOT NULL
    AND mk_klaim_asessor.no_peserta IS NOT NULL
    AND prodi.kode_fakultas = '$kode_fakultas'
    AND bio_peserta.ta_akademik = '$ta_akademik'
    
    GROUP BY
        bio_peserta.no_peserta
    ORDER BY
        bio_peserta.kode_prodi,
        bio_peserta.no_peserta")->getResult();
        return $dataMahasiswa;
    }
}
