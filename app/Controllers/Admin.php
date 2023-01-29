<?php

namespace App\Controllers;

use App\Models\ModelBiodata;
use App\Models\ModelDokumen;
use App\Models\ModelKlaimAsessor;
use App\Models\ModelKlaimProdi;
use App\Models\ModelPengguna;
use App\Models\ModelPesertaAsessor;
use App\Models\ModelTransactionKlaim;
use App\Models\ModelTransactionKlaimAsessor;

class Admin extends BaseController
{
    protected $helpers = ['url', 'form'];
    public function index()
    {
        if (!session()->get('sttpengguna')) {
            return redirect()->to('/logout');
        } else if (session()->get('sttpengguna') == 1) {
            $modelPengguna = new ModelPesertaAsessor();
            $ta_akademik = $this->getTa_akademik();
            $dataMhs = $modelPengguna->getdataPesertaBelumPunyaAsessor($ta_akademik);
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'Admin RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Admin', 'pagetitle' => 'Dashboards']),
                'dataMhs' => $dataMhs,
                'ta_akademik' => $this->getTa_akademik()
            ];
            return view('Admin/rpl-layouts-horizontal', $data);
        } else if (session()->get('sttpengguna') == 2) {
            $modelPeserta = new ModelPesertaAsessor();
            $ta_akademik = $this->getTa_akademik();
            $databelumvalid = $modelPeserta->getDataPesertaAsessroBelumValid(session()->get('id'), $ta_akademik);
            $datasudahvalid = $modelPeserta->getDataPesertaAsessorSudahValid(session()->get('id'), $ta_akademik);
            $datasudahvalidprodi = $modelPeserta->getDataPesertaAsessorSudahValidProdi(session()->get('id'), $ta_akademik);
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'Asessor RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPesertaBelumValid' => $databelumvalid,
                'dataPesertaSudahValid' => $datasudahvalid,
                'dataPesertaSudahValidProdi' => $datasudahvalidprodi,
            ];

            return view('Admin/rpl-home-asessor', $data);
        }
    }
    public function pengguna()
    {
        if (session()->get('sttpengguna') != 1) {
            return redirect()->to('/logout');
        } else {
            $modelPengguna = new ModelPengguna();
            $dataPengguna = $modelPengguna->findAll();

            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'User RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Admin', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPengguna' => $dataPengguna,
            ];

            return view('Admin/rpl-data-admin', $data);
        }
    }

    public function SimpanPengguna()
    {
        if (session()->get('sttpengguna') != 1) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            helper('text');

            $modelPengguna = new ModelPengguna();
            $nama = $db->escapeString($this->request->getPost("nama"));
            $email = $db->escapeString($this->request->getPost("email"));
            $status = $db->escapeString($this->request->getPost("status"));
            $kode_prodi = $db->escapeString($this->request->getPost("kode_prodi"));
            $password1 =  random_string('alnum', 6);
            $password = password_hash($password1, PASSWORD_BCRYPT);
            $lastidpengguna = $db->query('select idpengguna from tb_pengguna order by idpengguna Desc limit 1')->getRow();
            if ($lastidpengguna == null) {
                $idpengguna = 1;
            } else {
                $idpengguna = floatval($lastidpengguna->idpengguna) + 1;
            }
            if ($status == 1) {
                $statusPengguna = "Admin";
            } else if ($status == 2) {
                $statusPengguna = "Asessor";
            } else if ($status == 3) {
                $statusPengguna = "Prodi";
            } else if ($status == 4) {
                $statusPengguna = "Fakultas";
            } else if ($status == 5) {
                $statusPengguna = "Manajemen";
            }

            $data1 = [
                "idpengguna" => $idpengguna,
                "nmpengguna" => $nama,
                "sttpengguna" => $status,
                "email" => $email,
                "ktkunci" => $password,
                "kode_prodi" => $kode_prodi,
            ];

            $link = base_url("Login");



            $result = $modelPengguna->insert($data1);
            if ($result === false) {
                // $modelPengguna = new ModelPengguna();
                $dataPengguna = $modelPengguna->findAll();
                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'Admin RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
                    'ta_akademik' => $this->getTa_akademik(),
                    'dataPengguna' => $dataPengguna,
                    'dataerror' => $modelPengguna->errors(),
                    'status' => false,

                ];

                return view('Admin/rpl-data-admin', $data);
            } else {
                $message = "Anda terdafrar sebagai " . $statusPengguna . "  <br>
            			Berikut ada user untuk login ke Sistem SILAJU unifa <br>
                        <br>
            			User 	    : " . $email . "<br>
            			Pass 	    : " . $password1 . "<br>
            			<br>
                        Silahkan Login di " . $link . " <br>
            			Terima kasih";
                $emailgo = \Config\Services::email();
                $emailgo->setTo($email);
                $emailgo->setFrom('rpl.unifa.2023@gmail.com', 'Admin Silaju Unifa');
                $emailgo->setSubject('Silaju Unifa | Password Login');
                $emailgo->setMessage($message); //your message here
                $modelPengguna = new ModelPengguna();
                $dataPengguna = $modelPengguna->findAll();

                if (!$emailgo->send()) {
                    $email_status = $emailgo->printDebugger(['headers']);
                    $dataPengguna = $modelPengguna->findAll();
                    $data = [
                        'title_meta' => view('partials/rpl-title-meta', ['title' => 'Admin RPL']),
                        'page_title' => view('partials/rpl-page-title', ['title' => 'Admin', 'pagetitle' => 'Dashboards']),
                        'ta_akademik' => $this->getTa_akademik(),
                        'dataPengguna' => $dataPengguna,
                        'dataerror' => $email_status,
                        'status' => false,

                    ];

                    return view('Admin/rpl-data-admin', $data);
                    // Generate error
                } else {

                    $data = [
                        'title_meta' => view('partials/rpl-title-meta', ['title' => 'Admin RPL']),
                        'page_title' => view('partials/rpl-page-title', ['title' => 'Admin', 'pagetitle' => 'Dashboards']),
                        'ta_akademik' => $this->getTa_akademik(),
                        'dataPengguna' => $dataPengguna,
                        'this' => $this,
                        'status' => true
                    ];

                    return view('Admin/rpl-data-admin', $data);
                }
            }
        }
    }

    public function UpdatePengguna()
    {
        if (session()->get('sttpengguna') != 1) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            helper('text');

            $modelPengguna = new ModelPengguna();
            $nama = $db->escapeString($this->request->getPost("enama"));
            $email = $db->escapeString($this->request->getPost("eemail"));
            $status = $db->escapeString($this->request->getPost("estatus"));
            $kode_prodi = $db->escapeString($this->request->getPost("ekode_prodi"));


            $data1 = [
                "sttpengguna" => $status,
                "kode_prodi" => $kode_prodi,
            ];

            $link = base_url("Login");



            $result = $modelPengguna->update(['email' => $email], $data1);
            if ($result === false) {
                // $modelPengguna = new ModelPengguna();
                $dataPengguna = $modelPengguna->findAll();
                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'Admin RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Admin', 'pagetitle' => 'Dashboards']),
                    'ta_akademik' => $this->getTa_akademik(),
                    'dataPengguna' => $dataPengguna,
                    'dataerror' => $modelPengguna->errors(),
                    'status' => false,

                ];

                return view('Admin/rpl-data-admin', $data);
            } else {
                $dataPengguna = $modelPengguna->findAll();
                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'Admin RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Admin', 'pagetitle' => 'Dashboards']),
                    'ta_akademik' => $this->getTa_akademik(),
                    'dataPengguna' => $dataPengguna,
                    'status' => true
                ];

                return view('Admin/rpl-data-admin', $data);
            }
        }
    }

    public function Asessor()
    {
        $modelPengguna = new ModelPengguna();

        $dataAsessor = $modelPengguna->where("sttpengguna", 2)->findAll();

        $data = [
            'title_meta' => view('partials/rpl-title-meta', ['title' => 'Asessor RPL']),
            'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
            'ta_akademik' => $this->getTa_akademik(),
            'dataAsessor' => $dataAsessor,
        ];

        return view('Admin/rpl-home-asessor', $data);
    }
    public function dataAsessor()
    {
        if (!session()->get('sttpengguna') || session()->get('sttpengguna') == 2) {
            return redirect()->to('/logout');
        } else {

            $modelPengguna = new ModelPengguna();

            $dataAsessor = $modelPengguna->where("sttpengguna", 2)->findAll();

            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'Asessor RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataAsessor' => $dataAsessor,
            ];

            return view('Admin/rpl-data-asessor', $data);
        }
    }

    public function getDataKlaimasessor()
    {
        if (!session()->get('sttpengguna') && !session()->get('noregis')) {
            return redirect()->to('/logout');
            // echo "test";
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            helper('text');

            $modelklaimasessor = new ModelKlaimAsessor();
            $noregis = $db->escapeString($this->request->getPost("noregis"));

            $result = $modelklaimasessor->getDataKlaimAsessor($noregis);
            echo json_encode($result, false);
        }
    }
    public function tanggapanAsessor($noregis)
    {
        if (!session()->get('sttpengguna') || session()->get('sttpengguna') != 2) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $noregis = $db->escapeString($noregis);
            // $noregis = session()->get("noregis");
            $Modaldokumen = new ModelDokumen();
            $ModalBiodata = new ModelBiodata();
            $ModalAssesmentMandiri = new ModelKlaimAsessor();
            $datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
            $databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
            $dataassementmandiri = $ModalAssesmentMandiri->getKlaimMk_mahasiswa($noregis);
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'Asessor RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                'nama_mhs' => $databio[0]['nama'],
                'nm_prodi' => $this->getNamaProdi($databio[0]['kode_prodi']),
                'jenis_rpl' => $databio[0]['jenis_rpl'],
                'noregis' => $noregis,
                'dataKlaimMhs' => $dataassementmandiri,

            ];
            return view('Admin/rpl-assesment-asessor', $data);
        }
    }


    public function klaimMkAsessor()
    {
        $formdata = $this->request->getPost();
        $lastdata = array();
        $noregis = session()->get("noregis");
        $ta_akademik = $this->getTa_akademik();
        $ModalTransactionKlaim = new ModelKlaimAsessor();
        $simpanklaim = $ModalTransactionKlaim->simpanklaimAsessor($formdata, $ta_akademik);
    }

    public function getNamaProdi($kode_prodi)
    {
        $db      = \Config\Database::connect();
        $result = $db->query("select * from prodi where kode_prodi ='$kode_prodi'")->getRow();

        return $result->nama_prodi;
    }
    public function getDataMhsPerAsessor()
    {
        if (!session()->get('sttpengguna')) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $modelPesertaAsessor = new ModelPesertaAsessor();
            $db      = \Config\Database::connect();
            $idpengguna = $db->escapeString($this->request->getPost("idasessor"));
            $ta_akademik = $this->getTa_akademik();
            $datapeserta = $modelPesertaAsessor->getDataPesertaByAsessor($idpengguna, $ta_akademik);
            echo json_encode($datapeserta, false);
        }
    }

    public function getNamaProdiByKode($kode_prodi)
    {
        $db      = \Config\Database::connect();
        $result = $db->query("select * from prodi where kode_prodi ='$kode_prodi'")->getRow();

        return $result->nama_prodi;
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

    public function logout()
    {
        session()->destroy();    //unet current user session 

        helper(['form']);
        $data = [
            'title_meta' => view('partials/rpl-title-meta', ['title' => 'login SILAJU']),
            'page_title' => view('partials/rpl-page-title', ['title' => 'Login', 'pagetitle' => 'Login']),
            'ta_akademik' => $this->getTa_akademik()
        ];
        return view('auth/rpl-auth-login', $data);
    }
}