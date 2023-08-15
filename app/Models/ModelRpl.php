<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelRpl extends Model
{
    protected $table      = 'master_rpl';
    protected $allowedFields = ['kode_prodi', 'jenis_rpl'];
    // protected $primaryKey = 'id';
    protected $validationRules = [
        'kode_prodi' => 'required',
        'jenis_rpl' => 'required',

    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getSetupRPL()
    {
        $db = \Config\Database::connect();
        $data = $db->query("SELECT
                                prodi.kode_prodi,
                                prodi.nama_prodi,
                            SUM(IF(
                                master_rpl.jenis_rpl = 1,
                                1,
                            0
                            )) AS A1,
                            SUM(IF (
                                master_rpl.jenis_rpl = 2,
                                1,
                            0
                            )) AS A2,
                            SUM(IF (
                                master_rpl.jenis_rpl = 3,
                                1,
                                0
                            )) AS A3
                            FROM
                                prodi 
                                left join 
                                master_rpl on master_rpl.kode_prodi= prodi.kode_prodi
                            GROUP BY prodi.kode_prodi
                            
                            ")->getResult();
        return $data;
    }

    public function updatedata($data)
    {
        $db = \Config\Database::connect();
        $modelRPl = new ModelRpl();

        $data = json_decode($data, false);
        $tempdata = '';
        foreach ($data as $row) {
            $tempdata .= "(" . $row->kode_prodi . "," . $row->jenis_rpl . "), ";
        }

        $tempdata = substr($tempdata, 0, -2);

        $queryinsert = "insert into master_rpl values " . $tempdata;

        $db->transStart();
        $result = $db->query("delete from master_rpl");
        $result2 = $db->query($queryinsert);
        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $hasil = [
                'status' => 0,
                'message' => 'Gagal Mengupdate Data !'
            ];
        } else {
            $this->db->transCommit();
            $hasil = [
                'status' => 1,
                'message' => 'Berhasil Mengupdate Data !'
            ];
        }

        return $hasil;
    }
}
