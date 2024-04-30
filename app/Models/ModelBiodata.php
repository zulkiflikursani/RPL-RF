<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBiodata extends Model
{
    protected $table      = 'bio_peserta';
    protected $primaryKey = 'no_peserta';

    protected $returnType     = 'array';


    protected $allowedFields = ['ta_akademik', 'no_peserta', 'nama', 'alamat', 'kotkab', 'propinsi', 'instansi_asal', 'didikakhir', 'nohape', 'email', 'kode_prodi',  'didikakhir', 'jenis_rpl', 'kode_konsentrasi', 'validasi_regis_prodi', 'dodi'];

    protected $validationRules = [
        'ta_akademik'     => 'required',
        'no_peserta'     => 'required',
        'nama'     => 'required',
        'alamat'     => 'required',
        'kotkab'     => 'required',
        'didikakhir' => 'required',
        'propinsi'     => 'required',
        'instansi_asal'     => 'required',
        'nohape'     => 'required',
        'email'        => 'required|valid_email|is_unique[bio_peserta.email]',
        'kode_prodi'        => 'required',
        'kode_konsentrasi' => 'required',
        'didikakhir'        => 'required',
        'jenis_rpl'        => 'required',
        'validasi_regis_prodi' => 'required',
        'dodi' => 'required'

    ];
    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Sorry. Email sudah digunakan. Silahkan gunakan email yang lain.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // public function update_by_noregis($data, $noregis)
    // {
    //     // $Modal = new ModelBiodata();

    // }
    public function getKlaimMhs($ta_akademik)
    {
        if (session()->get('sttpengguna') == 1) {
            $db = \Config\Database::connect();
            $dataMahasiswa = $db->query("SELECT 
            mk_klaim_detailx.idklaim,
            bio_peserta.no_peserta,
            bio_peserta.nama,
            prodi.nama_prodi
        FROM
            (
            (SELECT 
                mk_klaim_detail.idklaim, mk_klaim_detail.statusklaim
            FROM
                mk_klaim_detail
            WHERE
                (LEFT(mk_klaim_detail.idklaim, 5) = '$ta_akademik')
                    AND (mk_klaim_detail.statusklaim = 2)
            ) 
            UNION 
            (
            SELECT 
                CONCAT(dok_a1.ta_akademik, dok_a1.no_registrasi) AS idklaim,
                    dok_a1.status
            FROM
                dok_a1
            WHERE
                dok_a1.ta_akademik = '$ta_akademik'
                    AND dok_a1.status = 0
            )
            ) mk_klaim_detailx
                LEFT JOIN
            mk_klaim_asessor ON MID(mk_klaim_detailx.idklaim, 6, 10) = mk_klaim_asessor.no_peserta
                LEFT JOIN
            bio_peserta ON MID(mk_klaim_detailx.idklaim, 6, 10) = bio_peserta.no_peserta
                LEFT JOIN
            prodi ON bio_peserta.kode_prodi = prodi.kode_prodi
        WHERE
            mk_klaim_detailx.statusklaim IS NOT NULL
                AND mk_klaim_asessor.idklaim IS NULL
        GROUP BY MID(mk_klaim_detailx.idklaim, 6, 10)")->getResult();

            return $dataMahasiswa;
        }
    }
}
