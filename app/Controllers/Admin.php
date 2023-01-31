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
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
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
            $datasudahvalidprodi = $modelPeserta->getDataPesertaAsessorSudahValidProdiByAsessor(session()->get('id'), session()->get('kode_prodi'), $ta_akademik);
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPesertaBelumValid' => $databelumvalid,
                'dataPesertaSudahValid' => $datasudahvalid,
                'dataPesertaSudahValidProdi' => $datasudahvalidprodi,
            ];

            return view('Admin/rpl-home-asessor', $data);
        } else if (session()->get('sttpengguna') == 3) {
            $modelPeserta = new ModelPesertaAsessor();
            $ta_akademik = $this->getTa_akademik();

            $databelumvalidprodi = $modelPeserta->getDataPesertaBelumValidProdi(session()->get('id'), session()->get('kode_prodi'), $ta_akademik);
            $datasudahvalid = $modelPeserta->getDataPesertaAsessorSudahValidProdi(session()->get('id'), session()->get('kode_prodi'), $ta_akademik);
            $datasudahvaliddekan = $modelPeserta->getDataPesertaAsessorSudahValidDekanPerprodi(session()->get('id'), session()->get('id'), session()->get('kode_prodi'), $ta_akademik);
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Prodi', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPesertaBelumValid' => $databelumvalidprodi,
                'dataPesertaSudahValid' => $datasudahvalid,
                'dataPesertaSudahValidDekan' => $datasudahvaliddekan,
            ];

            return view('Admin/rpl-home-prodi', $data);
        }
    }
    public function resetPassword()
    {
        if (session()->get('sttpengguna') != 1) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            helper('text');

            $modelPengguna = new ModelPengguna();
            $email = $db->escapeString($this->request->getPost("eemail"));
            $password1 =  random_string('alnum', 6);
            $password = password_hash($password1, PASSWORD_BCRYPT);

            $data1 = [
                "ktkunci" => $password,
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
                $message = "Berhasil Mereset Password.<br>
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
                        'status' => true
                    ];

                    return view('Admin/rpl-data-admin', $data);
                }
            }
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

    public function getdatamahsiswaBelumPunyaAsessor()
    {
        if (!session()->get('sttpengguna') && session()->get("sttpengguna") != 1) {
            return redirect()->to('/logout');
            // echo "test";
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            helper('text');

            $modelPeserta = new ModelPesertaAsessor();
            $kode_prodi = $db->escapeString($this->request->getPost("kode_prodi"));
            $ta_akademik = $this->getTa_akademik();
            $result = $modelPeserta->getdataPesertaBelumPunyaAsessorByProdi($kode_prodi, $ta_akademik);
            echo json_encode($result, false);
        }
    }
    public function simpanpesertaasessor()
    {
        if (!session()->get('sttpengguna') && session()->get("sttpengguna") != 1) {
            return redirect()->to('/logout');
            // echo "test";
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();

            $modelPeserta = new ModelPesertaAsessor();
            $no_peserta = $db->escapeString($this->request->getPost("noregis"));
            $no_asessor = $db->escapeString($this->request->getPost("noasessor"));
            $ta_akademik = $this->getTa_akademik();
            $data1 = [
                "ta_akademik" => $ta_akademik,
                "no_peserta" => $no_peserta,
                "no_asessor" => $no_asessor,
                "id_pengguna" => session()->get('id'),
            ];
            $result = $modelPeserta->insert($data1);
            if ($result === false) {
                // echo $modelPeserta->error();

                $modelPengguna = new ModelPengguna();

                $dataAsessor = $modelPengguna->where("sttpengguna", 2)->findAll();

                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'Asessor RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                    'ta_akademik' => $ta_akademik,
                    'dataerror' => $modelPeserta->errors(),
                    'dataAsessor' => $dataAsessor,
                ];

                return view('Admin/rpl-data-asessor', $data);
            } else {
                $modelPengguna = new ModelPengguna();

                $dataAsessor = $modelPengguna->where("sttpengguna", 2)->findAll();

                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'Asessor RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                    'ta_akademik' => $ta_akademik,
                    'status' => true,
                    'dataAsessor' => $dataAsessor,
                ];

                return view('Admin/rpl-data-asessor', $data);
            }
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
    public function getasessorbynoregis($noregis)
    {
        $modelPeserta = new ModelPesertaAsessor();
        $data = $modelPeserta->where('no_peserta', $noregis)->findAll();
        return $data[0]['no_asessor'];
    }
    public function tanggapanAsessor($noregis)
    {
        if (!session()->get('sttpengguna') || session()->get('sttpengguna') != 2) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $noregis = $db->escapeString($noregis);
            $asessor = $this->getasessorbynoregis($noregis);
            if ($asessor == session()->get('id')) {


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
            } else {
                return redirect()->to(base_url('Admin'));
            }
        }
    }

    public function validprodi($noregis, $status = 1)
    {
        if (!session()->get('sttpengguna') || session()->get('sttpengguna') != 3) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $noregis = $db->escapeString($noregis);
            $kode_prodi = $this->getKodeProdiBy($noregis);
            $statusMessage = '';
            if ($status == 2) {
                $statusMessage = "Peserta Berhasil Divalidasi";
            } else  if ($status == 3) {
                $statusMessage = "Peserta Gagal Divalidasi";
            } else  if ($status == 4) {
                $statusMessage = "Peserta Sudah Divalidasi";
            } else  if ($status == 5) {
                $statusMessage = "Peserta Berhasil Diunvalidasi";
            } else  if ($status == 6) {
                $statusMessage = "Peserta Gagal Diunvalidasi";
            } else  if ($status == 7) {
                $statusMessage = "Peserta Sudah Diunvalidasi";
            }
            if ($kode_prodi == session()->get('kode_prodi')) {
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
                    'status' => $status,
                    'dataKlaimMhs' => $dataassementmandiri,
                    'validstatus' => $statusMessage

                ];
                return view('Admin/rpl-validasi-prodi', $data);
            } else {
                return redirect()->to(base_url('Admin'));
            }
        }
    }

    public function validasiprodi()
    {
        if (!session()->get('sttpengguna') || session()->get('sttpengguna') != 3) {
            return redirect()->to('/logout');
        } else {
            $db      = \Config\Database::connect();
            $this->request = service('request');
            $noregis = $db->escapeString($this->request->getPost("noregis"));

            $modelMkProdi = new ModelKlaimProdi();
            $cekpeserta = $modelMkProdi->chekstauspeserta($noregis);
            if ($cekpeserta != null) {
                echo $this->validprodi($noregis, 4);
            } else {
                $validprodi = $modelMkProdi->validprodi($noregis, session()->get("id"));
                if ($validprodi === false) {
                    echo $this->validprodi($noregis, 3);
                } else {
                    echo $this->validprodi($noregis, 2);
                }
            }
        }
    }

    public function unvalidasiprodi()
    {
        if (!session()->get('sttpengguna') || session()->get('sttpengguna') != 3) {
            return redirect()->to('/logout');
        } else {
            $db      = \Config\Database::connect();
            $this->request = service('request');
            $noregis = $db->escapeString($this->request->getPost("noregis"));

            $modelMkProdi = new ModelKlaimProdi();
            $cekpeserta = $modelMkProdi->chekstauspeserta($noregis);
            if ($cekpeserta != null) {
                $unvalidprodi = $modelMkProdi->unvalidprodi($noregis, session()->get("id"));
                if ($unvalidprodi === false) {
                    echo $this->validprodi($noregis, 6);
                } else {
                    echo $this->validprodi($noregis, 5);
                }
            } else {
                echo $this->validprodi($noregis, 7);
            }
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
    public function getKodeProdiBy($noregis)
    {
        $db      = \Config\Database::connect();
        $result = $db->query("select kode_prodi from bio_peserta where no_peserta ='$noregis'")->getRow();

        return $result->kode_prodi;
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