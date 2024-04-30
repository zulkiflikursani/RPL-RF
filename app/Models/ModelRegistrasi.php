<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelRegistrasi extends Model
{
  protected $table      = 'bio_peserta';
  protected $primaryKey = 'no_peserta';

  protected $returnType     = 'array';


  protected $allowedFields = ['ta_akademik', 'no_peserta', 'nama', 'alamat', 'kode_konsentrasi', 'kotkab', 'propinsi', 'instansi_asal', 'nohape', 'email', 'kode_prodi', 'validasi_keu', 'validasi_regis_prodi', 'ktkunci', 'nik', 't_lahir', 'ttl', 'ibu_kandung', 'jenis_rpl', 'dodi'];

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
    'validasi_regis_prodi' => 'required',
    'ktkunci'        => 'required',
    'nik' => 'required',
    't_lahir' => 'required',
    'ttl' => 'required',
    'ibu_kandung' => 'required',
    'jenis_rpl' => 'required',
    'dodi' => 'required'
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
                                tb_valid_keu.no_peserta is null and bio_peserta.ta_akademik='$ta_akademik' and bio_peserta.validasi_regis_prodi=1")->getResult();
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
    // $result = $db->query("SELECT
    //                                 mprodi.kode_prodi,
    //                                 mprodi.nama_prodi,
    //                                 mprodi.nama_fakultas,
    //                                 prodi_daftar.JumlahDaftar,
    //                                 lulus_rpl.JumlahLulus
    //                             FROM
    //                                 (
    //                                     SELECT
    //                                         prodi.kode_prodi,
    //                                         prodi.nama_prodi,
    //                                         fakultas.nama_fakultas
    //                                     FROM
    //                                         bio_peserta
    //                                     LEFT JOIN prodi ON (
    //                                         bio_peserta.kode_prodi = prodi.kode_prodi
    //                                     )
    //                                     LEFT JOIN fakultas ON (
    //                                         fakultas.kode_fakultas = prodi.kode_fakultas
    //                                     )
    //                                     WHERE
    //                                         bio_peserta.ta_akademik = '$ta_akademik'
    //                                     GROUP BY
    //                                         prodi.kode_prodi
    //                                     ORDER BY
    //                                         fakultas.kode_fakultas,
    //                                         prodi.kode_prodi
    //                                 ) mprodi
    //                             LEFT JOIN (
    //                                 SELECT
    //                                     bio_peserta.kode_prodi,
    //                                     COUNT(bio_peserta.no_peserta) AS JumlahDaftar
    //                                 FROM
    //                                     bio_peserta
    //                                 LEFT JOIN prodi ON (
    //                                     bio_peserta.kode_prodi = prodi.kode_prodi
    //                                 )
    //                                 WHERE
    //                                     bio_peserta.ta_akademik = '$ta_akademik'
    //                                 GROUP BY
    //                                     prodi.kode_prodi
    //                             ) prodi_daftar ON (
    //                                 mprodi.kode_prodi = prodi_daftar.kode_prodi
    //                             )
    //                             LEFT JOIN (
    //                                 SELECT
    //                                     prodi.kode_prodi,
    //                                     COUNT(valid_dekan.no_peserta) AS JumlahLulus
    //                                 FROM
    //                                     (
    //                                         SELECT
    //                                             mk_klaim_dekan.kode_prodi,
    //                                             LEFT (mk_klaim_dekan.idklaim, 10) AS no_peserta
    //                                         FROM
    //                                             mk_klaim_dekan
    //                                         WHERE
    //                                             LEFT (mk_klaim_dekan.idklaim, 5) = '$ta_akademik'
    //                                         GROUP BY
    //                                             LEFT (mk_klaim_dekan.idklaim, 15)
    //                                     ) valid_dekan
    //                                 LEFT JOIN prodi ON (
    //                                     valid_dekan.kode_prodi = prodi.kode_prodi
    //                                 )
    //                                 GROUP BY
    //                                     prodi.kode_prodi
    //                             ) lulus_rpl ON (
    //                                 lulus_rpl.kode_prodi = mprodi.kode_prodi
    //                             )")->getResult();
    $result = $db->query("SELECT
    mprodi.kode_prodi,
    mprodi.nama_prodi,
    mprodi.nama_fakultas,
    prodi_daftar.JumlahDaftar,
    lulus_rpl.JumlahLulus,
    valid_keu.JumlahValidKeu
  FROM
  (
      SELECT
        prodi.kode_prodi,
        prodi.nama_prodi,
        fakultas.nama_fakultas
      FROM
        bio_peserta
      LEFT JOIN prodi
       ON ( bio_peserta.kode_prodi = prodi.kode_prodi )
      LEFT JOIN fakultas
       ON ( fakultas.kode_fakultas = prodi.kode_fakultas )
      WHERE bio_peserta.ta_akademik = '$ta_akademik'
      GROUP BY prodi.kode_prodi
      ORDER BY fakultas.kode_fakultas , prodi.kode_prodi
  ) mprodi
  LEFT JOIN
  (
      SELECT
        bio_peserta.kode_prodi,
        COUNT( bio_peserta.no_peserta ) AS JumlahDaftar
      FROM
        bio_peserta
      LEFT JOIN prodi
       ON ( bio_peserta.kode_prodi = prodi.kode_prodi )
      WHERE bio_peserta.ta_akademik = '$ta_akademik'
      GROUP BY prodi.kode_prodi
  ) prodi_daftar
   ON ( mprodi.kode_prodi = prodi_daftar.kode_prodi )
  LEFT JOIN
  (
      SELECT
        prodi.kode_prodi,
        COUNT( valid_dekan.no_peserta ) AS JumlahLulus
      FROM
      (
          SELECT
            mk_klaim_dekan.kode_prodi,
            LEFT( mk_klaim_dekan.idklaim,10 ) AS no_peserta
          FROM
            mk_klaim_dekan
          WHERE LEFT( mk_klaim_dekan.idklaim,5 ) = '$ta_akademik'
          GROUP BY LEFT( mk_klaim_dekan.idklaim,15 )
      ) valid_dekan
      LEFT JOIN prodi
       ON ( valid_dekan.kode_prodi = prodi.kode_prodi )
      GROUP BY prodi.kode_prodi
  ) lulus_rpl
   ON ( lulus_rpl.kode_prodi = mprodi.kode_prodi )
  LEFT JOIN
  (
      SELECT
        prodi.kode_prodi,
        COUNT( valid_keu.no_peserta ) AS JumlahValidKeu
      FROM
      (
          SELECT
            tb_valid_keu.no_peserta,
            bio_peserta.kode_prodi
          FROM
            tb_valid_keu
          LEFT JOIN bio_peserta
           ON bio_peserta.no_peserta = tb_valid_keu.no_peserta
          WHERE bio_peserta.ta_akademik = '$ta_akademik'
          AND tb_valid_keu.valid = 1
      ) valid_keu
      LEFT JOIN prodi
       ON ( valid_keu.kode_prodi = prodi.kode_prodi )
      GROUP BY prodi.kode_prodi
  ) valid_keu
   ON ( valid_keu.kode_prodi = mprodi.kode_prodi )")->getResult();
    return $result;
  }
  public function getDataStatusMahasiswaRPL($ta_akademik, $kode_prodi)
  {
    $db = \Config\Database::connect();
    $result = $db->query("SELECT 
        bio_peserta.no_peserta, 
        bio_peserta.nama, 
        prodi.nama_prodi, 
        bio_peserta.jenis_rpl, 
        tb_konsentrasi.konsentrasi, 
        asessor_mhs.nm_asessor,
        if(status_valid_bayar.no_peserta is not null,'Telah Melakukan Pembayaran RPL',if(status_dekan.no_peserta is not null,'Telah divalidasi dekan',if(status_prodi.no_peserta is not null,'Telah divalidasi prodi',if(status_asessor.no_peserta is not null, if(status_asessor.tanggapan=0,'Sudah divalidasi asessor', if(status_asessor.tanggapan=1,'Sudah diassessment & butuh tindak lanjut dari mahasiswa',if(status_asessor.tanggapan = 2,'Assessment telah ditindaklanjuti mahasiwa & butuh validasi asesor',''))), if(status_asessor_mhs.no_peserta is not null,'Telah melakukan klaim',if(
          bio_peserta.jenis_rpl = 1, 
          if(
            mk_a1.no_registrasi is not null, 'Telah Melakukan Klaim', 
            if(tb_valid_keu.no_peserta is not null,'Belum melakukan Klaim Mandiri','Pembayaran Registrasi belum divalidasi')
          ), 
          if(
            mk_nona1ajukan.no_peserta is not null, 'Telah melakukan pengajuan klaim mandiri', 
            if(mk_nona1simpan.no_peserta IS NOT NULL ,'Telah melakukan klaim mandiri',
            if(tb_valid_keu.no_peserta is not null,'Belum melakukan Klaim Mandiri','Pembayaran Registrasi belum divalidasi'))
          )
        )))))) as status_mahasiswa_rpl
      FROM 
        bio_peserta 
        LEFT JOIN 
        ( select tb_peserta_asessor.*,tb_pengguna.nmpengguna as nm_asessor from tb_peserta_asessor left join tb_pengguna on tb_peserta_asessor.no_asessor = tb_pengguna.idpengguna )asessor_mhs
        On bio_peserta.no_peserta = asessor_mhs.no_peserta
        LEFT JOIN prodi ON bio_peserta.kode_prodi = prodi.kode_prodi 
        LEFT JOIN tb_konsentrasi ON bio_peserta.kode_konsentrasi = tb_konsentrasi.kode_konsentrasi 
        left join (
          (
            SELECT 
              bio_peserta.no_peserta as no_peserta 
            FROM 
              bio_peserta 
              left join mk_klaim_detail on bio_peserta.no_peserta = mid(mk_klaim_detail.idklaim, 6, 10) 
              and mk_klaim_detail.statusklaim = 2 
              LEFT JOIN tb_peserta_asessor ON bio_peserta.no_peserta = tb_peserta_asessor.no_peserta 
              left join prodi on bio_peserta.kode_prodi = prodi.kode_prodi 
            where 
              mk_klaim_detail.idklaim is not null 
              and bio_peserta.ta_akademik = '$ta_akademik' 
              and tb_peserta_asessor.no_asessor is not null 
              and bio_peserta.kode_prodi = '$kode_prodi' 
            group by 
              bio_peserta.no_peserta
          ) 
          union 
            (
              select 
                bio_peserta.no_peserta as no_peserta 
              from 
                bio_peserta 
                left join tb_peserta_asessor on bio_peserta.no_peserta = tb_peserta_asessor.no_peserta 
                left join dok_a1 on bio_peserta.no_peserta = dok_a1.no_registrasi 
                and dok_a1.status = 0 
                left join prodi on bio_peserta.kode_prodi = prodi.kode_prodi 
              where 
                bio_peserta.jenis_rpl = '1' 
                and dok_a1.no_registrasi is not null 
                and bio_peserta.ta_akademik = '$ta_akademik' 
                and tb_peserta_asessor.no_asessor is not null 
                and bio_peserta.kode_prodi = '$kode_prodi'
            )
        ) status_asessor_mhs on bio_peserta.no_peserta = status_asessor_mhs.no_peserta 
        left join (
          select 
            tb_valid_keu.no_peserta 
          from 
            tb_valid_keu 
          where 
            tb_valid_keu.ta_akademik = '$ta_akademik'
        ) tb_valid_keu on bio_peserta.no_peserta = tb_valid_keu.no_peserta 
        left JOIN (
          select 
            mk_klaim_asessor.no_peserta,
            mk_klaim_asessor.tanggapan
          from 
            mk_klaim_asessor 
          where 
            mk_klaim_asessor.ta_akademik = '$ta_akademik' 
            and mk_klaim_asessor.kode_prodi = '$kode_prodi' 
          group by 
            mk_klaim_asessor.no_peserta
        ) status_asessor ON bio_peserta.no_peserta = status_asessor.no_peserta 
        left join (
          select 
            mid(mk_klaim_prodi.idklaim, 6, 10) as no_peserta 
          from 
            mk_klaim_prodi 
          where 
            mk_klaim_prodi.kode_prodi = '$kode_prodi' 
          group by 
            mid(mk_klaim_prodi.idklaim, 6, 10)
        ) status_prodi on bio_peserta.no_peserta = status_prodi.no_peserta 
        left join (
          select 
            mid(mk_klaim_dekan.idklaim, 6, 10) as no_peserta 
          from 
            mk_klaim_dekan 
          where 
            left(mk_klaim_dekan.idklaim, 5)= '$ta_akademik' 
          group by 
            mid(mk_klaim_dekan.idklaim, 6, 10)
        ) status_dekan on bio_peserta.no_peserta = status_dekan.no_peserta 
        LEFT JOIN (
        SELECT 
          mk_klaim_header.no_peserta 
        from 
          mk_klaim_header 
          left join mk_klaim_detail on mk_klaim_header.idklaim = mk_klaim_detail.idklaim and mk_klaim_detail.statusklaim=1
        where 
          mk_klaim_header.kode_prodi = '$kode_prodi' 
          and left(mk_klaim_header.idklaim, 5) = '$ta_akademik' 
          and mk_klaim_detail.idklaim is not null
        GROUP BY 
          mk_klaim_header.no_peserta
      ) mk_nona1simpan ON bio_peserta.no_peserta = mk_nona1simpan.no_peserta 
      LEFT JOIN (
        SELECT 
          mk_klaim_header.no_peserta 
        from 
          mk_klaim_header 
          left join mk_klaim_detail on mk_klaim_header.idklaim = mk_klaim_detail.idklaim and (mk_klaim_detail.statusklaim= 2 or mk_klaim_detail.statusklaim=3)
        where 
          mk_klaim_header.kode_prodi = '$kode_prodi' 
          and left(mk_klaim_header.idklaim, 5) = '$ta_akademik' and mk_klaim_detail.idklaim is noT null
        GROUP BY 
          mk_klaim_header.no_peserta
      ) mk_nona1ajukan ON bio_peserta.no_peserta = mk_nona1ajukan.no_peserta  
        LEFT JOIN (
          SELECT 
            dok_a1.no_registrasi 
          FROM 
            dok_a1 
          where 
            dok_a1.ta_akademik = '$ta_akademik' 
          GROUP BY 
            dok_a1.no_registrasi
        ) mk_a1 on bio_peserta.no_peserta = mk_a1.no_registrasi 
        left join (
          select 
            tb_valid_keu.no_peserta 
          from 
            tb_valid_keu 
          where 
            tb_valid_keu.ta_akademik = '$ta_akademik' 
            and tb_valid_keu.valid = 1
        ) status_valid_bayar on bio_peserta.no_peserta = status_valid_bayar.no_peserta 
      WHERE 
        bio_peserta.ta_akademik = '$ta_akademik' 
        AND bio_peserta.Kode_Prodi = '$kode_prodi'
      ")->getResult();
    return ($result);
  }
}
