<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPesertaAsessor extends Model
{
    protected $table      = 'tb_peserta_asessor';
    protected $primaryKey = 'no_peserta';

    protected $returnType     = 'array';
    protected $allowedFields = [
        "ta_akademik",
        "no_peserta",
        "no_asessor",
        "tglbuat",
        "tglubah",
        "id_pengguna",

    ];
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tglbuat';
    protected $updatedField  = 'tglubah';
    protected $validationRules = [
        "ta_akademik" => 'required',
        "no_peserta" => 'required|is_unique[tb_peserta_asessor.no_peserta]',
        "no_asessor" => 'required',
        "id_pengguna" => 'required',
    ];
    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Asessor Peserta sudah ditentukan sebelumnya',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getDataPesertaByAsessor($no_asessor)
    {
        $db = \Config\Database::connect();
        $dataMahasiswa = $db->query("SELECT
                            tb_peserta_asessor.ta_akademik,
                            tb_peserta_asessor.no_peserta,
                            bio_peserta.nama,
                            bio_peserta.kode_prodi,
                            bio_peserta.jenis_rpl,
                            tb_peserta_asessor.no_asessor,
                            tb_pengguna.nmpengguna as nmasessor,
                            tb_pengguna.email as email_asessor
                            FROM
                            tb_peserta_asessor
                            LEFT JOIN bio_peserta ON tb_peserta_asessor.no_peserta = bio_peserta.no_peserta
                            LEFT JOIN tb_pengguna ON tb_peserta_asessor.no_asessor = tb_pengguna.idpengguna
                            WHERE 
                            tb_peserta_asessor.no_asessor='$no_asessor'")->getResult();
        return $dataMahasiswa;
    }

    public function getdataPesertaBelumPunyaAsessor()
    {
        $db = \Config\Database::connect();
        $dataMahasiswa = $db->query("SELECT
                                bio_peserta.no_peserta,
                                bio_peserta.nama,
                                tb_peserta_asessor.no_asessor,
                                bio_peserta.jenis_rpl,
                                bio_peserta.kode_prodi
                                FROM
                                bio_peserta
                                LEFT JOIN tb_peserta_asessor ON bio_peserta.no_peserta = tb_peserta_asessor.no_peserta
                                where
                                tb_peserta_asessor.no_asessor is null")->getResult();
        return $dataMahasiswa;
    }
}