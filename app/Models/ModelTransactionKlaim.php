<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransactionKlaim extends Model
{
    public function ajukantanggapanklaim($formdata, $status, $kodeprodi, $ta_akademik)
    {
        $db      = \Config\Database::connect();
        $noregis = session()->get("noregis");
        // $kodeprodi = $this->getkodeprodi($noregis);
        // $db      = \Config\Database::connect();
        $BuilderMkHeader = $db->table("mk_klaim_header");
        $BuilderMkDetail = $db->table("mk_klaim_detail");
        $BuilderRefKlaim = $db->table("ref_klaim");
        // $ta_akademik = $this->getTa_akademik();
        $db->transStart();
        $idklaim1 = "";
        $klaimstatus = true;

        date_default_timezone_set('Asia/Makassar');
        $now = date('Y-m-d H:i:s');
        foreach ($formdata['jsonObj'] as $a) {
            $idklaim = $ta_akademik . $noregis . $a['kdmk'];
            if ($a['nilai'] == "" || empty($a['ref']) || $a['desk'] == "") {
                $db->transRollback();
                echo "Data Tidak Lengkap";
                $klaimstatus = false;
                break;
            }
            // $kdmk = $a['kdmk'];

            $cekstatus2 = $db->query("select statusklaim from mk_klaim_detail where idklaim = '$idklaim' and idcpmk='" . $a['idcpmk'] . "'")->getResult();

            if ($cekstatus2 != null) {
                foreach ($cekstatus2 as $row) {

                    $statuspengajuan = $row->statusklaim;
                }
            }

            // return json_encode($result2->getResult());

            $cekmk = $this->CekMatakuliah($a['kdmk']);
            if ($cekmk != null) {
                if ($statuspengajuan == 3) {
                    $dataMKHeader = [
                        "idklaim" => $idklaim,
                        "ta_akademik" => $ta_akademik,
                        "no_peserta" => $noregis,
                        "kode_prodi" => $kodeprodi,
                        "kode_matakuliah" => $a['kdmk'],
                        "nama_matakuliah" => $a['nmmk'],
                        "desk" => $a['desk'],
                        "sks" => $a['sks'],
                        "tglubah" => $now,
                    ];
                    $wheredetail = [
                        "idklaim" => $idklaim,
                        "idcpmk" => $a['idcpmk']
                    ];
                    $dataMKdetail = [
                        "idklaim" => $idklaim,
                        "idcpmk" => $a['idcpmk'],
                        "cpmk" => $a['cpmk'],
                        "klaim" => $a['nilai'],
                        "statusklaim" => $status,
                        "tglubah" => $now,
                    ];
                    if ($idklaim1 != $idklaim) {
                        $updateMkheader = $BuilderMkHeader->where("idklaim", $idklaim)->update($dataMKHeader);
                        $idklaim1 = $idklaim;
                        // foreach ($a['ref'] as $ref) {
                        $dataRef = [
                            "idklaim" => $idklaim,
                            // "idcpmk" => $a['idcpmk'],
                            // "kode_matakuliah" => $a['kdmk'],
                            "no_dokumen" => json_encode($a['ref']),
                            "tglubah" => $now,

                        ];
                        $updateRefKlaim = $BuilderRefKlaim->where("idklaim", $idklaim)->update($dataRef);
                    }
                    $updateMkhdetail = $BuilderMkDetail->where($wheredetail)->update($dataMKdetail);

                    $builderKlaimAsessro = $db->table("mk_klaim_asessor");
                    $unpdateKlaimAsessor = $builderKlaimAsessro->where('idklaim', $idklaim)
                        ->set('tanggapan', 2)
                        ->update();
                } else {
                    echo "Klaim sedang diproses. Silahkan menunggu tanggapan Asessor di menu Respon Asessor " . $statuspengajuan;
                    $klaimstatus = false;
                    break;
                }
            } else {
                echo "Klaim tidak ditemukan";
                $klaimstatus = false;
                break;
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
    public function ajukanklaim($noregis)
    {
        $db      = \Config\Database::connect();
        $sessionnoregis = session()->get("noregis");
        $BuilderMkDetail = $db->table("mk_klaim_detail");

        $cekstatus = $this->Cekpengajuanall($sessionnoregis);
        if ($noregis == $sessionnoregis) {
            if ($cekstatus == 2) {
                echo "Klaim Matakuliah Sudah Diajukan Silahkan Menunggu Respon Asessor di menu Respon Asessor";
            } else {
                $BuilderMkDetail->set('statusklaim', 2)->where('mid(idklaim,6,10)', $sessionnoregis)->update();
                if ($BuilderMkDetail === false) {
                    echo "Gagal Mengajukan Klaim RPL. ";
                } else {
                    echo "Berhasil Mengajukan Klaim RPL. ";
                }
            }
        } else {
            echo "Ingat mati Ingat mati !!!!";
        }
    }
    public function simpanklaim($formdata, $status, $kodeprodi, $ta_akademik)
    {
        $db      = \Config\Database::connect();
        $noregis = session()->get("noregis");
        // $kodeprodi = $this->getkodeprodi($noregis);
        // $db      = \Config\Database::connect();
        $BuilderMkHeader = $db->table("mk_klaim_header");
        $BuilderMkDetail = $db->table("mk_klaim_detail");
        $BuilderRefKlaim = $db->table("ref_klaim");
        // $ta_akademik = $this->getTa_akademik();
        $db->transStart();
        $idklaim1 = "";
        $klaimstatus = true;

        date_default_timezone_set('Asia/Makassar');
        $now = date('Y-m-d H:i:s');
        foreach ($formdata['jsonObj'] as $a) {
            $idklaim = $ta_akademik . $noregis . $a['kdmk'];
            if ($a['nilai'] == "" || empty($a['ref']) || $a['desk'] == "") {
                $db->transRollback();
                echo "Data Tidak Lengkap";
                $klaimstatus = false;
                break;
            }
            // $kdmk = $a['kdmk'];

            $cekstatus = $this->cekstatusmk($idklaim);
            $cekstatus2 = $db->query("select statusklaim from mk_klaim_detail where idklaim = '$idklaim' and idcpmk='" . $a['idcpmk'] . "'")->getResult();

            if ($cekstatus2 != null) {
                foreach ($cekstatus2 as $row) {

                    $statuspengajuan = $row->statusklaim;
                }
            }

            if ($cekstatus2 != null) {
                if ($statuspengajuan == 1) {
                    $dataMKHeader = [
                        "idklaim" => $idklaim,
                        "ta_akademik" => $ta_akademik,
                        "no_peserta" => $noregis,
                        "kode_prodi" => $kodeprodi,
                        "kode_matakuliah" => $a['kdmk'],
                        "nama_matakuliah" => $a['nmmk'],
                        "desk" => $a['desk'],
                        "sks" => $a['sks'],
                        "tglubah" => $now,
                    ];
                    $wheredetail = [
                        "idklaim" => $idklaim,
                        "idcpmk" => $a['idcpmk']
                    ];
                    $dataMKdetail = [
                        "idklaim" => $idklaim,
                        "idcpmk" => $a['idcpmk'],
                        "cpmk" => $a['cpmk'],
                        "klaim" => $a['nilai'],
                        "statusklaim" => $status,
                        "tglubah" => $now,
                    ];
                    if ($idklaim1 != $idklaim) {
                        $updateMkheader = $BuilderMkHeader->where("idklaim", $idklaim)->update($dataMKHeader);

                        // $insertMkheader = $BuilderMkHeader->insert($dataMKHeader);
                        $idklaim1 = $idklaim;
                        // foreach ($a['ref'] as $ref) {
                        $dataRef = [
                            "idklaim" => $idklaim,
                            // "idcpmk" => $a['idcpmk'],
                            // "kode_matakuliah" => $a['kdmk'],
                            "no_dokumen" => json_encode($a['ref']),
                            "tglubah" => $now,


                        ];
                        $updateRefKlaim = $BuilderRefKlaim->where("idklaim", $idklaim)->update($dataRef);
                        // $insertRefKlaim = $BuilderRefKlaim->insert($dataRef);
                    }
                    $updateMkhdetail = $BuilderMkDetail->where($wheredetail)->update($dataMKdetail);
                    // $insertMkhdetail = $BuilderMkDetail->insert($dataMKdetail);
                } else {
                    echo "Klaim sedang diproses. Silahkan menunggu tanggapan Asessor di menu Respon Asessor";
                }
            } else {
                $cekstatus2 = $db->query("select statusklaim from mk_klaim_detail where idklaim = '$idklaim' and idcpmk='" . $a['idcpmk'] . "'")->getResult();
                $statuspengajuan = "";
                if ($cekstatus2 != null) {
                    foreach ($cekstatus2 as $row) {

                        $statuspengajuan = $row->statusklaim;
                    }
                }

                // $cekstatuspengajuan = $this->cekstatusklaim($idklaim);
                if ($cekstatus2 != 2) {
                    $dataMKHeader = [
                        "idklaim" => $idklaim,
                        "ta_akademik" => $ta_akademik,
                        "no_peserta" => $noregis,
                        "kode_prodi" => $kodeprodi,
                        "desk" => $a['desk'],
                        "kode_matakuliah" => $a['kdmk'],
                        "nama_matakuliah" => $a['nmmk'],
                        "sks" => $a['sks'],
                        "tglbuat" => $now,
                        "tglubah" => $now,

                    ];
                    $dataMKdetail = [
                        "idklaim" => $idklaim,
                        "idcpmk" => $a['idcpmk'],
                        "cpmk" => $a['cpmk'],
                        "klaim" => $a['nilai'],
                        "statusklaim" => $status,
                        "tglbuat" => $now,
                        "tglubah" => $now,

                    ];
                    $insertMkhdetail = $BuilderMkDetail->insert($dataMKdetail);

                    if ($idklaim1 != $idklaim) {
                        $insertMkheader = $BuilderMkHeader->insert($dataMKHeader);
                        $idklaim1 = $idklaim;

                        $dataRef = [
                            "idklaim" => $idklaim,
                            // "idcpmk" => $a['idcpmk'],
                            // "kode_matakuliah" => $a['kdmk'],
                            "no_dokumen" => json_encode($a['ref']),
                            "tglbuat" => $now,
                            "tglubah" => $now,


                        ];
                        $insertRefKlaim = $BuilderRefKlaim->insert($dataRef);
                    }
                } else {
                    echo "Setelah Melakukan Pengajuan anda tidak bisa menambah klaim matakuliah lagi.";
                    $db->transRollback();
                    $klaimstatus = false;
                    break;
                }
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



    public function batalklaim($idklaim)
    {
        $db      = \Config\Database::connect();
        $BuilderMkHeader = $db->table("mk_klaim_header");
        $BuilderMkDetail = $db->table("mk_klaim_detail");
        $BuilderRefKlaim = $db->table("ref_klaim");
        // $ta_akademik = $this->getTa_akademik();
        $db->transStart();

        $hapusMkheader = $BuilderMkHeader->where("idklaim", $idklaim)->delete();
        $hapusMkhdetail = $BuilderMkDetail->where("idklaim", $idklaim)->delete();
        $hapusRefKlaim = $BuilderRefKlaim->where("idklaim", $idklaim)->delete();
        if ($db->transStatus() === false) {
            $db->transRollback();
            echo "Gagal Membatalkan Klaim Matakuliah";
        } else {
            $db->transCommit();
            echo "Sukses Membatalkan Klaim Matakuliah";
        }
    }

    public function cekstatuspengajuan($noregis)
    {
        $db      = \Config\Database::connect();
        $noregis = session()->get("noregis");
        $Result = $db->query("SELECT
                                    * from  mk_klaim_detail 
                                WHERE
                                    mid(mk_klaim_detail.idklaim,6,10) = '$noregis' and mk_klaim_detail.statusklaim='2'")->getResultArray();

        return $Result;
    }
    public function getKlaimMk_mahasiswaAll()
    {
        $db      = \Config\Database::connect();
        $noregis = session()->get("noregis");
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
                                    ref_klaim.no_dokumen

                                FROM
                                    mk_klaim_header
                                left join mk_klaim_detail on mk_klaim_header.idklaim=mk_klaim_detail.idklaim 
                                LEFT JOIN ref_klaim on mk_klaim_header.idklaim=ref_klaim.idklaim  
                                WHERE
                                    mk_klaim_header.no_peserta = '$noregis'")->getResultArray();

        return $Result;
    }
    public function getKlaimMk_mahasiswa($kdmk)
    {
        $db      = \Config\Database::connect();
        $noregis = session()->get("noregis");
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
                                    ref_klaim.no_dokumen

                                FROM
                                    mk_klaim_header
                                left join mk_klaim_detail on mk_klaim_header.idklaim=mk_klaim_detail.idklaim 
                                LEFT JOIN ref_klaim on mk_klaim_header.idklaim=ref_klaim.idklaim  
                                WHERE
                                    mk_klaim_header.no_peserta = '$noregis'
                                    and mk_klaim_header.kode_matakuliah='$kdmk'")->getResultArray();

        return $Result;
    }

    public function getKlaimMk_mahasiswaPerId($idklaim)
    {
        $db      = \Config\Database::connect();
        $noregis = session()->get("noregis");
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
                                    ref_klaim.no_dokumen

                                FROM
                                    mk_klaim_header
                                left join mk_klaim_detail on mk_klaim_header.idklaim=mk_klaim_detail.idklaim 
                                LEFT JOIN ref_klaim on mk_klaim_header.idklaim=ref_klaim.idklaim  
                                WHERE
                                    mk_klaim_header.no_peserta = '$noregis'
                                    and mk_klaim_header.idklaim='$idklaim'
                                    ")->getResultArray();

        return $Result;
    }

    public function cekstatusmk($idklaim)
    {
        $modelMkDetail = new ModelKlaimMkDetail();
        $result = $modelMkDetail->where("idklaim", $idklaim)->findAll();
        $status = 1;
        if ($result != null) {
            foreach ($result as $a) {
                if ($a['statusklaim'] == 2) {
                    $status = 2;
                } else if ($a['statusklaim'] == 3) {
                    $status = 3;
                }
            }
        }
        return $status;
    }
    public function cekstatusklaim($idklaim)
    {
        $db      = \Config\Database::connect();
        $result = $db->query("select * from mk_klaim_detail where idklaim = '$idklaim' group by mk_klaim_detail.idklaim")->getResult();
        $status = 1;
        if ($result != null) {
            foreach ($result as $a) {
                if ($a->statusklaim == 2) {
                    $status = 2;
                } else if ($a->statusklaim == 3) {
                    $status = 3;
                }
            }
        }
        return $status;
    }
    public function Cekpengajuanall($noregis)
    {
        $db      = \Config\Database::connect();
        $result = $db->query("select * from mk_klaim_detail where mid(idklaim,6,10) = '$noregis' group by mk_klaim_detail.idklaim")->getResult();
        $status = 1;
        if ($result != null) {
            foreach ($result as $a) {
                if ($a->statusklaim == 2) {
                    $status = 2;
                } else if ($a->statusklaim == 3) {
                    $status = 3;
                }
            }
        }
        return $status;
    }

    public function CekMatakuliah($kdmatakuliah)
    {
        $modelMkHeader = new ModelKlaimMkHeader();
        $result = $modelMkHeader->where("kode_matakuliah", $kdmatakuliah)->findAll();
        return $result;
    }
}
