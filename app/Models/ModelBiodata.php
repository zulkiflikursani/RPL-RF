<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBiodata extends Model
{
    protected $table      = 'bio_peserta';
    protected $primaryKey = 'no_peserta';

    protected $returnType     = 'array';


    protected $allowedFields = ['ta_akademik', 'no_peserta', 'nama', 'alamat', 'kotkab', 'propinsi', 'instansi_asal', 'didikakhir', 'nohape', 'email', 'kode_prodi',  'didikakhir', 'jenis_rpl'];

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
        'didikakhir'        => 'required',
        'jenis_rpl'        => 'required',

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
            $dataMahasiswa = $db->query("SELECT mk_klaim_detailx.idklaim, bio_peserta.no_peserta, bio_peserta.nama, prodi.nama_prodi FROM (SELECT mk_klaim_detail.idklaim,mk_klaim_detail.statusklaim from mk_klaim_detail where (LEFT(mk_klaim_detail.idklaim,5)='$ta_akademik') and (mk_klaim_detail.statusklaim=2)) mk_klaim_detailx left JOIN mk_klaim_asessor ON mid(mk_klaim_detailx.idklaim,6,10)  = mk_klaim_asessor.no_peserta left JOIN bio_peserta ON mid(mk_klaim_detailx.idklaim,6,10)  = bio_peserta.no_peserta left JOIN prodi on bio_peserta.kode_prodi=prodi.kode_prodi where mk_klaim_detailx.statusklaim is not null and mk_klaim_asessor.idklaim is null group by mid(mk_klaim_detailx.idklaim,6,10)")->getResult();

            return $dataMahasiswa;
        }
    }
}