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
            // print_r($cekmk);
            $cekvalidprodi = $this->cekValidProdi($idklaim);
            if ($cekvalidprodi != null) {
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
                                WHERE it.idcpmk = mk_klaim_detail.idcpmk) as entry_count
                        FROM
                        mk_klaim_header
                        LEFT JOIN mk_klaim_detail ON mk_klaim_header.idklaim = mk_klaim_detail.idklaim
                        LEFT JOIN ref_klaim ON mk_klaim_detail.idklaim = ref_klaim.idklaim AND mk_klaim_detail.idcpmk = ref_klaim.idcpmk
                        LEFT JOIN mk_klaim_asessor ON ref_klaim.idklaim = mk_klaim_asessor.idklaim
                        LEFT JOIN dok_portofolio ON ref_klaim.no_dokumen = dok_portofolio.no_dokumen
                        where mk_klaim_header.no_peserta='$noregis'
                        order by mk_klaim_header.kode_matakuliah, mk_klaim_detail.idcpmk
                        ")->getResult();
        return $result;
    }
}