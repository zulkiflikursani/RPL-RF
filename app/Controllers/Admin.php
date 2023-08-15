<?php

namespace App\Controllers;

use App\Models\ModelBiodata;
use App\Models\ModelCpmk;
use App\Models\ModelDokumen;
use App\Models\ModelDosen;
use App\Models\ModelKeu;
use App\Models\ModelKlaimAsessor;
use App\Models\ModelKlaimDekan;
use App\Models\ModelKlaimMkHeader;
use App\Models\ModelKlaimProdi;
use App\Models\ModelKonsentrasi;
use App\Models\ModelMasterCpmk;
use App\Models\ModelMatakuliah;
use App\Models\ModelMkA1;
use App\Models\ModelNilai;
use App\Models\ModelPengguna;
use App\Models\ModelPesertaAsessor;
use App\Models\ModelProv;
use App\Models\ModelRegistrasi;
use App\Models\ModelRpl;
use App\Models\ModelTarif;
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
            $modalMkA1 = new ModelMkA1();
            $ta_akademik = $this->getTa_akademik();
            $mhsblmuploadmk = $modalMkA1->dataMhsBelumUploadMk($ta_akademik);
            $databelumvalidA1 = $modalMkA1->dataMhsBelumAsesiA1($ta_akademik);
            $databelumvalid = $modelPeserta->getDataPesertaAsessroBelumValid(session()->get('id'), $ta_akademik);
            $datasudahvalid = $modelPeserta->getDataPesertaAsessorSudahValid(session()->get('id'), $ta_akademik);
            $datasudahvalidprodi = $modelPeserta->getDataPesertaAsessorSudahValidProdiByAsessor(session()->get('id'), session()->get('kode_prodi'), $ta_akademik);
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPesertaBelumUploadMk' => $mhsblmuploadmk,
                'dataPesertaBelumValidA1' => $databelumvalidA1,
                'dataPesertaBelumValid' => $databelumvalid,
                'dataPesertaSudahValid' => $datasudahvalid,
                'dataPesertaSudahValidProdi' => $datasudahvalidprodi,
            ];

            return view('Admin/rpl-home-asessor', $data);
        } else if (session()->get('sttpengguna') == 3) {
            $modelPeserta = new ModelPesertaAsessor();
            $ta_akademik = $this->getTa_akademik();

            $datamahasiswabelumpunyaasessro = $modelPeserta->getdataPesertaBelumPunyaAsessorByProdi(session()->get('kode_prodi'), $ta_akademik);

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
                'dataMhsbelumpunyaasessor' => $datamahasiswabelumpunyaasessro,

            ];

            return view('Admin/rpl-home-prodi', $data);
        } else if (session()->get('sttpengguna') == 4) {
            $modelPeserta = new ModelPesertaAsessor();
            $ta_akademik = $this->getTa_akademik();
            $kode_fakultas = session()->get('kode_fakultas');
            $databelumvalid = $modelPeserta->getDataPesertaAsessorSudahValidProdiDekan(session()->get('id'), $kode_fakultas, $ta_akademik);
            $datasudahvalid = $modelPeserta->getDataPesertaAsessorSudahValidDekan(session()->get('id'), $kode_fakultas, $ta_akademik);
            $datasudahkeu = $modelPeserta->getDataPesertaAsessorSudahValidKeu(session()->get('id'), $kode_fakultas, $ta_akademik);

            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Fakultas', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPesertaBelumValid' => $databelumvalid,
                'dataPesertaSudahValid' => $datasudahvalid,
                'dataPesertaSudahValidkeu' => $datasudahkeu,


            ];

            return view('Admin/rpl-home-fakultas', $data);
        } else if (session()->get('sttpengguna') == 5) {
            $modelRegister = new ModelRegistrasi();
            $ta_akademik = $this->getTa_akademik();
            $databelumvalidasi = $modelRegister->getNonvalid($ta_akademik);
            $datasudahvalidasi = $modelRegister->getvalid($ta_akademik);
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Keuangan', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPesertaBelumValid' => $databelumvalidasi,
                'dataPesertaSudahValid' => $datasudahvalidasi,

            ];

            return view('Admin/rpl-home-keu', $data);
        } else if (session()->get('sttpengguna') == 6) {
            $modelKeuangan = new ModelKeu();
            $ta_akademik = $this->getTa_akademik();
            $datasudahvalidasi = $modelKeuangan->getvalidbayar($ta_akademik);
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Akademik', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPesertaValid' => $datasudahvalidasi,

            ];

            return view('Admin/rpl-home-akademik', $data);
        }
    }

    public function updateBiodataMahasiswa($noregis)
    {
        if (session()->get('sttpengguna') != 1) {
            return redirect()->to('/logout');
        } else {

            $modelBiodata = new ModelBiodata();
            $modelProv = new ModelProv();
            $dataProv = $modelProv->getProv();
            $databio = $modelBiodata->where('no_peserta', $noregis)->findAll();
            $modelmkheader = new ModelKlaimMkHeader();

            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Biodata', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'datasubmit' => $databio,
                'dataprov' => $dataProv,

            ];

            return view('Admin/rpl-biodata-mahasiswa', $data);
        }
    }

    public function setBiodata()
    {
        if (session()->get('sttpengguna') != 1) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $ta = $this->getTa_akademik();
            $no_peserta = $db->escapeString($this->request->getPost("no_peserta"));
            $nama = $db->escapeString($this->request->getPost("nama"));
            $alamat = $db->escapeString($this->request->getPost("alamat"));
            $kab = $db->escapeString($this->request->getPost("kab"));
            $provinsi = $db->escapeString($this->request->getPost("provinsi"));
            $email = $db->escapeString($this->request->getPost("email"));
            $instansi = $db->escapeString($this->request->getPost("instansi"));
            $nohape = $db->escapeString($this->request->getPost("nohp"));
            $prodi = $db->escapeString($this->request->getPost("prodi"));
            $ibukandung = $db->escapeString($this->request->getPost("ibukandung"));
            $tlahir = $db->escapeString($this->request->getPost("tlahir"));
            $ttl = $db->escapeString($this->request->getPost("ttl"));
            $pendidikan = $db->escapeString($this->request->getPost("pendidikan"));
            $jenis_rpl = $db->escapeString($this->request->getPost("jenis_rpl"));
            $konsentrasi = $db->escapeString($this->request->getPost("konsentrasi"));
            $nik = $db->escapeString($this->request->getPost("nik"));

            $data = [
                'ta_akademik' => $ta,
                // 'no_peserta' => $noregis,
                'nama' => $nama,
                'alamat' => $alamat,
                'kotkab' => $kab,
                'propinsi' => $provinsi,
                'instansi_asal' => $instansi,
                'nohape' => $nohape,
                'email' => $email,
                'kode_prodi' => $prodi,
                'validasi_keu' => 1,
                't_lahir' => $tlahir,
                'kode_konsentrasi' => $konsentrasi,
                'ttl' => $ttl,
                'nik' => $nik,
                'didikakhir' => $pendidikan,
                'ibu_kandung' => $ibukandung,
                'jenis_rpl' => $jenis_rpl
            ];

            $modelBiodata = $db->table('bio_peserta');
            $result = $modelBiodata->where('no_peserta', $no_peserta)->update($data);
            $modelBiodata = new ModelBiodata();
            $modelProv = new ModelProv();
            $dataProv = $modelProv->getProv();
            $databio = $modelBiodata->where('no_peserta', $no_peserta)->findAll();
            if ($result == 1) {
                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Biodata', 'pagetitle' => 'Dashboards']),
                    'ta_akademik' => $this->getTa_akademik(),
                    'datasubmit' => $databio,
                    'dataprov' => $dataProv,
                    'status_update' => 1,

                ];
            } else {
                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Biodata', 'pagetitle' => 'Dashboards']),
                    'ta_akademik' => $this->getTa_akademik(),
                    'datasubmit' => $databio,
                    'status_update' => 0,

                ];
            }
            return view('Admin/rpl-biodata-mahasiswa', $data);
        }
    }
    public function resetPasswordProdi()
    {
        if (session()->get('sttpengguna') != 3) {
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
            $result = $modelPengguna
                ->where('email', $email)
                ->set(['ktkunci' => $password])
                ->update();
            if ($result === false) {
                // $modelPengguna = new ModelPengguna();
                $modelPengguna = new ModelPengguna();
                $where = [
                    'sttpengguna' => 2,
                    'kode_prodi' => session()->get('kode_prodi')
                ];
                $dataPengguna = $modelPengguna->where($where)->findAll();

                $modelDosen = new ModelDosen();
                $dataDosen = $modelDosen->where('kode_prodi', session()->get('kode_prodi'))->findAll();
                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                    'ta_akademik' => $this->getTa_akademik(),
                    'dataPengguna' => $dataPengguna,
                    'dataDosen' => $dataDosen,
                    'dataerror' => $modelPengguna->errors(),
                    'status' => false,

                ];

                return view('Admin/rpl-data-admin-prodi', $data);
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
                $where = [
                    'sttpengguna' => 2,
                    'kode_prodi' => session()->get('kode_prodi')
                ];
                $dataPengguna = $modelPengguna->where($where)->findAll();


                if (!$emailgo->send()) {
                    $email_status = $emailgo->printDebugger(['headers']);
                    $modelDosen = new ModelDosen();
                    $dataDosen = $modelDosen->where('kode_prodi', session()->get('kode_prodi'))->findAll();
                    $data = [
                        'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                        'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                        'ta_akademik' => $this->getTa_akademik(),
                        'dataerror' => $modelPengguna->errors(),
                        'dataPengguna' => $dataPengguna,
                        'dataDosen' => $dataDosen,
                        'status' => false

                    ];

                    return view('Admin/rpl-data-admin-prodi', $data);
                    // Generate error
                } else {

                    $modelDosen = new ModelDosen();
                    $dataDosen = $modelDosen->where('kode_prodi', session()->get('kode_prodi'))->findAll();
                    $data = [
                        'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                        'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                        'ta_akademik' => $this->getTa_akademik(),
                        'dataPengguna' => $dataPengguna,
                        'dataDosen' => $dataDosen,
                        'status' => true

                    ];

                    return view('Admin/rpl-data-admin-prodi', $data);
                }
            }
        }
    }
    public function dataPeserta()
    {
        if (session()->get('sttpengguna') != 1) {
            return redirect()->to('/logout');
        } else {

            $modalPeserta = new ModelRegistrasi();
            $ta_akademik = $this->getTa_akademik();
            $dataPesertaFakultas = $modalPeserta->getDataPerFakultas($ta_akademik);
            $dataPesertaProdi = $modalPeserta->getDataPerProdi($ta_akademik);

            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Rekap Peserta RPL', 'pagetitle' => 'Rekap Peserta RPL']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPesertaFakultas' => $dataPesertaFakultas,
                'dataPesertaProdi' => $dataPesertaProdi,
            ];

            return view('Admin/rpl-rekapitulasi-peserta', $data);
        }
    }
    public function datastatusklaim()
    {
        if (session()->get('sttpengguna') != 3) {
            return redirect()->to('/logout');
        } else {
            $modelPeserta = new ModelPesertaAsessor();
            $ta_akademik = $this->getTa_akademik();


            $dataPesertastatusklaim = $modelPeserta->getDataPesertaStatusKlaim(session()->get('id'), session()->get('kode_prodi'), $ta_akademik);
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Prodi', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),

                'dataStatusKlaim' => $dataPesertastatusklaim,
            ];

            return view('Admin/rpl-status-klaim', $data);
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
    public function validbayarKeu()
    {
        if (session()->get('sttpengguna') != 5) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            helper('text');
            date_default_timezone_set('Asia/Makassar');
            $now = date('Y-m-d H:i:s');
            $modelKeu = new ModelKeu();
            $noregis = $db->escapeString($this->request->getPost("noregis"));
            $modeldekan = new ModelKlaimDekan();
            $cekvaliddekan = $modeldekan->chekstauspeserta($noregis);
            $set = [
                "valid" => "1",
                "tglubah" => $now,
            ];
            if ($cekvaliddekan == null) {
                echo "Gagal Melakukan Validasi ! Mahasiswa belum memiliki tagihan karena Belum divalidasi dekan ";
            } else {
                $result = $modelKeu->where("no_peserta", $noregis)->set($set)->update();
                if ($result === false) {
                    echo $modelKeu->errors();
                } else {
                    echo "Berhasil Melakukan validasi Pembayaran Calon Mahasiswa";
                }
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
            $cekasessor = $db->query("select idklaim from mk_klaim_asessor where mid(idklaim,6,10) ='$noregis'");
            $result = $cekasessor->getRow();
            if (isset($result)) {
                if ($result->idklaim != null) {
                    echo "Gagal Mengunvalidasi karena sudah dinilai oleh asessor.";
                }
            } else {
                $result = $modelKeu->where("no_peserta", $noregis)->delete();
                $result2 = $modelKeu->setunvalid($noregis);

                if ($result === false || $result2 === false) {
                    echo $modelKeu->errors();
                } else {
                    echo "Berhasil Membatalkan Validasi Calon Mahasiswa";
                }
            }
        }
    }
    public function unvalidbayarKeu()
    {
        if (session()->get('sttpengguna') != 5) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            helper('text');
            date_default_timezone_set('Asia/Makassar');
            $now = date('Y-m-d H:i:s');
            $modelKeu = new ModelKeu();
            $noregis = $db->escapeString($this->request->getPost("noregis"));
            $set = [
                "valid" => 0,
                "tglubah" => $now,
            ];
            $result = $modelKeu->where("no_peserta", $noregis)->set($set)->update();
            if ($result === false) {
                echo $modelKeu->errors();
            } else {
                echo "Berhasil Membatalkan Validasi Pembayaran Calon Mahasiswa";
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
            $result = $modelPengguna
                ->where('email', $email)
                ->set(['ktkunci' => $password])
                ->update();
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

    public function dataKeuangan()
    {
        if (session()->get('sttpengguna') != 5) {
            return redirect()->to('/logout');
        } else {
            $modelKeu = new ModelKeu();
            $ta_akademik = $this->getTa_akademik();
            $dataLulus = $modelKeu->getDataLulus($ta_akademik);
            $dataLulusBelumBayar = $modelKeu->getdataLulusBelumBayar($ta_akademik);
            $dataLulusSudahBayar = $modelKeu->getdataLulusSudahBayar($ta_akademik);
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Keuangan', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataLulus' => $dataLulus,
                'dataLulusBelumBayar' => $dataLulusBelumBayar,
                'dataLulusSudahBayar' => $dataLulusSudahBayar,

            ];

            return view('Admin/rpl-data-keuangan', $data);
        }
    }

    public function asessiA1()
    {
        if (session()->get('sttpengguna') != 2) {
            return redirect()->to('/logout');
        } else {
            $modelPeserta = new ModelPesertaAsessor();
            $modalMkA1 = new ModelMkA1();
            $ta_akademik = $this->getTa_akademik();
            $mhsblmuploadmk = $modalMkA1->dataMhsBelumUploadMk($ta_akademik);
            $databelumvalidA1 = $modalMkA1->dataMhsBelumAsesiA1($ta_akademik);
            $datasudahvalid = $modelPeserta->getDataPesertaAsessorSudahValid(session()->get('id'), $ta_akademik);
            $datasudahvalidprodi = $modelPeserta->getDataPesertaAsessorSudahValidProdiByAsessor(session()->get('id'), session()->get('kode_prodi'), $ta_akademik);
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPesertaBelumUploadMk' => $mhsblmuploadmk,
                'dataPesertaBelumValidA1' => $databelumvalidA1,
                'dataPesertaSudahValid' => $datasudahvalid,
                'dataPesertaSudahValidProdi' => $datasudahvalidprodi,
            ];
            return view('Admin/rpl-home-asessor-a1', $data);
        }
    }
    public function data_asessi_prodi()
    {
        if (session()->get('sttpengguna') != 3) {
            return redirect()->to('/logout');
        } else {
            $modelPengguna = new ModelPengguna();
            $where = [
                'sttpengguna' => 2,
                'kode_prodi' => session()->get('kode_prodi')
            ];
            $dataPengguna = $modelPengguna->where($where)->findAll();

            $modelDosen = new ModelDosen();
            $dataDosen = $modelDosen->where('kode_prodi', session()->get('kode_prodi'))->findAll();
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPengguna' => $dataPengguna,
                'dataDosen' => $dataDosen,

            ];

            return view('Admin/rpl-data-admin-prodi', $data);
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

            $modelRegister = new ModelRegistrasi();
            $email = $db->escapeString($this->request->getPost("eemail"));
            $password1 =  random_string('alnum', 6);
            $password = password_hash($password1, PASSWORD_BCRYPT);
            $link = base_url("Login");
            $result = $modelRegister
                ->where('email', $email)
                ->set(['ktkunci' => $password])
                ->update();
            if ($result === false) {
                $dataMhs = $modelRegister->findAll();
                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Admin', 'pagetitle' => 'Dashboards']),
                    'dataMhs' => $dataMhs,
                    'dataerror' => $modelRegister->errors(),
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
                // $modelPengguna = new ModelPengguna();
                $dataPengguna = $modelRegister->findAll();

                if (!$emailgo->send()) {
                    $email_status = $emailgo->printDebugger(['headers']);
                    $modelRegister = new ModelRegistrasi();
                    $dataMhs = $modelRegister->findAll();
                    $data = [
                        'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                        'page_title' => view('partials/rpl-page-title', ['title' => 'Admin', 'pagetitle' => 'Dashboards']),
                        'dataMhs' => $dataMhs,
                        'dataerror' => $modelRegister->errors(),
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

                    return view('Admin/rpl-data-reg-mhs', $data);
                }
            }
        }
    }

    public function adminklaimmhs()
    {
        if (session()->get('sttpengguna') != 1) {
            return redirect()->to('/logout');
        } else {
            $modelBiodata = new ModelBiodata();
            $ta_akademik = $this->getTa_akademik();

            $getMhs = $modelBiodata->getKlaimMhs($ta_akademik);
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Admin', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataMhs' => $getMhs,

            ];

            return view('Admin/rpl-data-klaim-mahasiswa', $data);
        }
    }

    public function batalKlaimMhs()
    {
        if (session()->get('sttpengguna') != 1) {
            return redirect()->to('/logout');
        } else {
            $db      = \Config\Database::connect();
            $modelBiodata = new ModelBiodata();
            $noregis = $db->escapeString($this->request->getPost("noregis"));
            $ta_akademik = $this->getTa_akademik();

            $getMhs = $modelBiodata->getKlaimMhs($ta_akademik);
            $statusklaim = $db->query("select idklaim from mk_klaim_asessor where no_peserta='$noregis'")->getResult();
            if ($statusklaim != null) {
                $modelBiodata = new ModelBiodata();
                $getMhs = $modelBiodata->getKlaimMhs($ta_akademik);
                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Admin', 'pagetitle' => 'Dashboards']),
                    'ta_akademik' => $this->getTa_akademik(),
                    'dataMhs' => $getMhs,
                    'status' => false
                ];
                return view('Admin/rpl-data-klaim-mahasiswa', $data);
            } else {
                $batalkalim = $db->query("update mk_klaim_detail set statusklaim=1 where mid(idklaim,6,10)='$noregis'");
                if ($batalkalim === FALSE) {
                    $modelBiodata = new ModelBiodata();
                    $getMhs = $modelBiodata->getKlaimMhs($ta_akademik);
                    $data = [
                        'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                        'page_title' => view('partials/rpl-page-title', ['title' => 'Admin', 'pagetitle' => 'Dashboards']),
                        'ta_akademik' => $this->getTa_akademik(),
                        'dataMhs' => $getMhs,
                        'status' => false,

                    ];

                    return view('Admin/rpl-data-klaim-mahasiswa', $data);
                } else {
                    $modelBiodata = new ModelBiodata();
                    $getMhs = $modelBiodata->getKlaimMhs($ta_akademik);
                    $data = [
                        'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                        'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                        'ta_akademik' => $this->getTa_akademik(),
                        'dataMhs' => $getMhs,
                        'status' => true


                    ];

                    return view('Admin/rpl-data-klaim-mahasiswa', $data);
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

    public function SimpanPenggunaProdi()
    {
        if (session()->get('sttpengguna') != 3) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            helper('text');

            $modelPengguna = new ModelPengguna();
            $full = $db->escapeString($this->request->getPost("nama"));
            $pisah = explode(":", $full);
            $nama = $pisah[1];
            $idpengguna = $pisah[0];
            $email = $db->escapeString($this->request->getPost("email"));
            $status = $db->escapeString($this->request->getPost("status"));
            $kode_prodi = $db->escapeString($this->request->getPost("kode_prodi"));
            $kode_fakultas = $db->escapeString($this->request->getPost("kode_fakultas"));
            $password1 =  random_string('alnum', 6);
            $password = password_hash($password1, PASSWORD_BCRYPT);
            $lastidpengguna = $db->query('select max(right(idpengguna,4)) as idpengguna from tb_pengguna')->getRow();
            $where = [
                'sttpengguna' => 2,
                'kode_prodi' => session()->get('kode_prodi')
            ];
            $dataPengguna = $modelPengguna->where($where)->findAll();
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
            // $idpengguna = "P-" . $nolari;
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
                $where = [
                    'sttpengguna' => 2,
                    'kode_prodi' => session()->get('kode_prodi')
                ];
                $dataPengguna = $modelPengguna->where($where)->findAll();
                $modelDosen = new ModelDosen();
                $dataDosen = $modelDosen->where('kode_prodi', session()->get('kode_prodi'))->findAll();
                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                    'ta_akademik' => $this->getTa_akademik(),
                    'dataPengguna' => $dataPengguna,
                    'dataerror' => $modelPengguna->errors(),
                    'dataDosen' => $dataDosen,
                    'status' => false,

                ];
                return view('Admin/rpl-data-admin-prodi', $data);
            } else {
                $message = "Anda terdaftar sebagai " . $statusPengguna . "  <br>
            			Berikut ini user untuk login ke SILAJUL Unifa <br>
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
                $where = [
                    'sttpengguna' => 2,
                    'kode_prodi' => session()->get('kode_prodi')
                ];
                $dataPengguna = $modelPengguna->where($where)->findAll();

                if (!$emailgo->send()) {
                    $email_status = $emailgo->printDebugger(['headers']);

                    $modelDosen = new ModelDosen();
                    $dataDosen = $modelDosen->where('kode_prodi', session()->get('kode_prodi'))->findAll();
                    $data = [
                        'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                        'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                        'ta_akademik' => $this->getTa_akademik(),
                        'dataPengguna' => $dataPengguna,
                        'dataDosen' => $dataDosen,
                        'status' => false,

                    ];

                    return view('Admin/rpl-data-admin-prodi', $data);
                    // Generate error
                } else {

                    $modelDosen = new ModelDosen();
                    $dataDosen = $modelDosen->where('kode_prodi', session()->get('kode_prodi'))->findAll();
                    $data = [
                        'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                        'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                        'ta_akademik' => $this->getTa_akademik(),
                        'dataPengguna' => $dataPengguna,
                        'dataDosen' => $dataDosen,
                        'status' => true,

                    ];
                    return view('Admin/rpl-data-admin-prodi', $data);
                }
            }
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

    public function hapuspengguna()
    {
        if (session()->get('sttpengguna') != 1) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            helper('text');

            $modelPengguna = new ModelPengguna();
            $idpengguna = $db->escapeString($this->request->getPost("idpengguna"));


            $data1 = [
                "idpengguna" => $idpengguna,
            ];
            $datapengguna = $modelPengguna->where('idpengguna', $idpengguna)->findAll();
            if ($datapengguna != null) {
                foreach ($datapengguna as $row) {
                    $sttpengguna = $row['sttpengguna'];
                }
            }
            $cekhistory = $this->cekhistorypengguna($sttpengguna, $idpengguna);


            if ($cekhistory == true) {
                $delete = $modelPengguna->where($data1)->delete();
                if ($delete === false) {
                    // $modelPengguna = new ModelPengguna();
                    echo "Gagal Menghapus Pengguna";
                } else {
                    echo "Berhasil Menghapus Pengguna";
                }
            } else {
                // $modelPengguna = new ModelPengguna();
                echo "Tidak bisa Menghapus Pengguna";
            }
        }
    }

    public function cekhistorypengguna($sttpengguna, $idpengguna)
    {
        $status = 1;
        if ($sttpengguna == 1) {
            $modal = new ModelPengguna();
            $countuseradmin = $modal->where('sttpengguna', 1)->get()->getNumRows();
            if ($countuseradmin == 1) {
                $status = 0;
            }
        } else if ($sttpengguna == 2) {
            $modal = new ModelKlaimAsessor();
            $data = $modal->where('idpengguna', $idpengguna)->findAll();
            if ($data != null) {
                $status = 0;
            }
        } else if ($sttpengguna == 3) {
            $modal = new ModelKlaimProdi();
            $data = $modal->where('idpengguna', $idpengguna)->findAll();
            if ($data != null) {
                $status = 0;
            }
        } else if ($sttpengguna == 4) {
            $modal = new ModelKlaimDekan();
            $data = $modal->where('idpengguna', $idpengguna)->findAll();
            if ($data != null) {
                $status = 0;
            }
        } else if ($sttpengguna == 5) {
            $modal = new ModelKeu();
            $data = $modal->where('id_pengguna', $idpengguna)->findAll();
            if ($data != null) {
                $status = 0;
            }
        }

        if ($status == 0) {
            return false;
        } else {
            return true;
        }
    }
    public function inputcpmk()
    {
        if (session()->get('sttpengguna') != 1) {
            return redirect()->to('/logout');
        } else {

            $modelCpmk = new ModelCpmk();
            $programstudi = $modelCpmk->getAllprodi();
            // $datacpmk = $this->getcpmkAdmin();
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Matakuliah', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'jenis_prodi' => $programstudi,
                // 'datacpmk' => $datacpmk,
            ];

            return view('Admin/rpl-input-cpmk-admin', $data);
        }
    }
    public function inputcpmk_prodi()
    {
        if (session()->get('sttpengguna') != 3) {
            return redirect()->to('/logout');
        } else {

            $modelCpmk = new ModelCpmk();
            $prodi = session()->get('kode_prodi');
            $nama_prodi = $this->getNamaProdiByKode($prodi);
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Matakuliah', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'jenis_prodi' => $prodi,
                'nama_prodi' => $nama_prodi,
                // 'datacpmk' => $dataAsessor,
            ];

            return view('Admin/rpl-input-cpmk-prodi', $data);
        }
    }
    public function inputmk_prodi()
    {
        if (session()->get('sttpengguna') != 3) {
            return redirect()->to('/logout');
        } else {

            $modelMk = new ModelMatakuliah();
            $modelKons = new ModelKonsentrasi();
            $prodi = session()->get('kode_prodi');
            $datamk = $modelMk->getMatakuliahByprodi($prodi);
            $nama_prodi = $this->getNamaProdiByKode($prodi);
            $konsentrasi = $modelKons->where('prodi', $prodi)->findAll();
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Matakuliah', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'jenis_prodi' => $prodi,
                'nama_prodi' => $nama_prodi,
                'datamk' => $datamk,
                'datakonst' => $konsentrasi
                // 'datacpmk' => $dataAsessor,
            ];

            return view('Admin/rpl-input-matakuliah', $data);
        }
    }
    public function inputmk_admin()
    {
        if (session()->get('sttpengguna') != 1) {
            return redirect()->to('/logout');
        } else {

            $modelMk = new ModelMatakuliah();
            $modelKons = new ModelKonsentrasi();
            $modelCpmk = new ModelCpmk();
            $programstudi = $modelCpmk->getAllprodi();

            $datamk = $modelMk->getMatakuliahAdmin();


            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Matakuliah', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'getAllprodi' => $programstudi,
                'nama_prodi' => "",
                'datamk' => $datamk,
                'datakonst' => "",

            ];

            return view('Admin/rpl-input-matakuliah-admin', $data);
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
								master_cpmk.idcpmk,
                                master_cpmk.cpmk
									
								FROM
									matakuliah
								left JOIN
									master_cpmk
								on matakuliah.kode_matakuliah= master_cpmk.kode_matakuliah and master_cpmk.kode_prodi='$kode_prodi' 
								WHERE
									matakuliah.kode_prodi = '$kode_prodi' and matakuliah.jenis_matakuliah='3' 
								order by matakuliah.kode_matakuliah")->getResult();

            echo json_encode($result, false);
        }
    }
    public function getcpmkAdmin()
    {
        if (!session()->get('sttpengguna')) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            // $kode_prodi = $db->escapeString($this->request->getPost("prodi"));
            $result = $db->query("SELECT
								matakuliah.*,
								master_cpmk.idcpmk,
                                master_cpmk.cpmk		
								FROM
									matakuliah
								left JOIN
									master_cpmk
								on matakuliah.kode_matakuliah= master_cpmk.kode_matakuliah and matakuliah.kode_prodi=master_cpmk.kode_prodi
								WHERE
									(matakuliah.jenis_matakuliah='1' or matakuliah.jenis_matakuliah ='2') 
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
            if (session()->get("sttpengguna") == 3) {
                $kode_prodi = session()->get('kode_prodi');
            } else if (session()->get("sttpengguna") == 1) {
                $kode_prodi = "";
            }
            $ta_akademik = $this->getTa_akademik();
            $kdmk = $db->escapeString($this->request->getPost("kdmk"));
            $idcpmk = $db->escapeString($this->request->getPost("idcpmk"));
            $cpmk = $db->escapeString($this->request->getPost("cpmk"));
            $data = [

                'kode_prodi' => $kode_prodi,
                'kode_matakuliah' => $kdmk,
                'idcpmk' => $idcpmk,
                'cpmk' => $cpmk

            ];

            $modelCpmk = new ModelMasterCpmk();
            $simpan = $modelCpmk->insert($data);
            if ($simpan === false) {
                print_r($modelCpmk->errors());
            } else {
                echo "Berhasil Menambahkan CPMK";
            }
        };
    }

    public function simpanMk()
    {
        if (!session()->get('sttpengguna')) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            if (session()->get("sttpengguna") == 3) {
                $kode_prodi = session()->get('kode_prodi');
                $jenis_matakuliah = '3';
            } else if (session()->get("sttpengguna") == 1) {
                $kode_prodi = $db->escapeString($this->request->getPost("prodi"));
                $jenis_matakuliah = $db->escapeString($this->request->getPost('jenis_mk'));
            }
            $kdmk = $db->escapeString($this->request->getPost("kdmk"));
            $nmmk = $db->escapeString($this->request->getPost("nmmk"));
            $sks = $db->escapeString($this->request->getPost("sks"));
            $idkur = $db->escapeString($this->request->getPost("idkur"));
            $modelMk = new ModelMatakuliah();
            if ($kode_prodi == "") {
                $status = '';
            } else {
                $status = $modelMk->getJejang($kode_prodi);
            }
            $data = [
                'status' => $status,
                'kode_prodi' => $kode_prodi,
                'kode_matakuliah' => $kdmk,
                'nama_matakuliah' => $nmmk,
                'jenis_matakuliah' => $jenis_matakuliah,
                'sks' => $sks,
                'id_kurikulum' => $idkur,

            ];

            $cekduplikat = $modelMk->checkduplikat($kdmk, $kode_prodi);
            if ($cekduplikat == null) {
                $simpan = $modelMk->insert($data);
                if ($simpan === false) {
                    print_r($modelMk->errors());
                } else {
                    echo "Berhasil Menambahkan Matakuliah";
                }
            } else {
                echo "Kode Matakuliah sudah digunakan";
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

            $modelCpmk = new ModelMasterCpmk();
            $simpan = $modelCpmk->editCpmk($idcpmk, $kode_prodi, $cpmk);
            if ($simpan === false) {
                echo $modelCpmk->errors();
            } else {
                echo "Berhasil Mengedit CPMK";
            }
        };
    }
    public function editMk()
    {
        if (!session()->get('sttpengguna')) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $kode_prodi = $db->escapeString($this->request->getPost("prodi"));
            $kdmk = $db->escapeString($this->request->getPost("kdmk"));
            $nmmk = $db->escapeString($this->request->getPost("nmmk"));
            $sks = $db->escapeString($this->request->getPost("sks"));

            $idkur = $db->escapeString($this->request->getPost("idkur"));
            if (session()->get('sttpengguna') == 3) {
                $jenis_mk = 3;
                $kdkons = $db->escapeString($this->request->getPost("kdkons"));
            } else if (session()->get('sttpengguna') == 1) {
                $kdkons = "";
                $jenis_mk = $db->escapeString($this->request->getPost("jenismk"));
            }
            $modelCpmk = new ModelMatakuliah();
            $simpan = $modelCpmk->editMk($kdmk, $kode_prodi, $nmmk, $kdkons, $sks, $idkur, $jenis_mk);
            if ($simpan === false) {
                echo $modelCpmk->errors();
            } else {
                echo "Berhasil Mengedit Matakuliah";
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

            $modelCpmk = new ModelMasterCpmk();
            $simpan = $modelCpmk->hapusCpmk($idcpmk, $kode_prodi, $cpmk);
            if ($simpan === false) {
                echo $modelCpmk->errors();
            } else {
                echo "Berhasil Menghapus CPMK";
            }
        };
    }
    public function hapusMk()
    {
        if (!session()->get('sttpengguna')) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $kode_prodi = $db->escapeString($this->request->getPost("prodi"));
            $kdmk = $db->escapeString($this->request->getPost("kdmk"));


            $modelCpmk = new ModelMatakuliah();
            $cekcpmk = $modelCpmk->cekcpmk($kdmk, $kode_prodi);
            if ($cekcpmk == null) {
                $simpan = $modelCpmk->hapusMk($kdmk, $kode_prodi);
                if ($simpan === false) {
                    echo $modelCpmk->errors();
                } else {
                    echo "Berhasil Menghapus Matakuliah";
                }
            } else {
                $mk = $modelCpmk->hapusMk($kdmk, $kode_prodi);
                $cpmk = $modelCpmk->hapuscpmk($kdmk, $kode_prodi);
                if ($mk === false || $cpmk === false) {
                    echo $modelCpmk->errors();
                } else {
                    echo "Berhasil Menghapus Matakuliah";
                }
            }
        };
    }
    public function daftarMkRplprodi()
    {
        if (!session()->get('sttpengguna') || session()->get('sttpengguna') != 3) {
            return redirect()->to('/logout');
        } else {
            $modelMk = new ModelMatakuliah();
            $modelKons = new ModelKonsentrasi();
            $ta_akademik = $this->getTa_akademik();
            $prodi = session()->get('kode_prodi');
            $datamk = $modelMk->getMatakuliahRplByprodi($prodi, $ta_akademik);
            $nama_prodi = $this->getNamaProdiByKode($prodi);
            $konsentrasi = $modelKons->where('prodi', $prodi)->findAll();
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Matakuliah', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $ta_akademik,
                'jenis_prodi' => $prodi,
                'nama_prodi' => $nama_prodi,
                'datamk' => $datamk,
                'datakonst' => $konsentrasi
                // 'datacpmk' => $dataAsessor,
            ];

            return view('Admin/rpl-matakuliah-rpl', $data);
        }
    }
    public function daftarMkRplAdmin()
    {
        if (!session()->get('sttpengguna') || session()->get('sttpengguna') != 1) {
            return redirect()->to('/logout');
        } else {
            $modelMk = new ModelMatakuliah();
            $modelKons = new ModelKonsentrasi();
            $ta_akademik = $this->getTa_akademik();
            $prodi = session()->get('kode_prodi');
            $datamk = $modelMk->getMatakuliahRplByAdmin($ta_akademik);
            // $nama_prodi = $this->getNamaProdiByKode($prodi);
            $konsentrasi = $modelKons->where('prodi', $prodi)->findAll();
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Matakuliah', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $ta_akademik,
                // 'jenis_prodi' => $prodi,
                // 'nama_prodi' => $nama_prodi,
                'datamk' => $datamk,
                'datakonst' => $konsentrasi
                // 'datacpmk' => $dataAsessor,
            ];

            return view('Admin/rpl-matakuliah-rpl-admin', $data);
        }
    }

    public function updateMkRpl()
    {
        if (!session()->get('sttpengguna') || session()->get('sttpengguna') != 3) {
            return redirect()->to('/logout');
        } else {
            $db = \Config\Database::connect();
            $this->request = service("request");
            $data = $this->request->getPost("data");
            $ta_akademik = $this->getTa_akademik();
            $tempWhere = "";
            $querydel = "delete C from mk_cpmk C left join matakuliah M  on C.kode_matakuliah = M.kode_matakuliah where M.jenis_matakuliah='3' and C.kode_prodi= '" . session()->get('kode_prodi') . "'";
            $db->transStart();
            $db->query($querydel);

            if ($data != []) {
                foreach ($data as $row) {
                    $tempWhere .= "master_cpmk.kode_matakuliah = '" . $row . "' or ";
                }
                $where = substr($tempWhere, 0, -3);

                $query = "insert into mk_cpmk SELECT
                '$ta_akademik' as ta_akademik,
                master_cpmk.kode_prodi,
                        master_cpmk.kode_matakuliah,
                        master_cpmk.idcpmk,
                        master_cpmk.cpmk
                        FROM
                        master_cpmk
                        where " . $where;
                $db->query($query);
            };
            $db->transComplete();
            if ($db->transStatus() === false) {
                echo "Gagal Menyimpan data";
                // generate an error... or use the log_message() function to log your error
            } else {
                echo "Berhasil Menyimpan data";
            }
        }
    }
    public function updateMkRplAdmin()
    {
        if (!session()->get('sttpengguna') || session()->get('sttpengguna') != 1) {
            return redirect()->to('/logout');
        } else {
            $db = \Config\Database::connect();
            $this->request = service("request");
            $data = $this->request->getPost("data");
            $ta_akademik = $this->getTa_akademik();
            $tempWhere = "";
            $querydel = "delete C from mk_cpmk C left join matakuliah M  on C.kode_matakuliah = M.kode_matakuliah where (M.jenis_matakuliah='2' or M.jenis_matakuliah='1')";
            $db->transStart();
            $db->query($querydel);
            if ($data != []) {
                foreach ($data as $row) {
                    $tempWhere .= "matakuliah.kode_matakuliah = '" . $row . "' or ";
                }
                $where = substr($tempWhere, 0, -3);

                $query = "insert into mk_cpmk SELECT
                        '$ta_akademik' as ta_akademik,
                        matakuliah.kode_prodi,
                        matakuliah.kode_matakuliah,
                        master_cpmk.idcpmk,
                        master_cpmk.cpmk
                        FROM
                        matakuliah
                        left join master_cpmk on master_cpmk.kode_matakuliah=matakuliah.kode_matakuliah and master_cpmk.kode_prodi=matakuliah.kode_prodi
                        where " . $where;

                $db->query($query);
            }
            $db->transComplete();
            if ($db->transStatus() === false) {
                echo "Gagal Menyimpan data";
                // generate an error... or use the log_message() function to log your error
            } else {
                echo "Berhasil Menyimpan data";
            }
        }
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
    public function data_asessor_prodi()
    {
        if (!session()->get('sttpengguna') || session()->get('sttpengguna') != 3) {
            return redirect()->to('/logout');
        } else {

            $modelPengguna = new ModelPengguna();

            $where = [
                "sttpengguna" => 2,
                "kode_prodi" => session()->get('kode_prodi'),

            ];
            $dataAsessor = $modelPengguna->where($where)->findAll();

            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'Asessor RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataAsessor' => $dataAsessor,
            ];

            return view('Admin/rpl-data-asessor-prodi', $data);
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

    public function simpanpesertaasessor_prodi()
    {
        if (!session()->get('sttpengguna') || session()->get("sttpengguna") != 3) {
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

                $where = [
                    "sttpengguna" => 2,
                    "kode_prodi" => session()->get('kode_prodi'),

                ];
                $dataAsessor = $modelPengguna->where($where)->findAll();


                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'Asessor RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                    'ta_akademik' => $ta_akademik,
                    'dataerror' => $modelPeserta->errors(),
                    'dataAsessor' => $dataAsessor,
                ];

                return view('Admin/rpl-data-asessor-prodi', $data);
            } else {
                $modelPengguna = new ModelPengguna();

                $where = [
                    "sttpengguna" => 2,
                    "kode_prodi" => session()->get('kode_prodi'),

                ];
                $dataAsessor = $modelPengguna->where($where)->findAll();


                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'Asessor RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                    'ta_akademik' => $ta_akademik,
                    'status' => true,
                    'dataAsessor' => $dataAsessor,
                ];

                return view('Admin/rpl-data-asessor-prodi', $data);
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
                $ModalMkA1 = new ModelMkA1();
                $ModalNilai = new ModelNilai();


                $datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
                $databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
                $dataassementmandiri = $ModalAssesmentMandiri->getKlaimMk_mahasiswa($noregis);
                $maxsksrekognisi = $ModalMkA1->maxsksrekognisi($databio[0]['kode_prodi']);
                $nilai = $ModalNilai->findAll();

                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'Asessor RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                    'nama_mhs' => $databio[0]['nama'],
                    'nm_prodi' => $this->getNamaProdi($databio[0]['kode_prodi']),
                    'jenis_rpl' => $databio[0]['jenis_rpl'],
                    'noregis' => $noregis,
                    'maxsksrekognisi' => $maxsksrekognisi->sksmax,
                    'dataKlaimMhs' => $dataassementmandiri,
                    'basenilai' => $nilai

                ];
                return view('Admin/rpl-assesment-asessor', $data);
            } else {
                return redirect()->to(base_url('Admin'));
            }
        }
    }

    public function tanggapanAsessorA1($noregis)
    {
        if (!session()->get('sttpengguna') || session()->get('sttpengguna') != 2) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $noregis = $db->escapeString($noregis);
            $asessor = $this->getasessorbynoregis($noregis);
            if ($asessor == session()->get('id')) {
                $Modaldokumen = new ModelDokumen();
                $ModalBiodata = new ModelBiodata();
                $ModalMkA1 = new ModelMkA1();
                $ModalAssesmentMandiri = new ModelKlaimAsessor();
                $datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
                $databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
                $datamatakuliah = $ModalMkA1->where('no_registrasi', $noregis)->findAll();
                $mkrplprodi = $this->getMatakuliahklaimperprodi($databio[0]['kode_prodi'], $noregis);
                $dataklaimAsessorA1 = $ModalMkA1->getDataKlaimAsessorA1($noregis);
                $maxsksrekognisi = $ModalMkA1->maxsksrekognisi($databio[0]['kode_prodi']);

                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'Asessor RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                    'nama_mhs' => $databio[0]['nama'],
                    'nm_prodi' => $this->getNamaProdi($databio[0]['kode_prodi']),
                    'jenis_rpl' => $databio[0]['jenis_rpl'],
                    'noregis' => $noregis,
                    'datamatakuliah' => $datamatakuliah,
                    'data_dok' => $datadokumen,
                    'maxsksrekognisi' => $maxsksrekognisi->sksmax,
                    'mkrplprodi' => $mkrplprodi,
                    'dataKlaimAsessorA1' => $dataklaimAsessorA1

                ];
                return view('Admin/rpl-assesment-asessor-a1', $data);
            } else {
                return redirect()->to(base_url('Admin'));
            }
        }
    }

    public function batalKlaimmkA1()
    {

        if (!session()->get('sttpengguna') || session()->get('sttpengguna') != 2) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $idklaim = $db->escapeString($this->request->getPost('idklaim'));
            $modelklaimasessor = new ModelKlaimAsessor();
            $statusmk = $modelklaimasessor->cekValidProdi($idklaim);
            if ($statusmk == null) {
                $modelklaimasessor->batalklaimA1($idklaim);
            } else {
                echo "Tidak Bisa Membatalkan Klaim karena sudah divalidasi oleh Prodi";
            }
        }
    }

    public function batalKlaimdokA1()
    {

        if (!session()->get('sttpengguna') || session()->get('sttpengguna') != 2) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $noregis = $db->escapeString($this->request->getPost('noregis'));
            $modelklaimasessor = new ModelKlaimAsessor();
            $statusmk = $modelklaimasessor->cekValidProdiA1($noregis);
            if ($statusmk == null) {
                $modelklaimasessor->batalklaimdokA1($noregis);
            } else {
                echo "Tidak Bisa Membatalkan Klaim karena sudah divalidasi oleh Prodi";
            }
        }
    }
    public function getkodeprodi($noregis)
    {
        $db      = \Config\Database::connect();
        $result = $db->query("select kode_prodi from bio_peserta where no_peserta ='$noregis'")->getRow();
        return $result->kode_prodi;
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
                $modelPeserta = new ModelPesertaAsessor();
                $datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
                $namaasessor = $modelPeserta->getnamaasessor($noregis);
                $databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
                $dataassementmandiri = $ModalAssesmentMandiri->getKlaimMk_mahasiswa($noregis);
                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Prodi', 'pagetitle' => 'Dashboards']),
                    'nama_mhs' => $databio[0]['nama'],
                    'nm_prodi' => $this->getNamaProdi($databio[0]['kode_prodi']),
                    'jenis_rpl' => $databio[0]['jenis_rpl'],
                    'noregis' => $noregis,
                    'status' => $status,
                    'dataKlaimMhs' => $dataassementmandiri,
                    'validstatus' => $statusMessage,
                    'nm_asessor' => $namaasessor

                ];
                return view('Admin/rpl-validasi-prodi', $data);
            } else {
                return redirect()->to(base_url('Admin'));
            }
        }
    }
    public function validprodia1($noregis, $status = 1)
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
                $modelPeserta = new ModelPesertaAsessor();
                $ModalMkA1 = new ModelMkA1();

                $datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
                $namaasessor = $modelPeserta->getnamaasessor($noregis);
                $databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
                $dataklaimAsessorA1 = $ModalMkA1->getDataKlaimAsessorA1up($noregis);
                $ModalAssesmentMandiri->getKlaimMk_mahasiswa($noregis);
                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Prodi', 'pagetitle' => 'Dashboards']),
                    'nama_mhs' => $databio[0]['nama'],
                    'nm_prodi' => $this->getNamaProdi($databio[0]['kode_prodi']),
                    'jenis_rpl' => $databio[0]['jenis_rpl'],
                    'noregis' => $noregis,
                    'status' => $status,
                    'dataKlaimAsessorA1' => $dataklaimAsessorA1,
                    'validstatus' => $statusMessage,
                    'nm_asessor' => $namaasessor

                ];
                return view('Admin/rpl-validasi-prodi-a1', $data);
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
            $datamahasiswabelumpunyaasessro = $modelPeserta->getdataPesertaBelumPunyaAsessorByProdi(session()->get('kode_prodi'), $ta_akademik);
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
                'dataMhsbelumpunyaasessor' => $datamahasiswabelumpunyaasessro
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
            $datasudahkeu = $modelPeserta->getDataPesertaAsessorSudahValidKeu(session()->get('id'), $kode_fakultas, $ta_akademik);

            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Fakultas', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPesertaBelumValid' => $databelumvalid,
                'dataPesertaSudahValid' => $datasudahvalid,
                'validstatus' => $statusMessage,
                'dataPesertaSudahValidkeu' => $datasudahkeu,

            ];

            return view('Admin/rpl-home-fakultas', $data);
        }
    }
    public function batalklaimasessor($noregis)
    {
        if (!session()->get('sttpengguna') || session()->get('sttpengguna') != 2) {
            return redirect()->to('/logout');
        } else {
            $modelPeserta = new ModelPesertaAsessor();
            $modalMkA1 = new ModelMkA1();
            $modalasessor = new ModelKlaimAsessor();

            $batalklaim = $modalasessor->batalklaimasessor($noregis);
            $ta_akademik = $this->getTa_akademik();
            $mhsblmuploadmk = $modalMkA1->dataMhsBelumUploadMk($ta_akademik);
            $databelumvalidA1 = $modalMkA1->dataMhsBelumAsesiA1($ta_akademik);
            $databelumvalid = $modelPeserta->getDataPesertaAsessroBelumValid(session()->get('id'), $ta_akademik);
            $datasudahvalid = $modelPeserta->getDataPesertaAsessorSudahValid(session()->get('id'), $ta_akademik);
            $datasudahvalidprodi = $modelPeserta->getDataPesertaAsessorSudahValidProdiByAsessor(session()->get('id'), session()->get('kode_prodi'), $ta_akademik);
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Asessor', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPesertaBelumUploadMk' => $mhsblmuploadmk,
                'dataPesertaBelumValidA1' => $databelumvalidA1,
                'dataPesertaBelumValid' => $databelumvalid,
                'dataPesertaSudahValid' => $datasudahvalid,
                'status' => $batalklaim,
                'dataPesertaSudahValidProdi' => $datasudahvalidprodi,
            ];

            return view('Admin/rpl-home-asessor', $data);
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
            $datamahasiswabelumpunyaasessro = $modelPeserta->getdataPesertaBelumPunyaAsessorByProdi(session()->get('kode_prodi'), $ta_akademik);
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
                'dataMhsbelumpunyaasessor' => $datamahasiswabelumpunyaasessro
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
            $datasudahkeu = $modelPeserta->getDataPesertaAsessorSudahValidKeu(session()->get('id'), $kode_fakultas, $ta_akademik);

            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Fakultas', 'pagetitle' => 'Dashboards']),
                'ta_akademik' => $this->getTa_akademik(),
                'dataPesertaBelumValid' => $databelumvalid,
                'dataPesertaSudahValid' => $datasudahvalid,
                'validstatus' => $statusMessage,
                'dataPesertaSudahValidkeu' => $datasudahkeu,

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


    public function validdekana1($noregis, $status = 1)
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
                $modelPeserta = new ModelPesertaAsessor();

                $ModalMkA1 = new ModelMkA1();
                $namaasessor = $modelPeserta->getnamaasessor($noregis);

                $datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
                $databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
                $dataklaimAsessorA1 = $ModalMkA1->getDataKlaimAsessorA1up($noregis);
                $dataassementmandiri = $ModalAssesmentMandiri->getKlaimMk_mahasiswa($noregis);
                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Fakultas', 'pagetitle' => 'Dashboards']),
                    'nama_mhs' => $databio[0]['nama'],
                    'nm_prodi' => $this->getNamaProdi($databio[0]['kode_prodi']),
                    'jenis_rpl' => $databio[0]['jenis_rpl'],
                    'noregis' => $noregis,
                    'status' => $status,
                    'dataKlaimAsessorA1' => $dataklaimAsessorA1,
                    'nm_asessor' => $namaasessor,
                    'validstatus' => $statusMessage

                ];
                return view('Admin/rpl-validasi-dekan-a1', $data);
            } else {
                return redirect()->to(base_url('Admin'));
            }
        }
    }
    public function beritaAcaraPerMahasiswa($noregis)
    {
        $this->request = service('request');
        $db      = \Config\Database::connect();
        $noregis = $db->escapeString($noregis);
        $kode_prodi = $this->getKodeProdiBy($noregis);
        $kode_fakultas = $this->getKodeFakultasby($kode_prodi);
        $modelMkDekan = new ModelKlaimDekan();
        $cekpeserta = $modelMkDekan->chekstauspeserta($noregis);
        $modelPeserta = new ModelPesertaAsessor();

        $namaasessor = $modelPeserta->getnamaasessor($noregis);

        $makssks = $this->getmaxsks($kode_prodi);
        if ($kode_fakultas == '13123') {
            $fakultas = 'Teknik';
        } else if ($kode_fakultas == '60001') {
            $fakultas = 'Ekonomi dan Ilmu-Ilmu Sosial';
        } else if ($kode_fakultas == '11222') {
            $fakultas = 'Pascasarjana';
        };
        $dekan = $this->getNamaKaprodi($kode_prodi);

        if ($cekpeserta == null) {
            echo "Peserta Belum divalidasi dekan";
        } else {
            $Modaldokumen = new ModelDokumen();
            $ModalBiodata = new ModelBiodata();
            $ModalAssesmentMandiri = new ModelKlaimAsessor();
            $datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
            $databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
            $dataKlaimMhs = $ModalAssesmentMandiri->getDataResponAsessor($noregis);
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Fakultas', 'pagetitle' => 'Dashboards']),
                'nama_mhs' => $databio[0]['nama'],
                'nm_prodi' => $this->getNamaProdi($databio[0]['kode_prodi']),
                'jenis_rpl' => $databio[0]['jenis_rpl'],
                'noregis' => $noregis,
                'dekan' => $dekan,
                'fakultas' => $fakultas,
                'nm_asessor' => $namaasessor,

                // 'status' => $status,
                'dataKlaimMhs' => $dataKlaimMhs,
                // 'validstatus' => $statusMessage

            ];
            return view('Admin/rpl-berita-acara-permahasiswa', $data);
        }
    }
    public function beritaAcaraPerMahasiswaA1($noregis)
    {
        $Modaldokumen = new ModelDokumen();
        $ModalBiodata = new ModelBiodata();
        $ModalAssesmentMandiri = new ModelKlaimAsessor();
        $modelPeserta = new ModelPesertaAsessor();

        $ModalMkA1 = new ModelMkA1();
        $namaasessor = $modelPeserta->getnamaasessor($noregis);
        $kode_prodi = $this->getKodeProdiBy($noregis);
        $kode_fakultas = $this->getKodeFakultasby($kode_prodi);
        $datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
        $databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
        $dataklaimAsessorA1 = $ModalMkA1->getDataKlaimAsessorA1up($noregis);
        $dataassementmandiri = $ModalAssesmentMandiri->getKlaimMk_mahasiswa($noregis);

        $makssks = $this->getmaxsks($kode_prodi);
        if ($kode_fakultas == '13123') {
            $fakultas = 'Teknik';
        } else if ($kode_fakultas == '60001') {
            $fakultas = 'Ekonomi dan Ilmu-Ilmu Sosial';
        } else if ($kode_fakultas == '11222') {
            $fakultas = 'Pascasarjana';
        };
        $dekan = $this->getNamaKaprodi($kode_prodi);
        $modelMkDekan = new ModelKlaimDekan();
        $cekpeserta = $modelMkDekan->chekstauspeserta($noregis);

        if ($cekpeserta == null) {
            echo "Peserta Belum divalidasi dekan";
        } else {
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
                'dekan' => $dekan,
                'fakultas' => $fakultas,
                // 'status' => $status,
                'dataKlaimAsessorA1' => $dataklaimAsessorA1,
                'nm_asessor' => $namaasessor,
                // 'validstatus' => $statusMessage

            ];
            return view('Admin/rpl-berita-acara-permahasiswaa1', $data);
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

    public function klaimMkAsessorA1()
    {
        if (!session()->get('sttpengguna')) {
            return redirect()->to('/logout');
        } else {
            $db      = \Config\Database::connect();

            $formdata = $this->request->getPost('jsonObj');
            $lastdata = array();
            $kode_prodi = session()->get('kode_prodi');
            $ta_akademik = $this->getTa_akademik();
            $ModalTransactionKlaim = new ModelKlaimAsessor();
            $simpanklaim = $ModalTransactionKlaim->simpanklaimAsessorA1($formdata, $kode_prodi, $ta_akademik);
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
        $result1 = $db->query("select kode_fakultas from prodi where kode_prodi ='$kode_prodi' group by kode_fakultas")->getRow();

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

    public function getMatakuliahklaimperprodi($kode_prodi, $noregis)
    {

        if (!session()->get('id')) {
            return redirect()->to('/logout');
        } else {
            $db      = \Config\Database::connect();
            $result = $db->query("SELECT
								matakuliah.*,
								mk_cpmk.kode_prodi as prodi,
								mk_klaim_header.kode_matakuliah as kdmk_klaim,
								mk_klaim_header.idklaim as idklaim
								FROM
								mk_cpmk
								left JOIN matakuliah ON mk_cpmk.kode_prodi = matakuliah.kode_prodi AND mk_cpmk.kode_matakuliah = matakuliah.kode_matakuliah
								left join 
								mk_klaim_header
								on matakuliah.kode_matakuliah = mk_klaim_header.kode_matakuliah and mk_klaim_header.kode_prodi='$kode_prodi' and mk_klaim_header.no_peserta='$noregis'
								WHERE
								mk_cpmk.kode_prodi = '$kode_prodi'
									group by 
									mk_cpmk.kode_matakuliah
								order by mk_cpmk.kode_matakuliah")->getResult();

            return $result;
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

    public function dataMhsPerpodiOk($ta_akademik)
    {
        if (!session()->get('sttpengguna') || session()->get('sttpengguna') != 3) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $kode_prodi = session()->get('kode_prodi');
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
    public function menuDataMhsPerpodi()
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
                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Print Transkrip', 'pagetitle' => 'Dashboards']),
                    'ta_akademik' => $ta_akademik,
                ];
                return view('Admin/rpl-menu-data-mahasiswa-per-prodi', $data);
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
        if (!session()->get('sttpengguna') &&  (session()->get('sttpengguna') != 4 || session()->get('sttpengguna') != 6)) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $noregis = $db->escapeString($noregis);
            $kode_prodi = $this->getKodeProdiBy($noregis);
            // echo $noregis;
            // echo $kode_prodi;
            $kode_fakultas = $this->getKodeFakultasby($kode_prodi);
            if ($kode_fakultas == session()->get('kode_fakultas') || session()->get("sttpengguna") == 6) {
                // $noregis = session()->get("noregis");
                $Modaldokumen = new ModelDokumen();
                $ModalBiodata = new ModelBiodata();
                $modelMkDekan = new ModelKlaimDekan();
                $ModalAssesmentMandiri = new ModelKlaimAsessor();
                $datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
                $databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
                $modelklaimdekan = new ModelKlaimDekan();
                $result = $modelMkDekan->getDatatoPrint($noregis);
                if (session()->get('sttpengguna') == 6) {
                    $kode_fakultas = $kode_fakultas;
                } else {
                    $kode_fakultas = session()->get('kode_fakultas');
                }
                $makssks = $this->getmaxsks($kode_prodi);
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
                        'maxsks' => $makssks,
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
    public function printKlaimMk($noregis)
    {
        if (!session()->get('sttpengguna')) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $noregis = $db->escapeString($noregis);
            $kode_prodi = $this->getKodeProdiBy($noregis);
            $kode_fakultas = $this->getKodeFakultasby($kode_prodi);
            // $noregis = session()->get("noregis");
            $modelMkA1 = new ModelMkA1();

            $dataKlaimA1 = $modelMkA1->where('no_registrasi', $noregis)->findAll();

            if ($dataKlaimA1 != null) {
                $data = [
                    'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                    'page_title' => view('partials/rpl-page-title', ['title' => 'Print Transkrip', 'pagetitle' => 'Dashboards']),
                    'data_mkA1' => $dataKlaimA1,
                    'noregis' => $noregis
                ];
                return view('Front/rpl-print-klaim-a1', $data);
            } else {
                return redirect()->to(base_url('Admin'));
            }
        }
    }
    public function exportexcel($noregis)
    {
        if (!session()->get('sttpengguna') &&  (session()->get('sttpengguna') != 4 || session()->get('sttpengguna') != 6)) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $noregis = $db->escapeString($noregis);
            $kode_prodi = $this->getKodeProdiBy($noregis);
            $kode_fakultas = $this->getKodeFakultasby($kode_prodi);
            if ($kode_fakultas == session()->get('kode_fakultas') || session()->get("sttpengguna") == 6) {
                // $noregis = session()->get("noregis");
                $Modaldokumen = new ModelDokumen();
                $ModalBiodata = new ModelBiodata();
                $modelMkDekan = new ModelKlaimDekan();
                $ModalAssesmentMandiri = new ModelKlaimAsessor();
                $datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
                $databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
                $modelklaimdekan = new ModelKlaimDekan();
                $result = $modelMkDekan->getDatatoPrint($noregis);
                if (session()->get('sttpengguna') == 6) {
                    $kode_fakultas = $kode_fakultas;
                } else {
                    $kode_fakultas = session()->get('kode_fakultas');
                }
                $makssks = $this->getmaxsks($kode_prodi);
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
                        'maxsks' => $makssks,
                        'dataKlaimAsessor' => $result,


                    ];
                    return view('Admin/rpl-print-transkrip-excel', $data);
                } else {
                    return redirect()->to(base_url('Admin'));
                }
            } else {
                return redirect()->to(base_url('Admin'));
            }
        }
    }
    public function printTagihan($noregis)
    {
        if (!session()->get('noregis')) {
            if (session()->get("sttpengguna") == 5) {
                $this->request = service('request');
                $db      = \Config\Database::connect();
                // $noregis = session()->get("noregis");
                $kode_prodi = $this->getKodeProdiBy($noregis);
                $kode_fakultas = $this->getKodeFakultasby($kode_prodi);

                $Modaldokumen = new ModelDokumen();
                $ModalBiodata = new ModelBiodata();
                $modelMkDekan = new ModelKlaimDekan();
                $ModalAssesmentMandiri = new ModelKlaimAsessor();
                $datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
                $databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
                $modelklaimdekan = new ModelKlaimDekan();
                $result = $modelMkDekan->getDatatoPrint($noregis);
                // $kode_fakultas = session()->get('kode_fakultas');
                $makssks = $this->getmaxsks($kode_prodi);
                $tarifrpl = $this->gettarif($kode_prodi);
                $praakademik = $this->getPrakademik($kode_prodi);
                $sksmaxrekognisi = $this->getmaxsksrekognisi($kode_prodi);
                $bpp = $this->getBpp($kode_prodi);
                $spp = $this->getSpp($kode_prodi);
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
                        'maxsks' => $makssks,
                        "tarifrpl" => $tarifrpl,
                        "praakademik" => $praakademik,
                        "sksmaxrekognisi" => $sksmaxrekognisi,
                        "bpp" => $bpp,
                        "spp" => $spp,
                        'dataKlaimAsessor' => $result,


                    ];
                    return view('Admin/rpl-print-tagihan', $data);
                } else {

                    echo "Belum Validasi Dekan";
                }
            }
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $noregis = session()->get("noregis");
            $kode_prodi = $this->getKodeProdiBy($noregis);
            $kode_fakultas = $this->getKodeFakultasby($kode_prodi);

            $Modaldokumen = new ModelDokumen();
            $ModalBiodata = new ModelBiodata();
            $modelMkDekan = new ModelKlaimDekan();
            $ModalAssesmentMandiri = new ModelKlaimAsessor();
            $datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
            $databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
            $modelklaimdekan = new ModelKlaimDekan();
            $result = $modelMkDekan->getDatatoPrint($noregis);
            // $kode_fakultas = session()->get('kode_fakultas');
            $makssks = $this->getmaxsks($kode_prodi);
            $tarifrpl = $this->gettarif($kode_prodi);
            $makssks = $this->getmaxsks($kode_prodi);
            $tarifrpl = $this->gettarif($kode_prodi);
            $praakademik = $this->getPrakademik($kode_prodi);
            $sksmaxrekognisi = $this->getmaxsksrekognisi($kode_prodi);
            $bpp = $this->getBpp($kode_prodi);
            $spp = $this->getSpp($kode_prodi);
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
                    'maxsks' => $makssks,
                    "tarifrpl" => $tarifrpl,
                    "praakademik" => $praakademik,
                    "sksmaxrekognisi" => $sksmaxrekognisi,
                    "bpp" => $bpp,
                    "spp" => $spp,
                    'dataKlaimAsessor' => $result,


                ];
                return view('Admin/rpl-print-tagihan', $data);
            } else {
                return redirect()->to(base_url('Admin'));
            }
        }
    }
    public function getmaxsks($kode_prodi)
    {
        $db      = \Config\Database::connect();
        $result = $db->query("select sks from prodi where kode_prodi ='$kode_prodi'")->getRow();

        return $result->sks;
    }
    public function getmaxsksrekognisi($kode_prodi)
    {
        $db      = \Config\Database::connect();
        $result = $db->query("select sks_max_rekognisi from prodi where kode_prodi ='$kode_prodi'")->getRow();

        return $result->sks_max_rekognisi;
    }
    public function gettarif($kode_prodi)
    {
        $db      = \Config\Database::connect();
        $result = $db->query("select tarif from prodi where kode_prodi ='$kode_prodi'")->getRow();

        return $result->tarif;
    }
    public function getPrakademik($kode_prodi)
    {
        $db      = \Config\Database::connect();
        $result = $db->query("select prakademik from prodi where kode_prodi ='$kode_prodi'")->getRow();

        return $result->prakademik;
    }
    public function getBpp($kode_prodi)
    {
        $db      = \Config\Database::connect();
        $result = $db->query("select bpp from prodi where kode_prodi ='$kode_prodi'")->getRow();

        return $result->bpp;
    }
    public function getSpp($kode_prodi)
    {
        $db      = \Config\Database::connect();
        $result = $db->query("select spp from prodi where kode_prodi ='$kode_prodi'")->getRow();

        return $result->spp;
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

    public function getNamaKaprodi($kode_prodi)
    {
        $db      = \Config\Database::connect();
        $result = $db->query("select ka_prodi from prodi where kode_prodi ='$kode_prodi'")->getRow();
        if ($result != null) {
            $prodi = $result->ka_prodi;
        } else {
            return false;
        }
        return $prodi;
    }

    public function setupTarif()
    {
        if (!session()->get('sttpengguna') &&  (session()->get('sttpengguna') != 1)) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();

            $modelTarif = new ModelTarif();
            $tarif = $modelTarif->findAll();
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Setup Tarif', 'pagetitle' => 'SILAJU']),
                'ta_akademik' => $this->getTa_akademik(),
                'tarif' => $tarif,
            ];
            return view('Admin/rpl-setup-tarif', $data);
        }
    }
    public function setupRpl()
    {
        if (!session()->get('sttpengguna') &&  (session()->get('sttpengguna') != 1)) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();

            $modelRPL = new ModelRpl();
            $datarpl = $modelRPL->getSetupRPL();
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Setup RPL', 'pagetitle' => 'SILAJU']),
                'ta_akademik' => $this->getTa_akademik(),
                'data' => $datarpl,
            ];
            return view('Admin/rpl-setup-rpl', $data);
        }
    }
    public function updatejenisrpl()
    {
        $this->request = service('request');
        $db = \Config\Database::connect();
        $data = $this->request->getPost('data');
        $modelRPL = new ModelRpl();
        $result = $modelRPL->updatedata($data);
        echo json_encode($result, false);
    }

    public function updateTarif()
    {
        if (!session()->get('sttpengguna') &&  (session()->get('sttpengguna') != 1)) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $kode_prodi = $db->escapeString($this->request->getPost("kode_prodi"));
            $nama_prodi = $db->escapeString($this->request->getPost("nama_prodi"));
            $tarif = $db->escapeString($this->request->getPost("tarif"));
            $praakademik = $db->escapeString($this->request->getPost("praakademik"));
            $bpp = $db->escapeString($this->request->getPost("bpp"));
            $spp = $db->escapeString($this->request->getPost("spp"));
            $sksmax = $db->escapeString($this->request->getPost("sksmax"));

            $data = [
                "tarif" => $tarif,
                "prakademik" => $praakademik,
                "bpp" => $bpp,
                "spp" => $spp,
                "bpp" => $bpp,
                "sks_max_rekognisi" => $sksmax,
            ];

            $modelTarif = new ModelTarif();
            $update = $modelTarif->where('kode_prodi', $kode_prodi)->set($data)->update();

            echo json_encode($update, false);
        }
    }

    public function setupTaakademik()
    {
        if (!session()->get('sttpengguna') &&  (session()->get('sttpengguna') != 1)) {
            return redirect()->to('/logout');
        } else {
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Setup Tahun Akademik', 'pagetitle' => 'SILAJU']),
                'ta_akademik' => $this->getTa_akademik(),

            ];
            return view('Admin/rpl-setup-taakademik', $data);
        }
    }

    public function updateTaAkademik()
    {
        if (!session()->get('sttpengguna') &&  (session()->get('sttpengguna') != 1)) {
            return redirect()->to('/logout');
        } else {
            $this->request = service('request');
            $db      = \Config\Database::connect();
            $ta_akademik = $db->escapeString($this->request->getPost("ta_akademik"));

            $result = $db->query("update tb_ta_akademik set ta_akademik='$ta_akademik'");
            if ($result === true) {
                $alert = "DATA BERHASIL DISIMPAN";
            } else {
                $alert = "DATA GAGAL DISIMPAN";
            }
            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Setup Tahun Akademik', 'pagetitle' => 'SILAJU']),
                'ta_akademik' => $this->getTa_akademik(),
                'alert' => $alert,

            ];
            return view('Admin/rpl-setup-taakademik', $data);
        }
    }

    public function setupKonsentrasi()
    {
        if (!session()->get('sttpengguna') &&  (session()->get('sttpengguna') != 3)) {
            return redirect()->to('/logout');
        } else {
            // $ta_akademik = $this->getTa_akademik();
            $modelKonsentrasi = new ModelKonsentrasi();
            $prodi = session()->get('kode_prodi');
            $datakonsentrasi = $modelKonsentrasi->getDataKonsentrasiByProdi($prodi);

            $data = [
                'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
                'page_title' => view('partials/rpl-page-title', ['title' => 'Setup Konsentrasi', 'pagetitle' => 'Prodi']),
                'ta_akademik' => $this->getTa_akademik(),
                'data' => $datakonsentrasi

            ];
            return view('Admin/rpl-konsentrasi', $data);
        }
    }
    public function simpankons()
    {
        if (!session()->get('sttpengguna') &&  (session()->get('sttpengguna') != 3)) {
            return redirect()->to('/logout');
        } else {
            // $ta_akademik = $this->getTa_akademik();
            $result = [];
            $this->request = service('request');
            $db = \Config\Database::connect();

            $modelKonsentrasi = new ModelKonsentrasi();
            $prodi = session()->get('kode_prodi');
            $kode_kons = $db->escapeString($this->request->getPost('kode_kons'));
            $nama_kons = $db->escapeString($this->request->getPost('nama_kons'));
            $datakosnt = [
                "prodi" => $prodi,
                "kode_konsentrasi" => $kode_kons,
                "konsentrasi" => $nama_kons,

            ];

            $simpankons = $modelKonsentrasi->insert($datakosnt);
            // $datakonsentrasi = $modelKonsentrasi->getDataKonsentrasiByProdi($prodi);

            if ($simpankons === false) {
                $result = [
                    'status' => $simpankons,
                    'message' => $modelKonsentrasi->errors()
                ];
            } else {
                $result = [
                    'status' => $simpankons,
                    'message' => "DATA BERHASIL DISIMPAN"
                ];
            }
            echo json_encode($result, false);
        }
    }
    public function udpatekons()
    {
        if (!session()->get('sttpengguna') &&  (session()->get('sttpengguna') != 3)) {
            return redirect()->to('/logout');
        } else {
            // $ta_akademik = $this->getTa_akademik();
            $result = [];
            $this->request = service('request');
            $db = \Config\Database::connect();

            $modelKonsentrasi = new ModelKonsentrasi();
            $prodi = session()->get('kode_prodi');
            $kode_kons = $db->escapeString($this->request->getPost('kode_kons'));
            $nama_kons = $db->escapeString($this->request->getPost('nama_kons'));
            $datakosnt = [
                "prodi" => $prodi,
                // "kode_konsentrasi" => $kode_kons,
                "konsentrasi" => $nama_kons,

            ];

            $simpankons = $modelKonsentrasi->where('kode_konsentrasi', $kode_kons)->set($datakosnt)->update();
            // $datakonsentrasi = $modelKonsentrasi->getDataKonsentrasiByProdi($prodi);

            if ($simpankons === false) {
                $result = [
                    'status' => $simpankons,
                    'message' => $modelKonsentrasi->errors()
                ];
            } else {
                $result = [
                    'status' => $simpankons,
                    'message' => "DATA BERHASIL DISIMPAN"
                ];
            }
            echo json_encode($result, false);
        }
    }
    public function deletekons()
    {
        if (!session()->get('sttpengguna') &&  (session()->get('sttpengguna') != 3)) {
            return redirect()->to('/logout');
        } else {
            // $ta_akademik = $this->getTa_akademik();
            $result = [];
            $this->request = service('request');
            $db = \Config\Database::connect();

            $modelKonsentrasi = new ModelKonsentrasi();
            $prodi = session()->get('kode_prodi');
            $kode_kons = $db->escapeString($this->request->getPost('kode_kons'));

            $deletekons = $modelKonsentrasi->where('kode_konsentrasi', $kode_kons)->delete();
            // $datakonsentrasi = $modelKonsentrasi->getDataKonsentrasiByProdi($prodi);

            if ($deletekons === false) {
                $result = [
                    'status' => $deletekons,
                    'message' => $modelKonsentrasi->errors()
                ];
            } else {
                $result = [
                    'status' => $deletekons,
                    'message' => "DATA BERHASIL DISIMPAN"
                ];
            }
            echo json_encode($result, false);
        }
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
