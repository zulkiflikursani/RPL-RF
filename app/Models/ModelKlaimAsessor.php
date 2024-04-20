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


    public function simpanklaimAsessor($formdata, $ta_akademik)
    {

        $db      = \Config\Database::connect();

        $BuilderMkKlaim = $db->table("mk_klaim_asessor");
        date_default_timezone_set('Asia/Makassar');

        // Then call the date functions
        $now = date('Y-m-d H:i:s');
        // Or
        // $date = date('Y/m/d H:i:s');
        $db->transStart();
        $idklaim1 = "";
        $statustanggapan = "";
        $status = '';
        foreach ($formdata['jsonObj'] as $a) {
            $idklaim = $a['idklaim'];
            $noregis = $a['noregis'];
            $kdmk = $a['kdmk'];
            $tanggapan = $a['tanggapan'];
            $nilai = $a['nilai'];
            $kdprodi = $a['kdprodi'];
            $kettanggapan = $a['kettanggapan'];
            $cekmk = $this->CekMatakuliahAsessor($a['idklaim']);
            $cekstatusTanggapanMhs = $this->cekstatuTanggapanMhs($noregis);
            // print_r($cekmk);
            $cekvalidprodi = $this->cekValidProdi($idklaim);
            if ($cekstatusTanggapanMhs != null) {
                echo "Belum ditanggapi";
                $status = 'break';
                break;
            } else if ($cekvalidprodi != null) {
                echo "Tidak bisa diganti karena sudah divalidasi oleh prodi";
                $status = 'break';
                break;
            } else {
                if ($cekmk != null) {
                    $dataMK = [
                        // "idklaim" => $idklaim,
                        "ta_akademik" => $ta_akademik,
                        "no_peserta" => $noregis,
                        "idpengguna" => session()->get('id'),
                        "kode_prodi" => $kdprodi,
                        "kode_matakuliah" => $kdmk,
                        "nilai" => $nilai,
                        "tanggapan" => $tanggapan,
                        "ket_tanggapan" => $kettanggapan,
                        "tglubah" => $now,
                    ];

                    if ($tanggapan == 1) {
                        $BuilderMkDetail = $db->table("mk_klaim_detail");
                        $BuilderMkDetail->set('statusklaim', 3)->where('idklaim', $idklaim)->update();
                    }
                    $updatemkKlaim = $BuilderMkKlaim->where("idklaim", $idklaim)->update($dataMK);
                } else {
                    $dataMK = [
                        "idklaim" => $idklaim,
                        "ta_akademik" => $ta_akademik,
                        "no_peserta" => $noregis,
                        "idpengguna" => session()->get('id'),
                        "kode_prodi" => $kdprodi,
                        "kode_matakuliah" => $kdmk,
                        "nilai" => $nilai,
                        "tanggapan" => $tanggapan,
                        "ket_tanggapan" => $kettanggapan,
                        "tglbuat" => $now,
                        "tglubah" => $now,
                    ];
                    if ($tanggapan == 1) {
                        $BuilderMkDetail = $db->table("mk_klaim_detail");
                        $BuilderMkDetail->set('statusklaim', 3)->where('idklaim', $idklaim)->update();
                    }
                    $insertMkhdetail = $BuilderMkKlaim->insert($dataMK);
                }
            }
        }
        if ($status == 'break') {
        } else {

            if ($db->transStatus() === false) {
                $db->transRollback();
                echo "gagal";
            } else {
                $db->transCommit();
                echo "sukses";
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
            $db->transComplete();
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

    public function cekStatusKlaimAsessor($idklaim)
    {
        $db      = \Config\Database::connect();
        $data = $db->query("select idklaim from mk_klaim_asessor where mk_klaim_asessor.idklaim ='$idklaim'")->getResult();
        return $data;
    }
    public function cekValidProdiByNoregis($noregis)
    {
        $ModelKlaimProdi = new ModelKlaimProdi();

        $data = $ModelKlaimProdi->where('mid(idklaim,6,10)', $noregis)->findAll();

        return $data;
    }
    public function cekStatusKlaimAsessorBynoregis($noregis)
    {
        $db      = \Config\Database::connect();
        $data = $db->query("select idklaim from mk_klaim_asessor where mid(mk_klaim_asessor.idklaim,6,10) ='$noregis'")->getResult();
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
                                WHERE
                                    mk_klaim_header.no_peserta = '$noregis' order by mk_klaim_header.nama_matakuliah,mk_klaim_detail.idcpmk")->getResultArray();

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
}