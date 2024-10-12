<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKlaimAsessor extends Model
{
    protected $table      = 'mk_klaim_asessor';
    protected $primaryKey = 'idklaim';

    protected $returnType     = 'array';


    protected $allowedFields = [
        "idklaim",
        "ta_akademik",
        "no_peserta",
        "idpengguna",
        "kode_prodi",
        "kode_matakuliah",
        "nilai",
        "tanggapan",
        "ket_tanggapan",
        "tglbuat",
        "tglubah",

    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tglbuat';
    protected $updatedField  = 'tglubah';
    protected $validationRules = [
        "idklaim" => 'require|is_unique[mk_klaim_asessor.idklaim]',
        "ta_akademik" => 'require',
        "no_peserta" => 'require',
        "idpengguna" => 'require',
        "kode_prodi" => 'require',
        "kode_matakuliah" => 'require',
        "nilai" => 'require',
        "tanggapan" => 'require',
        "ket_tanggapan" => 'require',

    ];
    protected $validationMessages = [
        'idklaim' => [
            'is_unique' => 'Sorry id klaim sudah digunakan.Silahkan hubungi admin.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;


    //submit klaim asessor
    public function simpanklaimAsessor($formdata, $ta_akademik)
    {

        $db      = \Config\Database::connect();
        $noregis = $formdata['jsonObj'][0]['noregis'];
        $idpengguna = session()->get('id');
        $cekstatusTanggapanMhs = $this->cekstatuTanggapanMhs($noregis);
        $cekvalidprodi = $this->cekValidProdiByNoregis($noregis);
        $ceksubmitasessor = $db->query("select idklaim from mk_klaim_asessor where mid(idklaim,6,10) ='$noregis'")->getResult();
        if ($cekstatusTanggapanMhs != null) {
            echo "Belum ditanggapi";
        } else if ($cekvalidprodi != null) {
            echo "Tidak bisa diganti karena sudah divalidasi oleh prodi";
        } else if ($ceksubmitasessor != null) {
            $cekstatusditanggapi = $db->query("select idklaim from mk_klaim_asessor where mid(idklaim,6,10) = '$noregis' and tanggapan = 2")->getResult();
            if ($cekstatusditanggapi != null) {
                $ModalTransactionKlaimSementara = new ModelKlaimAsessorSementara();
                $ModalTransactionKlaimSementara->simpanklaimAsessor($formdata, $ta_akademik);
                $delete = $db->query("DELETE from mk_klaim_asessor where mk_klaim_asessor.no_peserta = '$noregis' and mk_klaim_asessor.idpengguna='$idpengguna'");
                $result = $db->query("INSERT INTO mk_klaim_asessor SELECT * FROM mk_klaim_asessor_sementara where mk_klaim_asessor_sementara.no_peserta = '$noregis' and mk_klaim_asessor_sementara.idpengguna='$idpengguna'");
                if (!$result) {
                    // Output any error messages
                    echo "Error: " . $db->error();
                } else if ($db->affectedRows() > 0) {
                    echo "sukses";
                } else {
                    echo "gagal";
                }
            } else {
                echo "Batalkan asessment untuk melakukan assesment ulang";
            }
        } else {
            $ModalTransactionKlaimSementara = new ModelKlaimAsessorSementara();
            $ModalTransactionKlaimSementara->simpanklaimAsessor($formdata, $ta_akademik);
            $result = $db->query("INSERT INTO mk_klaim_asessor SELECT * FROM mk_klaim_asessor_sementara where mk_klaim_asessor_sementara.no_peserta = '$noregis' and mk_klaim_asessor_sementara.idpengguna='$idpengguna'");
            if (!$result) {
                // Output any error messages
                echo "Error: " . $db->error();
            } else if ($db->affectedRows() > 0) {
                echo "sukses";
            } else {
                echo "gagal";
            }
        }
    }
    public function cekstatuTanggapanMhs($noregis)
    {
        $modelKlaimAsessos = new ModelKlaimAsessor();
        $status = $modelKlaimAsessos->where('no_peserta', $noregis)
            ->where('tanggapan', 1)->findAll();

        return $status;
    }

    public function simpanklaimAsessorA1($formdata,  $kodeprodi, $ta_akademik)
    {
        $db      = \Config\Database::connect();
        $noregis = session()->get("noregis");
        // $kodeprodi = $this->getkodeprodi($noregis);
        // $db      = \Config\Database::connect();
        $BuilderMkHeader = $db->table("mk_klaim_header");
        $BuilderMkA1 = $db->table("mk_klaim_a1");
        $db->transStart();
        $idklaim1 = "";
        $klaimstatus = true;

        date_default_timezone_set('Asia/Makassar');
        $now = date('Y-m-d H:i:s');
        foreach ($formdata as $a) {
            $noregis = $a['noregis'];
            $idklaim = $ta_akademik . $noregis . $a['kdmk'];
            if ($a['kdmk'] == "" || $a['nmmk'] == "" || $a['sks'] == "" || $a['nilai'] == "" || $a['kdmka'] == "" || $a['nmmka'] == "" || $a['sksa'] == "" || $a['nilaia'] == "") {
                $db->transRollback();
                echo "Data Tidak Lengkap";
                $klaimstatus = false;
                break;
            }
            // $kdmk = $a['kdmk'];
            $dataMKHeader = [
                "idklaim" => $idklaim,
                "ta_akademik" => $ta_akademik,
                "no_peserta" => $noregis,
                "kode_prodi" => $kodeprodi,
                "desk" => "",
                "kode_matakuliah" => $a['kdmk'],
                "nama_matakuliah" => $a['nmmk'],
                "sks" => $a['sks'],
                "tglbuat" => $now,
                "tglubah" => $now,

            ];
            $dataMksA1 = [
                "ta_akademik" => $idklaim,
                "no_registrasi" => $noregis,
                "kode_matakuliah_asal" => $a['kdmka'],
                "kode_matakuliah" => $a['kdmk'],
                "nilai" => $a['nilai'],
                "tglklaim" => $now,

            ];
            $BuilderMkA1->insert($dataMksA1);
            if ($idklaim1 != $idklaim) {
                $BuilderMkHeader->insert($dataMKHeader);
                $idklaim1 = $idklaim;
            }
        }

        if ($klaimstatus == true) {
            if ($db->transStatus() === false) {
                $db->transRollback();
                echo "Gagal Mengklaim Matakuliah";
            } else {
                $db->transCommit();
                echo "Sukses Mengklaim Matakuliah";
            }
        }
    }
    public function batalklaimA1($idklaim)
    {
        $db      = \Config\Database::connect();
        $BuilderMkHeader = $db->table("mk_klaim_header");
        $BuilderMkA1 = $db->table("mk_klaim_a1");
        // $ta_akademik = $this->getTa_akademik();
        $db->transStart();

        $whereA1 = [
            "no_registrasi" => substr($idklaim, 5, 10),
            "kode_matakuliah" => substr($idklaim, 15, 9)
        ];
        $hapusMkheader = $BuilderMkHeader->where("idklaim", $idklaim)->delete();
        $hapusMkhdetail = $BuilderMkA1->where($whereA1)->delete();
        if ($db->transStatus() === false) {
            $db->transRollback();
            echo "Gagal Membatalkan Klaim Matakuliah";
        } else {
            $db->transCommit();
            echo "Sukses Membatalkan Klaim Matakuliah";
        }
    }
    public function cekStatusKlaimAsessor($idklaim)
    {
        $db      = \Config\Database::connect();
        $data = $db->query("select idklaim from mk_klaim_asessor where mk_klaim_asessor.idklaim ='$idklaim'")->getResult();
        return $data;
    }
    public function cekValidProdiByNoregis($noregis)
    {
        $db      = \Config\Database::connect();
        $data = $db->query("select idklaim from mk_klaim_prodi where mid(mk_klaim_prodi.idklaim,6,10) ='$noregis'")->getResult();

        return $data;
    }
    public function cekStatusKlaimAsessorBynoregis($noregis)
    {
        $db      = \Config\Database::connect();
        $data = $db->query("select idklaim from mk_klaim_asessor where mid(mk_klaim_asessor.idklaim,6,10) ='$noregis'")->getResult();
        return $data;
    }
    public function cekValidProdiA1($noregis)
    {
        $ModelKlaimProdi = new ModelKlaimProdi();

        $db      = \Config\Database::connect();
        $data = $db->query("select * from mk_klaim_prodi where mid(mk_klaim_prodi.idklaim,6,10)='$noregis'")->getResult();

        return $data;
    }
    public function batalklaimdokA1($noregis)
    {
        $db      = \Config\Database::connect();
        $BuilderMkHeader = $db->table("mk_klaim_header");
        $BuilderMkklaimprodi = new ModelKlaimProdi();
        $BuilderdokA1 = $db->table("dok_a1");
        // $ta_akademik = $this->getTa_akademik();
        $db->transStart();

        $update = [
            "status" => 1,
        ];
        $cekklaimass = $db->query("delete from mk_klaim_a1 where no_registrasi = '$noregis'");
        $cekklaimass = $db->query("delete from mk_klaim_header where no_peserta = '$noregis'");
        $udpatedoka1 = $BuilderdokA1->set($update)->where('no_registrasi', $noregis)->update();
        if ($db->transStatus() === false) {
            $db->transRollback();
            echo "Gagal Membatalkan Klaim Matakuliah";
        } else {
            $db->transCommit();
            echo "Sukses Membatalkan Klaim Matakuliah";
        }
    }
    public function batalklaimasessor($noregis)
    {
        $db      = \Config\Database::connect();

        // $db->transStart();
        $idpengguna = session()->get('id');
        $cekvalidprodi = $this->cekValidProdibatalklaim($noregis);
        if ($cekvalidprodi == null) {
            $db->transStart();
            $db->query("update mk_klaim_detail set statusklaim='2' where mid(mk_klaim_detail.idklaim,6,10)='$noregis'");
            $hapusklaim =  $db->query("delete from mk_klaim_asessor where no_peserta='$noregis' and idpengguna='$idpengguna'");
            if ($hapusklaim === false) {
                $db->transRollback();
                return "Gagal Membatalkan Klaim Matakuliah";
            } else {
                $db->transCommit();
                return "Sukses Membatalkan Klaim Matakuliah";
            }
        } else {
            return "Tidak bisa diunvalidasi karena sudah divalidasi prodi";
        }
    }
    public function cekValidProdibatalklaim($noregis)
    {
        $db      = \Config\Database::connect();
        $data = $db->query("select idklaim from mk_klaim_prodi where mid(idklaim,6,10) ='$noregis'")->getResult();

        return $data;
    }
    public function cekValidProdi($idklaim)
    {
        $ModelKlaimProdi = new ModelKlaimProdi();

        $data = $ModelKlaimProdi->where('idklaim', $idklaim)->findAll();

        return $data;
    }

    public function getKlaimMk_mahasiswa($noregis)
    {
        $db      = \Config\Database::connect();
        $Result = $db->query("SELECT
                                    mk_klaim_header.idklaim,
                                    mk_klaim_header.ta_akademik,
                                    mk_klaim_header.no_peserta,
                                    mk_klaim_header.kode_prodi,
                                    mk_klaim_header.kode_matakuliah,
                                    mk_klaim_header.nama_matakuliah,
                                    IFNULL(matakuliah.jenis_matakuliah,'Matakuliah ini sudah tidak tersaji di master matakuliah') as jenis_matakuliah,
                                    mk_klaim_header.desk,
                                    mk_klaim_header.sks,
                                    mk_klaim_header.tglbuat,
                                    mk_klaim_header.tglubah,
                                    mk_klaim_detail.idcpmk,
                                    mk_klaim_detail.cpmk,
                                    mk_klaim_detail.klaim,
                                    mk_klaim_detail.statusklaim,
                                    ref_klaim.no_dokumen,(SELECT COUNT(*) FROM ref_klaim as it 
                                WHERE it.idklaim = mk_klaim_detail.idklaim) as entry_count
                                FROM
                                    mk_klaim_header
                                left join mk_klaim_detail on mk_klaim_header.idklaim=mk_klaim_detail.idklaim 
                                LEFT JOIN ref_klaim on mk_klaim_header.idklaim=ref_klaim.idklaim
                                LEFT JOIN dok_portofolio on ref_klaim.no_dokumen= dok_portofolio.no_dokumen
                                LEFT JOIN matakuliah on mk_klaim_header.kode_matakuliah = matakuliah.kode_matakuliah and (mk_klaim_header.kode_prodi=matakuliah.kode_prodi or matakuliah.jenis_matakuliah< 3)

                                WHERE
                                    mk_klaim_header.no_peserta = '$noregis' order by mk_klaim_header.nama_matakuliah,mk_klaim_detail.idcpmk")->getResultArray();

        return $Result;
    }
    public function getKlaimMk_mahasiswaByProdi($kode_prodi, $ta_akademik)
    {
        $db      = \Config\Database::connect();
        $Result = $db->query("SELECT
                                mk_klaim_asessor.no_peserta,
                                peserta.nama,
                                mk_klaim_asessor.kode_prodi,
                                klaim_mahasiswa.idklaim,
                                klaim_mahasiswa.kode_matakuliah,
                                klaim_mahasiswa.nama_matakuliah,
                                klaim_mahasiswa.jenis_matakuliah,
                                klaim_mahasiswa.idcpmk,
                                klaim_mahasiswa.cpmk,
                                klaim_mahasiswa.sks,
                                klaim_mahasiswa.klaim,
                                klaim_mahasiswa.desk,
                                klaim_mahasiswa.no_dokumen,
                                mk_klaim_asessor.tanggapan,
                                mk_klaim_asessor.nilai,
                                mk_klaim_asessor.ket_tanggapan,
                                klaim_mahasiswa.entry_count,
                                (
                                            SELECT
                                                COUNT(*)
                                            FROM
                                                mk_klaim_header AS it
                                            WHERE
                                                mid(it.idklaim,6,10) = mk_klaim_asessor.no_peserta) AS entry_count_mahasiswa

                            FROM
                                mk_klaim_asessor
                                LEFT JOIN (
                                    SELECT
                                        mk_klaim_detail.idklaim,
                                        mk_klaim_header.kode_matakuliah,
                                        mk_klaim_header.nama_matakuliah,
                                        mk_klaim_header.sks,
                                        mk_klaim_detail.idcpmk,
                                        mk_klaim_detail.cpmk,
                                        mk_klaim_detail.klaim,
                                        mk_klaim_header.desk,
                                        ref_klaim.no_dokumen,
                                        matakuliah.jenis_matakuliah,
                                        (
                                            SELECT
                                                COUNT(*)
                                            FROM
                                                ref_klaim AS it
                                            WHERE
                                                it.idklaim = mk_klaim_detail.idklaim) AS entry_count
                                        FROM
                                            mk_klaim_header
                                        LEFT JOIN mk_klaim_detail ON mk_klaim_header.idklaim = mk_klaim_detail.idklaim
                                        LEFT JOIN matakuliah on mk_klaim_header.kode_matakuliah = matakuliah.kode_matakuliah and (mk_klaim_header.kode_prodi=matakuliah.kode_prodi or matakuliah.jenis_matakuliah < 3)
                                        LEFT JOIN ref_klaim ON mk_klaim_header.idklaim = ref_klaim.idklaim
                                    WHERE
                                        mk_klaim_header.ta_akademik = '$ta_akademik'
                                        AND mk_klaim_header.kode_prodi = '$kode_prodi') klaim_mahasiswa ON klaim_mahasiswa.idklaim = mk_klaim_asessor.idklaim
                                LEFT JOIN mk_klaim_dekan ON mk_klaim_dekan.idklaim = mk_klaim_asessor.idklaim
                               LEFT JOIN (
                                    SELECT
                                    bio_peserta.nama, bio_peserta.no_peserta from bio_peserta where bio_peserta.ta_akademik='$ta_akademik' and bio_peserta.kode_prodi='$kode_prodi')peserta on peserta.no_peserta = mk_klaim_asessor.no_peserta
                                LEFT JOIN (
                                    SELECT * FROM tb_valid_keu where tb_valid_keu.valid=1 and tb_valid_keu.ta_akademik ='$ta_akademik'
                                )valid_keu on valid_keu.no_peserta = mk_klaim_asessor.no_peserta
                            WHERE
                                mk_klaim_dekan.idklaim IS NOT NULL
                                AND mk_klaim_asessor.ta_akademik = '$ta_akademik'
                                AND mk_klaim_asessor.kode_prodi = '$kode_prodi'
                                AND klaim_mahasiswa.idklaim is not null
                                and valid_keu.no_peserta is not null
                            ORDER BY
                                mk_klaim_asessor.no_peserta, mk_klaim_asessor.idklaim")->getResultArray();

        return $Result;
    }
    public function getKlaimMk_mahasiswaA1ByProdi($kode_prodi, $ta_akademik)
    {
        $db      = \Config\Database::connect();
        $Result = $db->query("SELECT
                                mk_klaim_asessor.no_peserta,
                                peserta.nama,
                                mk_klaim_asessor.kode_prodi,
                                klaim_mahasiswa.idklaim,
                                klaim_mahasiswa.kode_matakuliah,
                                klaim_mahasiswa.nama_matakuliah,
                                klaim_mahasiswa.kode_matakuliah_asal,
                                klaim_mahasiswa.nama_matakuliah_asal,
                                klaim_mahasiswa.nilai_asal,
                                klaim_mahasiswa.sks,
                                klaim_mahasiswa.jumlah_sks,
                                mk_klaim_asessor.nilai,
                                mk_klaim_asessor.tanggapan,
                                mk_klaim_asessor.ket_tanggapan,
                                klaim_mahasiswa.entry_count,
                                (
                                    SELECT
                                        COUNT(*)
                                    FROM
                                        mk_klaim_header AS it
                                    WHERE
                                        mid(it.idklaim, 6, 10) = mk_klaim_asessor.no_peserta) AS entry_count_mahasiswa
                                FROM
                                    mk_klaim_asessor
                                LEFT JOIN (
                                    SELECT
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
                                        (
                                            SELECT
                                                COUNT(*)
                                            FROM
                                                mk_klaim_a1 AS it
                                            WHERE
                                                it.kode_matakuliah = mk_klaim_a1.kode_matakuliah
                                                AND it.no_registrasi = mk_klaim_a1.no_registrasi) AS entry_count
                                        FROM
                                            mk_klaim_header
                                        LEFT JOIN mk_klaim_a1 ON mk_klaim_header.no_peserta = mk_klaim_a1.no_registrasi
                                            AND mk_klaim_header.kode_matakuliah = mk_klaim_a1.kode_matakuliah
                                    LEFT JOIN dok_a1 ON TRIM(REPLACE(mk_klaim_a1.kode_matakuliah_asal, CHAR(9), '')) = TRIM(REPLACE(dok_a1.kode_matakuliah, CHAR(9), ''))
                                        AND mk_klaim_a1.no_registrasi = dok_a1.no_registrasi
                                WHERE
                                    mk_klaim_header.ta_akademik = '$ta_akademik'
                                    AND mk_klaim_header.kode_prodi = '$kode_prodi'
                                    AND mk_klaim_a1.no_registrasi is not null
                                ORDER BY
                                    mk_klaim_header.kode_matakuliah) klaim_mahasiswa ON klaim_mahasiswa.idklaim = mk_klaim_asessor.idklaim
                                LEFT JOIN mk_klaim_dekan ON mk_klaim_dekan.idklaim = mk_klaim_asessor.idklaim
                                LEFT JOIN (
                                    SELECT
                                        bio_peserta.nama,
                                        bio_peserta.no_peserta
                                    FROM
                                        bio_peserta
                                    WHERE
                                        bio_peserta.ta_akademik = '$ta_akademik'
                                        AND bio_peserta.kode_prodi = '$kode_prodi') peserta ON peserta.no_peserta = mk_klaim_asessor.no_peserta
                                LEFT JOIN (
                                    SELECT * FROM tb_valid_keu where tb_valid_keu.valid=1 and tb_valid_keu.ta_akademik ='$ta_akademik'
                                )valid_keu on valid_keu.no_peserta = mk_klaim_asessor.no_peserta
                            WHERE
                                valid_keu.no_peserta  is not null
                                and mk_klaim_dekan.idklaim IS NOT NULL
                                AND mk_klaim_asessor.ta_akademik = '$ta_akademik'
                                AND mk_klaim_asessor.kode_prodi = '$kode_prodi'
                                AND klaim_mahasiswa.idklaim IS NOT NULL
                            group by mk_klaim_asessor.idklaim
                            ORDER BY
                                mk_klaim_asessor.no_peserta, mk_klaim_asessor.idklaim
                                ")->getResult();

        return $Result;
    }

    public function getProdiRPL()
    {
        $db      = \Config\Database::connect();
        $Result = $db->query("select * from prodi")->getResult();

        return $Result;
    }
    public function getFakultasRPL()
    {
        $db      = \Config\Database::connect();
        $Result = $db->query("select * from fakultas ")->getResult();

        return $Result;
    }
    public function CekMatakuliah($kdmatakuliah)
    {
        $modelMkHeader = new ModelKlaimMkHeader();
        $result = $modelMkHeader->where("kode_matakuliah", $kdmatakuliah)->findAll();
        return $result;
    }


    public function CekMatakuliahAsessor($idklaim)
    {
        $db      = \Config\Database::connect();
        // $BuilderMkKlaim = $db->table("mk_klaim_asessor");
        $result = $db->query("select * from mk_klaim_asessor where idklaim='$idklaim'")->getResult();
        return $result;
    }

    public function getDataKlaimAsessor($noregis)
    {
        $db      = \Config\Database::connect();
        // $BuilderMkKlaim = $db->table("mk_klaim_asessor");
        $result = $db->query("select * from mk_klaim_asessor where no_peserta='$noregis'")->getResult();
        return $result;
    }
    public function getDataResponAsessor($noregis)
    {
        $db      = \Config\Database::connect();
        // $BuilderMkKlaim = $db->table("mk_klaim_asessor");
        $result = $db->query("SELECT
                        mk_klaim_header.idklaim,
                        mk_klaim_header.ta_akademik,
                        mk_klaim_header.no_peserta,
                        mk_klaim_header.kode_prodi,
                        mk_klaim_header.kode_matakuliah,
                        mk_klaim_header.nama_matakuliah,
                        mk_klaim_header.desk,
                        mk_klaim_header.sks,
                        mk_klaim_detail.idcpmk,
                        mk_klaim_detail.cpmk,
                        mk_klaim_detail.klaim,
                        mk_klaim_detail.statusklaim,
                        ref_klaim.no_dokumen,
                        mk_klaim_asessor.idpengguna,
                        mk_klaim_asessor.kode_prodi,
                        mk_klaim_asessor.nilai,
                        mk_klaim_asessor.tanggapan,
                        mk_klaim_asessor.ket_tanggapan,
                        dok_portofolio.nmfile,
                        dok_portofolio.lokasi_file,
                        dok_portofolio.nmfile_asli,
                        dok_portofolio.jenis_dokumen,
                        dok_portofolio.url,
                        (SELECT COUNT(*) FROM ref_klaim as it 
                                WHERE it.idklaim = mk_klaim_detail.idklaim) as entry_count
                        FROM
                        mk_klaim_header
                        LEFT JOIN mk_klaim_detail ON mk_klaim_header.idklaim = mk_klaim_detail.idklaim
                        LEFT JOIN ref_klaim ON mk_klaim_detail.idklaim = ref_klaim.idklaim 
                        LEFT JOIN mk_klaim_asessor ON ref_klaim.idklaim = mk_klaim_asessor.idklaim
                        LEFT JOIN dok_portofolio ON ref_klaim.no_dokumen = dok_portofolio.no_dokumen
                        where mk_klaim_header.no_peserta='$noregis'
                        order by mk_klaim_header.kode_matakuliah, mk_klaim_detail.idcpmk
                        ")->getResult();
        return $result;
    }

    public function getDataMahasiswaPerFak($ta_akademik, $kode_fakultas)
    {
        $db = \Config\Database::connect();
        $result = $db->query("SELECT
                    mk_klaim_dekan.idklaim,
                    mk_klaim_asessor.ta_akademik,
                    mk_klaim_asessor.no_peserta,
                    bio_peserta.nama,
                    mk_klaim_asessor.kode_matakuliah,
                    mk_klaim_asessor.nilai,
                    mk_klaim_header.sks,
                    mk_klaim_header.nama_matakuliah,
                    mk_klaim_asessor.kode_prodi,
                    bio_peserta.jenis_rpl,
                    bio_peserta.instansi_asal,
                    prodi.nama_prodi,
                    prodi.id_jenjang,
                    fakultas.nama_fakultas,
                    fakultas.kode_fakultas,
                    -- 1 as jbaris
                    (SELECT COUNT(*) FROM mk_klaim_asessor as it 
                    left join mk_klaim_header on it.idklaim = mk_klaim_header.idklaim 
                                            WHERE mid(it.idklaim,6,10) = mid(mk_klaim_asessor.idklaim,6,10)  and it.nilai !='E' and mk_klaim_header.idklaim is not null) as jbaris
                    FROM
                    mk_klaim_dekan
                    LEFT JOIN mk_klaim_asessor ON mk_klaim_dekan.idklaim = mk_klaim_asessor.idklaim
                    LEFT JOIN bio_peserta ON mid(mk_klaim_dekan.idklaim,6,10)= bio_peserta.no_peserta
                    LEFT JOIN matakuliah ON TRIM(REPLACE(mk_klaim_asessor.kode_matakuliah,CHAR(9),'')) = TRIM(REPLACE(matakuliah.kode_matakuliah,CHAR(9),'')) AND mk_klaim_asessor.kode_prodi = matakuliah.kode_prodi
                    LEFT JOIN prodi ON mk_klaim_asessor.kode_prodi = prodi.kode_prodi
                    LEFT JOIN fakultas ON prodi.kode_fakultas = fakultas.kode_fakultas       
                    left join mk_klaim_header on mk_klaim_asessor.idklaim= mk_klaim_header.idklaim
                    LEFT JOIN (
                    SELECT * FROM tb_valid_keu where tb_valid_keu.valid=1 and tb_valid_keu.ta_akademik ='$ta_akademik')valid_keu on valid_keu.no_peserta = mk_klaim_asessor.no_peserta
                    where valid_keu.no_peserta is not null and fakultas.kode_fakultas='$kode_fakultas' and mk_klaim_asessor.idklaim is not null and mk_klaim_asessor.ta_akademik ='$ta_akademik' and mk_klaim_asessor.nilai != 'E' and mk_klaim_header.idklaim is not null
                    order by mk_klaim_dekan.idklaim 
        ")->getResult();
        return $result;
    }
}
