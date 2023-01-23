<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDokumen extends Model
{
    protected $table      = 'dok_portofolio';
    protected $primaryKey = 'no_dokumen';

    protected $returnType     = 'array';


    protected $allowedFields = ['ta_akademik', 'no_peserta', 'jenis_dokumen', 'no_dokumen', 'nmfile', 'nmfile_asli', 'lokasi_file', 'url', 'tlgbuat', 'tglubah'];

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
}