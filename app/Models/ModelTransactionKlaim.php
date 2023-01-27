<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransactionKlaim extends Model
{
    public function simpanklaim($formdata, $kodeprodi, $ta_akademik)
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
            // $kdmk = $a['kdmk'];
            $dataMKHeader = [
                "idklaim" => $idklaim,
                "ta_akademik" => $ta_akademik,
                "no_peserta" => $noregis,
                "kode_prodi" => $kodeprodi,
                "kode_matakuliah" => $a['kdmk'],
                "nama_matakuliah" => $a['nmmk'],
                "sks" => $a['sks'],
            ];
            $dataMKdetail = [
                "idklaim" => $idklaim,
                "idcpmk" => $a['idcpmk'],
                "cpmk" => $a['cpmk'],
                "klaim" => $a['nilai'],
                "statusklaim" => 1,
            ];
            if ($idklaim1 != $idklaim) {
                $insertMkheader = $BuilderMkHeader->insert($dataMKHeader);
                $idklaim1 = $idklaim;
            }
            $insertMkhdetail = $BuilderMkDetail->insert($dataMKdetail);
            foreach ($a['ref'] as $ref) {
                $dataRef = [
                    "idklaim" => $idklaim,
                    "idcpmk" => $a['idcpmk'],
                    // "kode_matakuliah" => $a['kdmk'],
                    "no_dokumen" => $ref,

                ];
                $insertRefKlaim = $BuilderRefKlaim->insert($dataRef);
            }
        }
        if ($db->transStatus() === false) {
            $db->transRollback();
            echo "gagal";
        } else {
            $db->transCommit();
            echo "sukses";
        }
    }

    public function getKlaimMk_mahasiswa()
    {
        $db      = \Config\Database::connect();
        $noregis = session()->get("noregis");
        $Result = $db->query("SELECT
                                    *
                                FROM
                                    mk_klaim_header
                                left join mk_klaim_detail on mk_klaim_header.idklaim=mk_klaim_detail.idklaim 
                                LEFT JOIN ref_klaim on mk_klaim_header.idklaim=ref_klaim.idklaim  and mk_klaim_detail.idcpmk=ref_klaim.idcpmk
                                WHERE
                                    mk_klaim_header.no_peserta = '$noregis'")->getResultArray();

        return $Result;
    }
}