<?php

namespace App\Controllers;

use App\Models\ModelBiodata;
use App\Models\ModelCpmk;
use App\Models\ModelDokumen;
use App\Models\ModelKeu;
use App\Models\ModelKlaimAsessor;
use App\Models\ModelKlaimDekan;
use App\Models\ModelKlaimProdi;
use App\Models\ModelPengguna;
use App\Models\ModelPesertaAsessor;
use App\Models\ModelRegistrasi;
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
            $datasudahvaliddekan = $modelPeserta->getDataPesertaAsessorSudahValidDekanPerprodi(session()->get('id'), session()->get('kode_prodi'), $ta_akademik);
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Prodi', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPesertaBelumValid' => $databelumvalidprodi,
                'dataPesertaSudahValid' => $datasudahvalid,
                'dataPesertaSudahValidDekan' => $datasudahvaliddekan,
            ];

            return view('Admin/rpl-home-prodi', $data);
        } else if (session()->get('sttpengguna') == 4) {
            $modelPeserta = new ModelPesertaAsessor();
            $ta_akademik = $this->getTa_akademik();
            $kode_fakultas = session()->get('kode_fakultas');
            $databelumvalid = $modelPeserta->getDataPesertaAsessorSudahValidProdiDekan(session()->get('id'), $kode_fakultas, $ta_akademik);
            $datasudahvalid = $modelPeserta->getDataPesertaAsessorSudahValidDekan(session()->get('id'), $kode_fakultas, $ta_akademik);

            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Fakultas', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPesertaBelumValid' => $databelumvalid,
                'dataPesertaSudahValid' => $datasudahvalid,

            ];

            return view('Admin/rpl-home-fakultas', $data);
        } else if (session()->get('sttpengguna') == 5) {
            $modelRegister = new ModelRegistrasi();
            $ta_akademik = $this->getTa_akademik();
            $databelumvalidasi = $modelRegister->getNonvalid();
            $datasudahvalidasi = $modelRegister->getvalid();
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Keuangan', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPesertaBelumValid' => $databelumvalidasi,
                'dataPesertaSudahValid' => $datasudahvalidasi,

            ];

            return view('Admin/rpl-home-keu', $data);
        }
    }

    public function resetpassmhs()
    {
        if (session()->get('sttpengguna') != 1) {
            return redirect()->to('/logout');
        } else {
            $modelRegister = new ModelRegistrasi();
            $dataMhs = $modelRegister->findAll();
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Admin', 'pagetitle' => 'Dashboards']),
                'dataMhs' => $dataMhs,
                'ta_akademik' => $this->getTa_akademik()
            ];
            return view('Admin/rpl-data-reg-mhs', $data);
        }
    }
    public function validKeu()
    {
        if (session()->get('sttpengguna') != 5) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            helper('text');

            $modelKeu = new ModelKeu();
            $noregis = $db->escapeString($this->request->getPost("noregis"));

            $data = [
                "ta_akademik" => $this->getTa_akademik(),
                "no_peserta" => $noregis,
                "id_pengguna" => session()->get('id')
            ];

            $result = $modelKeu->insert($data);
            $result2 = $modelKeu->setvalid($noregis);
            if ($result === false || $result2 === false) {
                echo $modelKeu->errors();
            } else {
                echo "Berhasil Memvalidasi Calon Mahasiswa";
            }
        }
    }
    public function unvalidKeu()
    {
        if (session()->get('sttpengguna') != 5) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            helper('text');

            $modelKeu = new ModelKeu();
            $noregis = $db->escapeString($this->request->getPost("noregis"));

            $result = $modelKeu->where("no_peserta", $noregis)->delete();
            $result2 = $modelKeu->setunvalid($noregis);

            if ($result === false || $result2 === false) {
                echo $modelKeu->errors();
            } else {
                echo "Berhasil Membatalkan Validasi Calon Mahasiswa";
            }
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
                Berikut ini user untuk login ke Sistem RPL Unifa <br>
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
    public function resetPasswordMhs()
    {
        if (session()->get('sttpengguna') != 1) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            helper('text');

            $modelPengguna = new ModelRegistrasi();
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
                $modelRegister = new ModelRegistrasi();
                $dataMhs = $modelRegister->findAll();
                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Admin', 'pagetitle' => 'Dashboards']),
                    'dataMhs' => $dataMhs,
                    'dataerror' => $modelPengguna->errors(),
                    'ta_akademik' => $this->getTa_akademik()
                ];
                return view('Admin/rpl-data-reg-mhs', $data);
            } else {
                $message = "Berhasil Mereset Password.<br>
                Berikut ini user untuk login ke Sistem RPL Unifa <br>
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
                    $modelRegister = new ModelRegistrasi();
                    $dataMhs = $modelRegister->findAll();
                    $data = [
                        'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                        'page_title' => view('partials/rpl-page-title', ['title' => 'Admin', 'pagetitle' => 'Dashboards']),
                        'dataMhs' => $dataMhs,
                        'dataerror' => $modelPengguna->errors(),
                        'ta_akademik' => $this->getTa_akademik(),
                        'status' => false,
                    ];
                    return view('Admin/rpl-data-reg-mhs', $data);

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
            $db      = \Config\Database::connect();
            $modelPengguna = new ModelPengguna();
            $dataPengguna = $modelPengguna->findAll();
            $datafakultas = $db->table('fakultas')->select();


            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'User RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Admin', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPengguna' => $dataPengguna,
                'dataFakultas' => $datafakultas,
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
            $kode_fakultas = $db->escapeString($this->request->getPost("kode_fakultas"));
            $password1 =  random_string('alnum', 6);
            $password = password_hash($password1, PASSWORD_BCRYPT);
            $lastidpengguna = $db->query('select max(right(idpengguna,4)) as idpengguna from tb_pengguna')->getRow();

            if ($lastidpengguna->idpengguna != null) {
                $urutan = floatval($lastidpengguna->idpengguna) + 1;
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
                $nolari = "0001	";
            }
            $idpengguna = "P-" . $nolari;
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
                "kode_fakultas" => $kode_fakultas,
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
            			Berikut ini user untuk login ke Sistem RPL unifa <br>
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

    //update pengguna ok
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
            $kode_fakultas = $db->escapeString($this->request->getPost("ekode_fakultas"));


            $data1 = [
                "sttpengguna" => $status,
                "kode_prodi" => $kode_prodi,
                "kode_fakultas" => $kode_fakultas,
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
        if (!session()->get('sttpengguna')) {
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

            return view('Admin/rpl-home-asessor', $data);
        }
    }
    public function inputcpmk()
    {
        if (session()->get('sttpengguna') != 1) {
            return redirect()->to('/logout');
        } else {

            $modelCpmk = new ModelCpmk();
            $programstudi = $modelCpmk->getAllprodi();

            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Matakuliah', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'jenis_prodi' => $programstudi,
                // 'datacpmk' => $dataAsessor,
            ];

            return view('Admin/rpl-input-cpmk', $data);
        }
    }
    public function getcpmk()
    {
        if (!session()->get('sttpengguna')) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $kode_prodi = $db->escapeString($this->request->getPost("prodi"));
            $result = $db->query("SELECT
								matakuliah.*,
								mk_cpmk.idcpmk,
									mk_cpmk.cpmk
									
								FROM
									matakuliah
								left JOIN
									mk_cpmk
								on matakuliah.kode_matakuliah= mk_cpmk.kode_matakuliah and mk_cpmk.kode_prodi='$kode_prodi'
								WHERE
									matakuliah.kode_prodi = '$kode_prodi'
								order by matakuliah.kode_matakuliah")->getResult();

            echo json_encode($result, false);
        }
    }
    public function getMatakuliah()
    {
        if (!session()->get('sttpengguna')) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $kode_prodi = $db->escapeString($this->request->getPost("prodi"));
            $result = $db->query("SELECT * FROM
									matakuliah where
									matakuliah.kode_prodi = '$kode_prodi'
								order by matakuliah.kode_matakuliah")->getResult();

            echo json_encode($result, false);
        }
    }

    public function simpanCpmk()
    {
        if (!session()->get('sttpengguna')) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $kode_prodi = $db->escapeString($this->request->getPost("prodi"));
            $kdmk = $db->escapeString($this->request->getPost("kdmk"));
            $idcpmk = $db->escapeString($this->request->getPost("idcpmk"));
            $cpmk = $db->escapeString($this->request->getPost("cpmk"));
            $data = [
                'kode_prodi' => $kode_prodi,
                'kode_matakuliah' => $kdmk,
                'idcpmk' => $idcpmk,
                'cpmk' => $cpmk

            ];

            $modelCpmk = new ModelCpmk();
            $simpan = $modelCpmk->insert($data);
            if ($simpan === false) {
                echo $modelCpmk->errors();
            } else {
                echo "Berhasil Menambahkan CPMK";
            }
        };
    }

    public function editCpmk()
    {
        if (!session()->get('sttpengguna')) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $kode_prodi = $db->escapeString($this->request->getPost("prodi"));
            $kdmk = $db->escapeString($this->request->getPost("kdmk"));
            $idcpmk = $db->escapeString($this->request->getPost("idcpmk"));
            $cpmk = $db->escapeString($this->request->getPost("cpmk"));

            $modelCpmk = new ModelCpmk();
            $simpan = $modelCpmk->editCpmk($idcpmk, $kode_prodi, $cpmk);
            if ($simpan === false) {
                echo $modelCpmk->errors();
            } else {
                echo "Berhasil Mengedit CPMK";
            }
        };
    }
    public function hapusCpmk()
    {
        if (!session()->get('sttpengguna')) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $kode_prodi = $db->escapeString($this->request->getPost("prodi"));
            $kdmk = $db->escapeString($this->request->getPost("kdmk"));
            $idcpmk = $db->escapeString($this->request->getPost("idcpmk"));
            $cpmk = $db->escapeString($this->request->getPost("cpmk"));

            $modelCpmk = new ModelCpmk();
            $simpan = $modelCpmk->hapusCpmk($idcpmk, $kode_prodi, $cpmk);
            if ($simpan === false) {
                echo $modelCpmk->errors();
            } else {
                echo "Berhasil MEnghapus CPMK";
            }
        };
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
                $statusMessage = "Peserta Sudah Divalidasi";
            } else {
                $validprodi = $modelMkProdi->validprodi($noregis, session()->get("id"));
                if ($validprodi === false) {
                    // echo $this->validprodi($noregis, 3);
                    $statusMessage = "Peserta Gagal Divalidasi";
                } else {
                    $statusMessage = "Peserta Berhasil Divalidasi";
                    // echo $this->validprodi($noregis, 2);
                }
            }
            $modelPeserta = new ModelPesertaAsessor();
            $ta_akademik = $this->getTa_akademik();

            $databelumvalidprodi = $modelPeserta->getDataPesertaBelumValidProdi(session()->get('id'), session()->get('kode_prodi'), $ta_akademik);
            $datasudahvalid = $modelPeserta->getDataPesertaAsessorSudahValidProdi(session()->get('id'), session()->get('kode_prodi'), $ta_akademik);
            $datasudahvaliddekan = $modelPeserta->getDataPesertaAsessorSudahValidDekanPerprodi(session()->get('id'), session()->get('kode_prodi'), $ta_akademik);
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Prodi', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPesertaBelumValid' => $databelumvalidprodi,
                'dataPesertaSudahValid' => $datasudahvalid,
                'dataPesertaSudahValidDekan' => $datasudahvaliddekan,
                'validstatus' => $statusMessage,
            ];
            return view('Admin/rpl-home-prodi', $data);
        }
    }

    public function validasidekan()
    {
        if (!session()->get('sttpengguna') || session()->get('sttpengguna') != 4) {
            return redirect()->to('/logout');
        } else {
            $db      = \Config\Database::connect();
            $this->request = service('request');
            $noregis = $db->escapeString($this->request->getPost("noregis"));

            $modelMkDekan = new ModelKlaimDekan();
            $cekpesertaasessor = $modelMkDekan->chekstauspesertaasessor($noregis);
            $cekpesertaprodi = $modelMkDekan->chekstauspesertaprodi($noregis);
            $cekpeserta = $modelMkDekan->chekstauspeserta($noregis);
            if ($cekpesertaasessor != null && $cekpesertaprodi != null) {
                if ($cekpeserta != null) {
                    // echo $this->validdekan($noregis, 4);
                    $statusMessage = "Peserta Sudah Divalidasi";
                } else {
                    $validprodi = $modelMkDekan->validdekan($noregis, session()->get("id"));
                    if ($validprodi === false) {
                        // echo $this->validdekan($noregis, 3);\
                        $statusMessage = "Peserta Gagal Divalidasi";
                    } else {
                        // echo $this->validdekan($noregis, 2);
                        $statusMessage = "Peserta Berhasil Divalidasi";
                    }
                }
            } else {
                // peserta belum valid asessor atau prodi
                // echo $this->validdekan($noregis, 5);
                $statusMessage = "Peserta Belum divalidasi prodi atau belum divalidasi Asessor";
            }
            $modelPeserta = new ModelPesertaAsessor();
            $ta_akademik = $this->getTa_akademik();
            $kode_fakultas = session()->get('kode_fakultas');
            $databelumvalid = $modelPeserta->getDataPesertaAsessorSudahValidProdiDekan(session()->get('id'), $kode_fakultas, $ta_akademik);
            $datasudahvalid = $modelPeserta->getDataPesertaAsessorSudahValidDekan(session()->get('id'), $kode_fakultas, $ta_akademik);

            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Fakultas', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPesertaBelumValid' => $databelumvalid,
                'dataPesertaSudahValid' => $datasudahvalid,
                'validstatus' => $statusMessage,


            ];

            return view('Admin/rpl-home-fakultas', $data);
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
                    // echo $this->validprodi($noregis, 6);
                    $statusMessage = "Peserta Gagal Diunvalidasi";
                } else {
                    // echo $this->validprodi($noregis, 5);
                    $statusMessage = "Peserta Berhasil Diunvalidasi";
                }
            } else {
                // echo $this->validprodi($noregis, 7);
                $statusMessage = "Peserta Sudah Diunvalidasi";
            }
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
                'validstatus' => $statusMessage,
            ];
            return view('Admin/rpl-home-prodi', $data);
        }
    }
    public function unvalidasidekan()
    {
        if (!session()->get('sttpengguna') || session()->get('sttpengguna') != 4) {
            return redirect()->to('/logout');
        } else {
            $db      = \Config\Database::connect();
            $this->request = service('request');
            $noregis = $db->escapeString($this->request->getPost("noregis"));

            $modelMkDekan = new ModelKlaimDekan();
            $cekpesertaasessor = $modelMkDekan->chekstauspesertaasessor($noregis);
            $cekpesertaprodi = $modelMkDekan->chekstauspesertaprodi($noregis);
            $cekpeserta = $modelMkDekan->chekstauspeserta($noregis);
            if ($cekpeserta != null) {
                $unvalidprodi = $modelMkDekan->unvaliddekan($noregis, session()->get("id"));
                if ($unvalidprodi === false) {
                    // echo $this->validdekan($noregis, 7);
                    $statusMessage = "Peserta Gagal Diunvalidasi";
                } else {
                    // echo $this->validdekan($noregis, 6);
                    $statusMessage = "Peserta Berhasil Diunvalidasi";
                }
            } else {
                // echo $this->validdekan($noregis, 8);
                $statusMessage = "Peserta Sudah Diunvalidasi";
            }
            $modelPeserta = new ModelPesertaAsessor();
            $ta_akademik = $this->getTa_akademik();
            $kode_fakultas = session()->get('kode_fakultas');
            $databelumvalid = $modelPeserta->getDataPesertaAsessorSudahValidProdiDekan(session()->get('id'), $kode_fakultas, $ta_akademik);
            $datasudahvalid = $modelPeserta->getDataPesertaAsessorSudahValidDekan(session()->get('id'), $kode_fakultas, $ta_akademik);

            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Fakultas', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPesertaBelumValid' => $databelumvalid,
                'dataPesertaSudahValid' => $datasudahvalid,
                'validstatus' => $statusMessage,


            ];

            return view('Admin/rpl-home-fakultas', $data);
        }
    }

    public function validdekan($noregis, $status = 1)
    {
        if (!session()->get('sttpengguna') || session()->get('sttpengguna') != 4) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $noregis = $db->escapeString($noregis);
            $kode_prodi = $this->getKodeProdiBy($noregis);
            $kode_fakultas = $this->getKodeFakultasby($kode_prodi);
            $statusMessage = '';
            if ($status == 2) {
                $statusMessage = "Peserta Berhasil Divalidasi";
            } else  if ($status == 3) {
                $statusMessage = "Peserta Gagal Divalidasi";
            } else  if ($status == 4) {
                $statusMessage = "Peserta Sudah Divalidasi";
            } else  if ($status == 5) {
                $statusMessage = "Peserta Belum divalidasi prodi atau belum divalidasi Asessor";
            } else if ($status == 6) {
                $statusMessage = "Peserta Berhasil Diunvalidasi";
            } else  if ($status == 7) {
                $statusMessage = "Peserta Gagal Diunvalidasi";
            } else  if ($status == 8) {
                $statusMessage = "Peserta Sudah Diunvalidasi";
            };
            if ($kode_fakultas == session()->get('kode_fakultas')) {
                // $noregis = session()->get("noregis");
                $Modaldokumen = new ModelDokumen();
                $ModalBiodata = new ModelBiodata();
                $ModalAssesmentMandiri = new ModelKlaimAsessor();
                $datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
                $databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
                $dataassementmandiri = $ModalAssesmentMandiri->getKlaimMk_mahasiswa($noregis);
                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Fakultas', 'pagetitle' => 'Dashboards']),
                    'nama_mhs' => $databio[0]['nama'],
                    'nm_prodi' => $this->getNamaProdi($databio[0]['kode_prodi']),
                    'jenis_rpl' => $databio[0]['jenis_rpl'],
                    'noregis' => $noregis,
                    'status' => $status,
                    'dataKlaimMhs' => $dataassementmandiri,
                    'validstatus' => $statusMessage

                ];
                return view('Admin/rpl-validasi-dekan', $data);
            } else {
                return redirect()->to(base_url('Admin'));
            }
        }
    }
    public function klaimMkAsessor()
    {
        if (!session()->get('sttpengguna')) {
            return redirect()->to('/logout');
        } else {
            $formdata = $this->request->getPost();
            $lastdata = array();
            $noregis = session()->get("noregis");
            $ta_akademik = $this->getTa_akademik();
            $ModalTransactionKlaim = new ModelKlaimAsessor();
            $simpanklaim = $ModalTransactionKlaim->simpanklaimAsessor($formdata, $ta_akademik);
        }
    }

    public function getNamaProdi($kode_prodi)
    {
        $db      = \Config\Database::connect();
        $result = $db->query("select * from prodi where kode_prodi ='$kode_prodi'")->getRow();

        return $result->nama_prodi;
    }
    public function getKodeFakultasby($kode_prodi)
    {
        $db      = \Config\Database::connect();
        $result1 = $db->query("select kode_fakultas from prodi where kode_prodi ='$kode_prodi' group by kode_prodi")->getRow();

        return $result1->kode_fakultas;
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

    public function dataMhsPerpodiOk()
    {
        if (!session()->get('sttpengguna') || session()->get('sttpengguna') != 3) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $kode_prodi = session()->get('kode_prodi');
            $ta_akademik = $this->getTa_akademik();
            $kode_fakultas = $this->getKodeFakultasby($kode_prodi);
            if ($kode_fakultas) {
                $modalProdi = new ModelKlaimProdi();
                $result = $modalProdi->getDataMahasiswaOkper($ta_akademik, $kode_prodi);
                // $kode_fakultas = session()->get('kode_fakultas');
                if ($kode_fakultas == '13123') {
                    $fakultas = 'Teknik';
                } else if ($kode_fakultas == '60001') {
                    $fakultas = 'Ekonomi dan Ilmu-Ilmu Sosial';
                } else if ($kode_fakultas == '11222') {
                    $fakultas = 'Pascasarjana';
                };
                $dekan = $this->getNamadekan($kode_fakultas);
                // $cekpeserta = $modelMkDekan->chekstauspeserta($noregis);

                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Print Transkrip', 'pagetitle' => 'Dashboards']),
                    'dekan' => $dekan,
                    'fakultas' => $fakultas,
                    'dataKlaimAsessor' => $result,


                ];
                return view('Admin/rpl-data-mahasiswa-per-prodi', $data);
                // } else {
                //     return redirect()->to(base_url('Admin'));
                // }
            } else {
                return redirect()->to(base_url('Admin'));
            }
        }
    }
    public function printTranskrip($noregis)
    {
        if (!session()->get('sttpengguna') || session()->get('sttpengguna') != 4) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $noregis = $db->escapeString($noregis);
            $kode_prodi = $this->getKodeProdiBy($noregis);
            $kode_fakultas = $this->getKodeFakultasby($kode_prodi);
            if ($kode_fakultas == session()->get('kode_fakultas')) {
                // $noregis = session()->get("noregis");
                $Modaldokumen = new ModelDokumen();
                $ModalBiodata = new ModelBiodata();
                $modelMkDekan = new ModelKlaimDekan();
                $ModalAssesmentMandiri = new ModelKlaimAsessor();
                $datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
                $databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
                $modelklaimdekan = new ModelKlaimDekan();
                $result = $modelMkDekan->getDatatoPrint($noregis);
                $kode_fakultas = session()->get('kode_fakultas');
                if ($kode_fakultas == '13123') {
                    $fakultas = 'Teknik';
                } else if ($kode_fakultas == '60001') {
                    $fakultas = 'Ekonomi dan Ilmu-Ilmu Sosial';
                } else if ($kode_fakultas == '11222') {
                    $fakultas = 'Pascasarjana';
                };
                $dekan = $this->getNamadekan($kode_fakultas);
                $cekpeserta = $modelMkDekan->chekstauspeserta($noregis);
                if ($cekpeserta != null) {
                    $data = [
                        'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                        'page_title' => view('partials/rpl-page-title', ['title' => 'Print Transkrip', 'pagetitle' => 'Dashboards']),
                        'nama_mhs' => $databio[0]['nama'],
                        'nm_prodi' => $this->getNamaProdi($databio[0]['kode_prodi']),
                        'jenis_rpl' => $databio[0]['jenis_rpl'],
                        'noregis' => $noregis,
                        'dekan' => $dekan,
                        'fakultas' => $fakultas,
                        'dataKlaimAsessor' => $result,


                    ];
                    return view('Admin/rpl-print-transkrip', $data);
                } else {
                    return redirect()->to(base_url('Admin'));
                }
            } else {
                return redirect()->to(base_url('Admin'));
            }
        }
    }
    public function getNamadekan($fakultas)
    {
        $db      = \Config\Database::connect();
        $result = $db->query("select dekan from fakultas where kode_fakultas ='$fakultas'")->getRow();
        if ($result != null) {
            $dekan = $result->dekan;
        } else {
            return false;
        }
        return $dekan;
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
