<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKlaimAsessor extends Model
{
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
        foreach ($formdata['jsonObj'] as $a) {
            $idklaim = $a['idklaim'];
            $noregis = $a['noregis'];
            $kdmk = $a['kdmk'];
            $tanggapan = $a['tanggapan'];
            $nilai = $a['nilai'];
            $kdprodi = $a['kdprodi'];
            $kettanggapan = $a['kettanggapan'];
            $cekmk = $this->CekMatakuliahAsessor($a['idklaim']);
            // print_r($cekmk);
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
                $insertMkhdetail = $BuilderMkKlaim->insert($dataMK);
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

    public function getKlaimMk_mahasiswa($noregis)
    {
        $db      = \Config\Database::connect();
        $Result = $db->query("SELECT
                                    *,(SELECT COUNT(*) FROM ref_klaim as it 
                                WHERE it.idcpmk = mk_klaim_detail.idcpmk) as entry_count
                                FROM
                                    mk_klaim_header
                                left join mk_klaim_detail on mk_klaim_header.idklaim=mk_klaim_detail.idklaim 
                                LEFT JOIN ref_klaim on mk_klaim_header.idklaim=ref_klaim.idklaim  and mk_klaim_detail.idcpmk=ref_klaim.idcpmk 
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
}