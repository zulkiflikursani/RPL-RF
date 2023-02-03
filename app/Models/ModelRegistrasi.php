<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelRegistrasi extends Model
{
    protected $table      = 'reg_peserta';
    protected $primaryKey = 'no_registrasi';

    protected $returnType     = 'array';


    protected $allowedFields = ['ta_akademik', 'no_registrasi', 'nama', 'alamat', 'kotkab', 'propinsi', 'instansi_asal', 'nohape', 'email', 'kode_prodi', 'validasi_keu', 'ktkunci'];

    protected $validationRules = [
        'ta_akademik'     => 'required',
        'no_registrasi'     => 'required',
        'nama'     => 'required',
        'alamat'     => 'required',
        'kotkab'     => 'required',
        'propinsi'     => 'required',
        'instansi_asal'     => 'required',
        'nohape'     => 'required',
        'email'        => 'required|valid_email|is_unique[reg_peserta.email]|is_unique[tb_pengguna.email]',
        'kode_prodi'        => 'required',
        'validasi_keu'        => 'required',
        'ktkunci'        => 'required',
    ];
    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Sorry. Email sudah digunakan. Silahkan gunakan email yang lain.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getvalid()
    {
        $db = \Config\Database::connect();
        $result = $db->query("SELECT
                                tb_valid_keu.no_peserta,
                                reg_peserta.ta_akademik,
                                reg_peserta.no_registrasi,
                                reg_peserta.nama,
                                reg_peserta.alamat,
                                reg_peserta.kotkab,
                                reg_peserta.propinsi,
                                reg_peserta.instansi_asal,
                                reg_peserta.nohape,
                                reg_peserta.email,
                                reg_peserta.kode_prodi,
                                reg_peserta.validasi_keu,
                                reg_peserta.ktkunci
                                FROM
                                reg_peserta
                                LEFT JOIN tb_valid_keu ON reg_peserta.no_registrasi = tb_valid_keu.no_peserta
                                where 
                                tb_valid_keu.no_peserta is not null ")->getResult();
        return $result;
    }
    public function getnonvalid()
    {
        $db = \Config\Database::connect();
        $result = $db->query("SELECT
                                tb_valid_keu.no_peserta,
                                reg_peserta.ta_akademik,
                                reg_peserta.no_registrasi,
                                reg_peserta.nama,
                                reg_peserta.alamat,
                                reg_peserta.kotkab,
                                reg_peserta.propinsi,
                                reg_peserta.instansi_asal,
                                reg_peserta.nohape,
                                reg_peserta.email,
                                reg_peserta.kode_prodi,
                                reg_peserta.validasi_keu,
                                reg_peserta.ktkunci
                                FROM
                                reg_peserta
                                LEFT JOIN tb_valid_keu ON reg_peserta.no_registrasi = tb_valid_keu.no_peserta
                                where 
                                tb_valid_keu.no_peserta is null ")->getResult();
        return $result;
    }
}
