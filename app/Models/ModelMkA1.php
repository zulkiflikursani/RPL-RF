<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMkA1 extends Model
{
    protected $table      = 'dok_a1';
    protected $primaryKey = 'kode_matakuliah';

    protected $allowedFields = [
        "ta_akademik",
        "no_registrasi",
        "kode_perguruan_tinggi",
        "nama_perguruan_tinggi",
        "kode_matakuliah",
        "nama_matakuliah",
        "status",
        "jumlah_sks",
        "nilai",

    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tglbuat';
    protected $updatedField  = 'tglubah';
    protected $validationRules = [
        "ta_akademik" => 'required',
        "no_registrasi" => 'required',
        "kode_perguruan_tinggi" => 'required',
        "nama_perguruan_tinggi" => 'required',
        "kode_matakuliah" => 'required',
        "nama_matakuliah" => 'required',
        "jumlah_sks" => 'required',
        "status" => 'required',
        "nilai" => 'required',

    ];
    protected $validationMessages = [
        'kode_matakuliah' => [
            'is_unique' => 'Sorry. Nomor kode matakuliah sudah digunakan.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $returnType     = 'array';

    public function insertdata($formdata, $ta_akademik)
    {
        $db      = \Config\Database::connect();
        $noregis = session()->get("noregis");
        $BuilderMkAi = $db->table("dok_a1");
        $ModelMkA1 = new ModelMkA1();
        $db->transStart();
        date_default_timezone_set('Asia/Makassar');
        $now = date('Y-m-d H:i:s');
        $klaimstatus = true;

        foreach ($formdata['jsonObj'] as $a) {
            $kdpt = trim($db->escapeString($a['kdpt']));
            $nmpt = $db->escapeString($a['nmpt']);
            $kdmk = trim($db->escapeString($a['kdmk']));
            $nmmk = $db->escapeString($a['nmmk']);
            $sks = $db->escapeString($a['sks']);
            $nilai = $db->escapeString($a['nilai']);

            if ($kdpt == "" || $nmpt == "" || $kdmk == "" || $nmmk == "" || $sks == "" || $nilai == "") {
                $db->transRollback();
                echo "Data Tidak Lengkap";
                $klaimstatus = false;
                break;
            }

            $where = [
                "no_registrasi" => $noregis,
                "kode_matakuliah" => $kdmk

            ];

            $cekkdmk = $ModelMkA1->where($where)->findAll(); //dok_a1
            if ($cekkdmk != null) {
                $db->transRollback();
                echo "Duplikasi Kode Matakuliah " . $cekkdmk[0]['kode_matakuliah'] . " " . $cekkdmk[0]['nama_matakuliah'] . " ! Periksa kembali sumber data matakuliah anda dan lakukan import ulang";
                $klaimstatus = false;
                break;
            }

            if ($klaimstatus == true) {
                $data = [
                    "ta_akademik" => $ta_akademik,
                    "no_registrasi" => $noregis,
                    "kode_perguruan_tinggi" => $kdpt,
                    "nama_perguruan_tinggi" => $nmpt,
                    "kode_matakuliah" => trim($kdmk),
                    "nama_matakuliah" => $nmmk,
                    "jumlah_sks" => $sks,
                    "status" => 1,
                    "nilai" => $nilai,
                    "tglbuat" => $now,
                    "tglubah" => $now,
                ];
                $insertMk = $BuilderMkAi->insert($data);
            }
        }
        if ($klaimstatus == true) {
            if ($db->transStatus() === false) {
                $db->transRollback();
                echo "Gagal Menyimpan Matakuliah";
            } else {
                $db->transCommit();
                echo "Sukses Menyimpan Matakuliah";
            }
        }
    }

    public function dataMhsBelumUploadMk($ta_akademik)
    {
        $db      = \Config\Database::connect();
        $result = $db->query("SELECT
                            bio_peserta.nama,
                            bio_peserta.no_peserta,
                            bio_peserta.ta_akademik,
                            bio_peserta.email,
                            bio_peserta.jenis_rpl,
                            bio_peserta.kode_prodi,
                            dok_a1.kode_perguruan_tinggi,
                            dok_a1.kode_matakuliah,
                            dok_a1.nama_matakuliah,
                            dok_a1.jumlah_sks,
                            dok_a1.nilai,
                            prodi.nama_prodi 
                            FROM
                            bio_peserta
                            LEFT JOIN (select * from dok_a1 where dok_a1.ta_akademik='$ta_akademik')dok_a1 ON bio_peserta.no_peserta = dok_a1.no_registrasi AND bio_peserta.ta_akademik = dok_a1.ta_akademik
                            left join 
                            prodi on bio_peserta.kode_prodi = prodi.kode_prodi
                            where bio_peserta.jenis_rpl=1 and (dok_a1.no_registrasi is null or dok_a1.status= 1) and bio_peserta.ta_akademik='$ta_akademik'
                            GROUP BY  bio_peserta.no_peserta
                            ")->getResult();


        return $result;
    }
    public function dataMhsBelumAsesiA1($ta_akademik)
    {
        $db      = \Config\Database::connect();
        $idpengguna = session()->get("id");
        $result = $db->query("SELECT
                        bio_peserta.nama,
                        bio_peserta.no_peserta,
                        bio_peserta.ta_akademik,
                        bio_peserta.email,
                        bio_peserta.jenis_rpl,
                        bio_peserta.kode_prodi,
                        dok_a1.kode_perguruan_tinggi,
                        dok_a1.kode_matakuliah,
                        dok_a1.nama_matakuliah,
                        dok_a1.jumlah_sks,
                        dok_a1.nilai,
                        dok_a1.tglubah,
                        prodi.nama_prodi
                        FROM
                            bio_peserta
                        LEFT JOIN dok_a1 ON bio_peserta.no_peserta = dok_a1.no_registrasi
                        AND bio_peserta.ta_akademik = dok_a1.ta_akademik
                        LEFT JOIN mk_klaim_asessor ON bio_peserta.no_peserta = mk_klaim_asessor.no_peserta
                        LEFT JOIN mk_klaim_header ON bio_peserta.no_peserta = mk_klaim_asessor.no_peserta
                        left join prodi on bio_peserta.kode_prodi= prodi.kode_prodi                        left join tb_peserta_asessor on bio_peserta.no_peserta = tb_peserta_asessor.no_peserta
                        WHERE
                            bio_peserta.jenis_rpl = 1
                        AND (dok_a1.no_registrasi IS NOT NULL and  dok_a1.status=0)
                        AND bio_peserta.ta_akademik = '$ta_akademik'
                        AND mk_klaim_asessor.idklaim IS NULL
                        AND tb_peserta_asessor.no_asessor= '$idpengguna'
                        GROUP BY bio_peserta.no_peserta")->getResult();


        return $result;
    }

    public function getDataKlaimAsessorA1($noregis)
    {
        $db      = \Config\Database::connect();
        $idpengguna = session()->get("id");
        $result = $db->query("SELECT
        mk_klaim_header.idklaim,
        mk_klaim_header.ta_akademik,
        mk_klaim_header.no_peserta,
        mk_klaim_header.kode_prodi,
        mk_klaim_header.kode_matakuliah,
        mk_klaim_header.nama_matakuliah,
        mk_klaim_header.sks,
        mk_klaim_header.tglubah,
        mk_klaim_a1.kode_matakuliah_asal,
        mk_klaim_a1.nilai,
        dok_a1.nama_matakuliah AS nama_matakuliah_asal,
        dok_a1.nilai AS nilai_asal,
        dok_a1.jumlah_sks,
        (SELECT COUNT(*) FROM mk_klaim_a1 as it 
                    WHERE it.kode_matakuliah = mk_klaim_a1.kode_matakuliah and it.no_registrasi=mk_klaim_a1.no_registrasi) as entry_count
        FROM
        mk_klaim_header
        -- left join mk_klaim_asessor on mk_klaim_header.idklaim=mk_klaim_asessor.idklaim
        LEFT JOIN mk_klaim_a1 ON mk_klaim_header.no_peserta = mk_klaim_a1.no_registrasi AND TRIM(REPLACE(mk_klaim_header.kode_matakuliah,CHAR(9),'')) = TRIM(REPLACE(mk_klaim_a1.kode_matakuliah,CHAR(9),''))
        LEFT JOIN dok_a1 ON TRIM(REPLACE(mk_klaim_a1.kode_matakuliah_asal,CHAR(9),'')) = TRIM(REPLACE(dok_a1.kode_matakuliah,CHAR(9),'')) and mk_klaim_a1.no_registrasi=dok_a1.no_registrasi
        where mk_klaim_header.no_peserta='$noregis'
        -- and mk_klaim_asessor.idklaim is not null
        order by mk_klaim_a1.tglklaim asc, mk_klaim_header.kode_matakuliah")->getResult();
        return $result;
    }
    public function getDataKlaimAsessorA1up($noregis)
    {
        $db      = \Config\Database::connect();
        $idpengguna = session()->get("id");
        $result = $db->query("SELECT
                    mk_klaim_header.idklaim,
                    mk_klaim_header.ta_akademik,
                    mk_klaim_header.no_peserta,
                    mk_klaim_header.kode_prodi,
                    mk_klaim_header.kode_matakuliah,
                    mk_klaim_header.nama_matakuliah,
                    mk_klaim_header.sks,
                    mk_klaim_header.tglubah,
                    mk_klaim_a1.kode_matakuliah_asal,
                    mk_klaim_a1.nilai,
                    dok_a1.nama_matakuliah AS nama_matakuliah_asal,
                    dok_a1.nilai AS nilai_asal,
                    dok_a1.jumlah_sks,
                    (SELECT COUNT(*) FROM mk_klaim_a1 as it 
                                WHERE it.kode_matakuliah = mk_klaim_a1.kode_matakuliah and it.no_registrasi=mk_klaim_a1.no_registrasi) as entry_count
                    FROM
                    mk_klaim_header
                    left join mk_klaim_asessor on mk_klaim_header.idklaim=mk_klaim_asessor.idklaim
                    LEFT JOIN mk_klaim_a1 ON mk_klaim_header.no_peserta = mk_klaim_a1.no_registrasi AND mk_klaim_header.kode_matakuliah = mk_klaim_a1.kode_matakuliah
                    LEFT JOIN dok_a1 ON TRIM(REPLACE(mk_klaim_a1.kode_matakuliah_asal,CHAR(9),''))= TRIM(REPLACE(dok_a1.kode_matakuliah,CHAR(9),'')) and mk_klaim_a1.no_registrasi = dok_a1.no_registrasi
                    where mk_klaim_header.no_peserta='$noregis'
                    and mk_klaim_asessor.idklaim is not null
                    order by mk_klaim_header.kode_matakuliah")->getResult();
        return $result;
    }
    public function maxsksrekognisi($kode_prodi)
    {
        $db      = \Config\Database::connect();
        $idpengguna = session()->get("id");
        $result = $db->query("SELECT

       prodi.sks_max_rekognisi AS sksmax
        FROM
            prodi
        WHERE
        prodi.kode_prodi = '$kode_prodi'")->getRow();
        return $result;
    }
}
