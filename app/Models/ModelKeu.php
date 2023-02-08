<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKeu extends Model
{
    protected $table      = 'tb_valid_keu';
    protected $primaryKey = 'no_peserta';

    protected $returnType     = 'array';


    protected $allowedFields = [
        "ta_akademik",
        "no_peserta",
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
        "no_peserta" => 'required|is_unique[tb_valid_keu.no_peserta]',
        "id_pengguna" => 'required',

    ];
    protected $validationMessages = [
        'idcpmk' => [
            'is_unique' => 'Sorry. Nomor peserta sudah digunakan.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function cekvalidasi($noregis)
    {
        $db = \Config\Database::connect();
        $result = $db->query("select * from tb_valid_keu where no_peserta='$noregis'")->getResult();
        return $result;
    }
    public function setvalid($noregis)
    {
        $db = \Config\Database::connect();
        $result = $db->query("update reg_peserta set validasi_keu=0 where no_registrasi='$noregis'");
        return $result;
    }
    public function setunvalid($noregis)
    {
        $db = \Config\Database::connect();
        $result = $db->query("update reg_peserta set validasi_keu=1 where no_registrasi='$noregis'");
        return $result;
    }
}
