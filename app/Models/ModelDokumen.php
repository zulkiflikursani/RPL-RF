<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDokumen extends Model
{
    protected $table      = 'bio_peserta';
    protected $primaryKey = 'no_peserta';

    protected $returnType     = 'array';


    protected $allowedFields = ['ta_akademik', 'no_peserta', 'nama', 'alamat', 'kotkab', 'propinsi', 'instansi_asal', 'nohape', 'email', 'kode_prodi',  'didikakhir', 'jenis_rpl'];

    protected $validationRules = [
        'ta_akademik'     => 'required',
        'no_peserta'     => 'required',
        'nama'     => 'required',
        'alamat'     => 'required',
        'kotkab'     => 'required',
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
}