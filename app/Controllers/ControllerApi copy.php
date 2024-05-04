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

        $this->request = service('request');
        $db      = \Config\Database::connect();
        $ModalRegisrasi = new ModelRegistrasi();


        if ($this->request) {
            // Decode the JSON data
            $json = file_get_contents('php://input');
            // $data = json_encode($json); // true to decode as associative array
            $data = json_decode($json, true);

            // Check if decoding was successful
            if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
                // Error decoding JSON
                http_response_code(400); // Bad Request
                echo json_encode(array("error" => "Invalid JSON data"));
                exit;
            }

            // Access the decoded data
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
            $noregis = $ta . "-" . $nolari;
            $nama = $data['nama'];
            $email = $data['email'];
            $no_peserta = $data['no_peserta'];
            $data['no_peserta'] = $noregis;
            $no_tes_simba = $data['no_tes_simba'];

            $link = base_url("Login");


            if ($json) {
                $db->transStart();
                $modelTsingkron = new ModelTabelSingkron();
                $datasingkron = [
                    "no_peserta" => $no_peserta,
                    "no_tes_simba" => $no_tes_simba,
                ];
                $result = $ModalRegisrasi->insert($data);

                if ($result === false) {
                    $db->transRollback();
                    return $this->respond([
                        'statusCode' => 401,
                        'message'    => $ModalRegisrasi->errors(),
                    ], 201);
                } else {
                    $insertTSingkron = $modelTsingkron->insert($datasingkron);
                    if ($insertTSingkron === false) {
                        $db->transRollback();
                        return $this->respond([
                            'statusCode' => 401,
                            'message'    => $modelTsingkron->errors(),
                        ], 201);
                    } else {
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
                            $db->transCommit();
                            return $this->respond([
                                'statusCode' => 201,
                                'message'    =>  "Berhasil Menyimpan Data",
                            ], 201);
                        }
                    }
                }
            } else {
                $db->transCommit();
                return $this->respond([
                    'statusCode' => 401,
                    'message'    =>  "Invalid JSON",
                ], 201);
            }
        }
    }
}
