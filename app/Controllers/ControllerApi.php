<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ModelRegistrasi;
use App\Models\ModelTabelSingkron;

class ControllerApi extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        echo "Hello Api";
    }

    public function getTa_akademik()
    {
        $db      = \Config\Database::connect();
        $result = $db->query("select * from tb_ta_akademik");
        if ($result->getResult() != null) {
            foreach ($result->getResult() as $a) {
                $ta_akademik = $a->ta_akademik;
            }
        } else {
            return false;
        }
        return $ta_akademik;
    }

    public function create()
    {
        $db      = \Config\Database::connect();
        $model = new ModelRegistrasi();
        $ta = $this->getTa_akademik();
        $lastnolari = $db->query("select max(right(no_peserta,4)) as nolari from bio_peserta where left(no_peserta,5)='$ta'")->getRow();
        if ($lastnolari->nolari != null) {
            $urutan = floatval($lastnolari->nolari) + 1;
            if ($urutan < 10) {
                $nolari = "000" . $urutan;
            } else if ($urutan < 100) {
                $nolari = "00" . $urutan;
            } else if ($urutan < 1000) {
                $nolari = "0" . $urutan;
            } else if ($urutan < 10000) {
                $nolari = $urutan;
            }
        } else {
            $nolari = "0001";
        };
        $data = [
            'ta_akademik' => $this->getTa_akademik(),
            'no_peserta'  => $ta . "-" . $nolari,
            'nama' => $this->request->getVar("nama"),
            'alamat' => $this->request->getVar("alamat"),
            'kotkab' => $this->request->getVar("kab"),
            'propinsi' => $this->request->getVar("provinsi"),
            'instansi_asal' => $this->request->getVar("instansi"),
            'didikakhir' => $this->request->getVar("pendidikan"),
            'nohape' => $this->request->getVar("nohp"),
            'email' => $this->request->getVar("email"),
            'jenis_rpl' => $this->request->getVar("jenis_rpl"),
            'kode_prodi' => $this->request->getVar("prodi"),
            'kode_konsentrasi' => NULL,
            'validasi_keu' => 0,
            'validasi_regis_prodi' => 0,
            'ktkunci' =>  $this->request->getVar("password"),
            'tlahir' => $this->request->getVar("tlahir"),
            'ttl' => $this->request->getVar("ttl"),
            'nik' => $this->request->getVar("nik"),
            'ibu_kandung' => $this->request->getVar("ibukandung"),
            'dodi' => 0,
            'no_tes_simba' => $this->request->getVar("no_tes_simba")

        ];

        $link = base_url("Login");
        $no_peserta = $ta . "-" . $nolari;
        $email = $this->request->getVar("email");
        $insert = $model->insert($data);
        if ($insert) {
            $message = "Terima Kasih telah melakukan pendaftaran pada Program RPL Unifa  <br>
            Berikut ini user untuk login ke Sistem RPL unifa <br>
            No. Reg	: " . $no_peserta . "<br>
            User 	: " . $email . "<br>
            Pass 	: Sama dengan password simba<br>
            Silahkan Login di " . $link . " <br>
            Kontak Keuangan 0853-3333-4681 <br>
            Terima kasih";
            $emailgo = \Config\Services::email();
            $emailgo->setTo($email);
            $emailgo->setFrom('rpl.unifa.2023@gmail.com', 'Admin Program RPL Unifa');
            $emailgo->setSubject('Registrasi RPL Unifa | Password Login');
            $emailgo->setMessage($message); //your message here
            if (!$emailgo->send()) {
                return $this->respond([
                    'statusCode' => 401,
                    'message'    =>  $emailgo->printDebugger(['headers']),
                ], 401);
            } else {

                return $this->respond([
                    'statusCode' => 201,
                    'message'    =>  "Berhasil Menyimpan Data",
                ], 201);
            }
        } else {
            return $this->respond([
                'statusCode' => 401,
                'message'    => 'fail',
            ], 401);
        }
    }
}
