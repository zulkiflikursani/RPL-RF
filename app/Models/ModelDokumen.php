<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDokumen extends Model
{
    protected $table      = 'dok_portofolio';
    protected $primaryKey = 'no_dokumen';

    protected $returnType     = 'array';


    protected $allowedFields = ['ta_akademik', 'no_peserta', 'jenis_dokumen', 'no_dokumen', 'nmfile', 'nmfile_asli', 'lokasi_file', 'url', 'tglbuat', 'tglubah'];

    protected $useTimestamps = TRUE;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tglbuat';
    protected $updatedField  = 'tglubah';
    protected $validationRules = [
        'ta_akademik'     => 'required',
        'no_peserta'     => 'required',
        'no_dokumen'     => 'required|is_unique[dok_portofolio.no_dokumen]',
        'jenis_dokumen'     => 'required',
        'nmfile'     => 'required',
        'nmfile_asli'     => 'required',
        'lokasi_file'     => 'required',
        'url'     => 'required',


    ];
    protected $validationMessages = [
        'no_dokumen' => [
            'is_unique' => 'Sorry no dokumen sudah digunakan.Silahkan gunakan nomor dokumen yang lain.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // public function update_by_noregis($data, $noregis)
    // {
    //     // $Modal = new ModelBiodata();

    // }
    public function getDataBynoregis()
    {
        $noregis = session()->get('noregis');
        $db      = \Config\Database::connect();
        $noregis = session()->get("noregis");
        $Result = $db->query("SELECT
        dok_portofolio.ta_akademik,
        dok_portofolio.no_peserta,
        dok_portofolio.jenis_dokumen,
        dok_portofolio.no_dokumen,
        dok_portofolio.nmfile,
        dok_portofolio.lokasi_file,
        dok_portofolio.nmfile_asli,
        dok_portofolio.url,
        dok_portofolio.tglbuat,
        dok_portofolio.tglubah,
        tb_jenis_file.nama_jenis
        FROM
        dok_portofolio
        LEFT JOIN tb_jenis_file ON dok_portofolio.jenis_dokumen = tb_jenis_file.kd_jenis
        
        where no_peserta = '$noregis'")->getResultArray();

        return $Result;
    }
}
