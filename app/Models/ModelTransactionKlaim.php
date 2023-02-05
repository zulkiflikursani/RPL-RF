<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransactionKlaim extends Model
{
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
        foreach ($formdata['jsonObj'] as $a) {
            $idklaim = $ta_akademik . $noregis . $a['kdmk'];
            if ($a['nilai'] == "" || empty($a['ref']) || $a['desk'] == "") {
                $db->transRollback();
                echo "Data Tidak Lengkap";
                break;
            }
            // $kdmk = $a['kdmk'];

            $cekstatus = $this->cekstatusmk($idklaim);
            $cekmk = $this->CekMatakuliah($a['kdmk']);
            if ($cekmk != null) {
                if ($cekstatus == 1) {
                    $dataMKHeader = [
                        "idklaim" => $idklaim,
                        "ta_akademik" => $ta_akademik,
                        "no_peserta" => $noregis,
                        "kode_prodi" => $kodeprodi,
                        "kode_matakuliah" => $a['kdmk'],
                        "nama_matakuliah" => $a['nmmk'],
                        "desk" => $a['desk'],
                        "sks" => $a['sks'],
                    ];
                    $dataMKdetail = [
                        "idklaim" => $idklaim,
                        "idcpmk" => $a['idcpmk'],
                        "cpmk" => $a['cpmk'],
                        "klaim" => $a['nilai'],
                        "statusklaim" => $status,
                    ];
                    if ($idklaim1 != $idklaim) {
                        $hapusMkheader = $BuilderMkHeader->where("idklaim", $idklaim)->delete();
                        $hapusMkhdetail = $BuilderMkDetail->where("idklaim", $idklaim)->delete();
                        $hapusRefKlaim = $BuilderRefKlaim->where("idklaim", $idklaim)->delete();

                        $insertMkheader = $BuilderMkHeader->insert($dataMKHeader);
                        $idklaim1 = $idklaim;
                        // foreach ($a['ref'] as $ref) {
                        $dataRef = [
                            "idklaim" => $idklaim,
                            // "idcpmk" => $a['idcpmk'],
                            // "kode_matakuliah" => $a['kdmk'],
                            "no_dokumen" => json_encode($a['ref']),

                        ];
                        $insertRefKlaim = $BuilderRefKlaim->insert($dataRef);
                    }
                    $insertMkhdetail = $BuilderMkDetail->insert($dataMKdetail);
                } else {
                    echo "Klaim sedang diproses. Silahkan menunggu tanggapan Asessor di menu Respon Asessor";
                }
            } else {
                $dataMKHeader = [
                    "idklaim" => $idklaim,
                    "ta_akademik" => $ta_akademik,
                    "no_peserta" => $noregis,
                    "kode_prodi" => $kodeprodi,
                    "desk" => $a['desk'],
                    "kode_matakuliah" => $a['kdmk'],
                    "nama_matakuliah" => $a['nmmk'],
                    "sks" => $a['sks'],
                ];
                $dataMKdetail = [
                    "idklaim" => $idklaim,
                    "idcpmk" => $a['idcpmk'],
                    "cpmk" => $a['cpmk'],
                    "klaim" => $a['nilai'],
                    "statusklaim" => $status,
                ];
                $insertMkhdetail = $BuilderMkDetail->insert($dataMKdetail);

                if ($idklaim1 != $idklaim) {
                    $insertMkheader = $BuilderMkHeader->insert($dataMKHeader);
                    $idklaim1 = $idklaim;

                    // $object = $a['ref'];
                    // $output = array_map(function ($object) {
                    //     return $object->name;
                    // }, $input);
                    $dataRef = [
                        "idklaim" => $idklaim,
                        // "idcpmk" => $a['idcpmk'],
                        // "kode_matakuliah" => $a['kdmk'],
                        "no_dokumen" => json_encode($a['ref']),
                    ];
                    $insertRefKlaim = $BuilderRefKlaim->insert($dataRef);
                }
            }
        }
        if ($db->transStatus() === false) {
            $db->transRollback();
            echo "Gagal Mengklaim Matakuliah";
        } else {
            $db->transCommit();
            echo "Sukses Mengklaim Matakuliah";
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
