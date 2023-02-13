<?php

namespace App\Controllers;

use App\Models\ModelBiodata;
use App\Models\ModelDokumen;
use App\Models\ModelKeu;
use App\Models\ModelKlaimAsessor;
use App\Models\ModelRegistrasi;
use App\Models\ModelTransactionKlaim;

class Front extends BaseController
{
	protected $helpers = ['url', 'form'];
	public function index()
	{

		$data = [
			'title_meta' => view('partials/rpl-title-meta', ['title' => 'Registrasi RPL']),
			'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Registrasi']),
			'ta_akademik' => $this->getTa_akademik()
		];
		return view('Front/rpl-layouts-horizontal', $data);
	}

	public function registrasi()
	{
		$this->request = service('request');
		$db      = \Config\Database::connect();
		$ModalRegisrasi = new ModelRegistrasi();
		helper('text');


		$ta = $this->getTa_akademik();
		$lastnolari = $db->query("select max(right(no_registrasi,4)) as nolari from reg_peserta where left(no_registrasi,5)='$ta'")->getRow();
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
			$nolari = "0001	";
		};
		$noregis = $ta . "-" . $nolari;
		$nama = $db->escapeString($this->request->getPost("nama"));
		$alamat = $db->escapeString($this->request->getPost("alamat"));
		$kab = $db->escapeString($this->request->getPost("kab"));
		$provinsi = $db->escapeString($this->request->getPost("provinsi"));
		$email = $db->escapeString($this->request->getPost("email"));
		$instansi = $db->escapeString($this->request->getPost("instansi"));
		$nohape = $db->escapeString($this->request->getPost("nohp"));
		$prodi = $db->escapeString($this->request->getPost("prodi"));
		$password1 =  random_string('alnum', 6);
		// $password1 =  "5465465465d";
		$password = password_hash($password1, PASSWORD_BCRYPT);
		$data = [
			'ta_akademik' => $ta,
			'no_registrasi' => $noregis,
			'nama' => $nama,
			'alamat' => $alamat,
			'kotkab' => $kab,
			'propinsi' => $provinsi,
			'instansi_asal' => $instansi,
			'nohape' => $nohape,
			'email' => $email,
			'kode_prodi' => $prodi,
			'validasi_keu' => 1,
			'ktkunci' => $password,
		];


		$link = base_url("Login");

		$result = $ModalRegisrasi->insert($data);
		if ($result === false) {
			$datasave = $ModalRegisrasi->where('no_registrasi', $noregis)->findAll();
			$data = [
				'title_meta' => view('partials/rpl-title-meta', ['title' => 'Registrasi RPL']),
				'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
				'datasubmit' => $data,
				'dataerror' => $ModalRegisrasi->errors()
			];
			return view('Front/rpl-layouts-horizontal', $data);
		} else {
			$message = "Terima Kasih telah melakukan pendaftaran pada Program RPL Unifa  <br>
						Berikut ini user untuk login ke Sistem RPL unifa <br>
						No. Reg	: " . $noregis . "<br>
						User 	: " . $email . "<br>
						Pass 	: " . $password1 . "<br>
						Silahkan Login di " . $link . " <br>
						Terima kasih";
			$emailgo = \Config\Services::email();
			$emailgo->setTo($email);
			$emailgo->setFrom('rpl.unifa.2023@gmail.com', 'Admin Program RPL Unifa');
			$emailgo->setSubject('Registrasi RPL Unifa | Password Login');
			$emailgo->setMessage($message); //your message here
			if (!$emailgo->send()) {
				$data = [
					'title_meta' => view('partials/rpl-title-meta', ['title' => 'Registrasi RPL']),
					'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
					'datasubmit' => $data,
					'dataerror' => $emailgo->printDebugger(['headers']),
				];
				return view('Front/rpl-layouts-horizontal', $data);
				// Generate error
			} else {
				$datasave = $ModalRegisrasi->where('no_registrasi', $noregis)->findAll();
				$data = [
					'title_meta' => view('partials/rpl-title-meta', ['title' => 'Registrasi RPL']),
					'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
					'datasubmit' => $datasave,
					'emailstatus' => $emailgo->printDebugger(['headers']),
					'status' => true,

				];
				return view('Front/rpl-layouts-horizontal', $data);
			}
		}
	}

	public function insertbiodata()
	{
		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$this->request = service('request');
			$db      = \Config\Database::connect();
			$ModalBiodata = new ModelBiodata();

			$ta = $this->getTa_akademik();
			$noregis = session()->get("noregis");
			$nama = $db->escapeString($this->request->getPost("nama"));
			$alamat = $db->escapeString($this->request->getPost("alamat"));
			$kab = $db->escapeString($this->request->getPost("kab"));
			$provinsi = $db->escapeString($this->request->getPost("provinsi"));
			$email = $db->escapeString($this->request->getPost("email"));
			$instansi = $db->escapeString($this->request->getPost("instansi"));
			$nohape = $db->escapeString($this->request->getPost("nohp"));
			$prodi = $db->escapeString($this->request->getPost("prodi"));
			$didakhir = $db->escapeString($this->request->getPost("didakhir"));
			$jenisrpl = $db->escapeString($this->request->getPost("jenis_rpl"));
			$data1 = [
				'ta_akademik' => $ta,
				'no_peserta' => $noregis,
				'nama' => $nama,
				'alamat' => $alamat,
				'kotkab' => $kab,
				'propinsi' => $provinsi,
				'instansi_asal' => $instansi,
				'nohape' => $nohape,
				'email' => $email,
				'kode_prodi' => $prodi,
				'jenis_rpl' => $jenisrpl,
				'didikakhir' => $didakhir,
			];
			$data2 = [
				'ta_akademik' => $ta,
				'no_peserta' => $noregis,
				'nama' => $nama,
				'alamat' => $alamat,
				'kotkab' => $kab,
				'propinsi' => $provinsi,
				'instansi_asal' => $instansi,
				'nohape' => $nohape,
				// 'email' => $email,
				'kode_prodi' => $prodi,
				'jenis_rpl' => $jenisrpl,
				'didikakhir' => $didakhir,
			];


			$datasave = $ModalBiodata->where('no_peserta', $noregis)->findAll();
			if ($datasave) {
				$result = $ModalBiodata->update(['no_peserta' => $noregis], $data2);
			} else {
				$result = $ModalBiodata->insert($data1);
			}

			// print_r($result);
			if ($result === false) {
				$datasave = $ModalBiodata->where('no_peserta', $noregis)->findAll();
				$data = [
					'title_meta' => view('partials/rpl-title-meta', ['title' => 'Registrasi RPL']),
					'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
					'datasubmit' => $data1,
					'databio' => $datasave,

					'dataerror' => $ModalBiodata->errors(),
				];

				return view('Front/rpl-mahasiswa', $data);
			} else {
				$datasave = $ModalBiodata->where('no_peserta', $noregis)->findAll();
				$data = [
					'title_meta' => view('partials/rpl-title-meta', ['title' => 'Registrasi RPL']),
					'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
					'datasubmit' => $datasave,
					'databio' => $datasave,
					'status' => true,



				];
				return view('Front/rpl-mahasiswa', $data);
			}
		}
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

	public function login()
	{
		if (!session()->get('noregis') && !session()->get('id')) {
			$data = [
				'title_meta' => view('partials/rpl-title-meta', ['title' => 'login RPL']),
				'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Login']),
				'ta_akademik' => $this->getTa_akademik()
			];
			return view('auth/rpl-auth-login', $data);
		} else {
			if (session()->get('noregis')) {
				return redirect()->to('/Biodata');
			} else if (session()->get('id')) {
				return redirect()->to('/Admin');
			}
		}
	}

	public function Pendaftar()
	{
		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$ModalRegisrasi = new ModelRegistrasi();
			$ModalBiodata = new ModelBiodata();
			$noregisrasi = session()->get("noregis");
			$datasave = $ModalRegisrasi->where('no_registrasi', $noregisrasi)->findAll();
			$datasavebio = $ModalBiodata->where('no_peserta', $noregisrasi)->findAll();
			$prodi = $this->getNamaProdi($this->getNamaProdiFromRegis());
			if ($datasavebio != null) {
				$databio = $datasavebio;
			} else {
				$databio = $datasave;
			}
			$modelKeu = new ModelKeu();
			$validasikeu = $modelKeu->cekvalidasi($noregisrasi);

			if ($validasikeu == null) {
				$data = [
					'title_meta' => view('partials/rpl-title-meta', ['title' => 'Biodata Peserta RPL']),
					'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Pengumuman']),
					'datasubmit' => $databio,
					'databio' => $databio,
					'prodi' => $prodi,
					// 'test' => $datasave,
					'ta_akademik' => $this->getTa_akademik()
				];
				return view('Front/rpl-mahasiswa-belum-valid-keu', $data);
			} else {
				$data = [
					'title_meta' => view('partials/rpl-title-meta', ['title' => 'Biodata Peserta RPL']),
					'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Biodata']),
					'datasubmit' => $databio,
					'databio' => $databio,
					'prodi' => $prodi,
					// 'test' => $datasave,
					'ta_akademik' => $this->getTa_akademik()
				];
				return view('Front/rpl-mahasiswa', $data);
			}
		}
	}
	public function Uploadberkas()
	{
		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$ModalBiodata = new ModelBiodata();
			$Modaldokumen = new ModelDokumen();
			$noregisrasi = session()->get("noregis");
			$datasavebio = $ModalBiodata->where('no_peserta', $noregisrasi)->findAll();
			$datadokumen = $Modaldokumen->getDataBynoregis();
			$data = [
				'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Berkas']),
				'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Biodata']),
				'datasubmit' => $datasavebio,
				'datadok' => $datadokumen,
				'databio' => $datasavebio,
				// 'test' => $datasave,
				'ta_akademik' => $this->getTa_akademik()
			];
			return view('Front/rpl-mahasiswa-upload', $data);
		}
	}
	public function deleteDokumen()
	{
		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$db      = \Config\Database::connect();
			$noregis = session()->get('noregis');
			$nodokumen = $nmfile = $db->escapeString($this->request->getPost('nodokumen'));
			$cekstatuskalim = $db->query("select * from mk_klaim_header where no_peserta= '$noregis'")->getResult();
			$modelDokumen = new ModelDokumen();
			$data = $modelDokumen->where('no_dokumen', $nodokumen)->findAll();
			foreach ($data as $row) {
				$nmfile = $row['nmfile_asli'];
			}
			$path = $row['lokasi_file'] . "/" . $nmfile;
			if ($cekstatuskalim != null) {
				echo "Anda sudah melakukan klaim matakuliah. silahkan batalkan semua klaim untuk menghapus dokumen";
			} else {
				$modelDokumen = new ModelDokumen();
				$deletedok = $modelDokumen->where('no_dokumen', $nodokumen)->delete();
				if ($deletedok === false) {
					echo "Gagal Menghapus Dokumen";
				} else {
					$a = unlink($path);
					if ($a) {
						echo "Berhasil Menghapus Dokumen";
					} else {
						echo "Gagal Menghapus Dokumen";
					}
				}
			}
		}
	}
	public function Simpanberkas()
	{

		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$db      = \Config\Database::connect();

			$jenis_file = $db->escapeString($this->request->getPost('jenis_file'));
			$nmfile = $db->escapeString($this->request->getPost('nmfile'));
			$userFile = $this->request->getFile('userFile');
			$url = $db->escapeString($this->request->getPost('url'));
			$noregis = session()->get('noregis');

			if (empty($nmfile)) {
			} else {
				$url = '-';
			}
			$fileNameRandom = $userFile->getRandomName();


			$Modaldokumen = new ModelDokumen();
			$id_dokumen = rand(100000, 999999);
			$data = [
				"ta_akademik" => $this->getTa_akademik(),
				"no_peserta" => $noregis,
				"jenis_dokumen" => $jenis_file,
				"no_dokumen" => $id_dokumen,
				"nmfile" => $nmfile,
				"lokasi_file" => "uploads/berkas/$noregis",
				"nmfile_asli" => $fileNameRandom,
				"url" => $url,

			];

			$validationRule = [
				'userfile' => [
					'label' => 'Dokumen',
					'rules' => [
						'uploaded[userfile]',
						'max_size[userfile,5000]',
						'mime_in[userfile,aplication/pdf]',

					],
				],
			];


			$validation = \Config\Services::validation();
			$validation->setRules($validationRule);

			$fileName = $userFile->getName();

			if ($validation->hasError('userFile')) {
				$data['error'] = $validation->getError('userFile');
			} else {
				$userFile->move("uploads/berkas/$noregis", $fileNameRandom);
				$path_to_file = "uploads/berkas/$noregis/$fileNameRandom";
				if ($userFile->hasMoved()) {
					$result1 = $Modaldokumen->insert($data);
					if ($result1 === false) {
						unlink($path_to_file);
						$ModalBiodata = new ModelBiodata();
						$datadokumen = $Modaldokumen->getDataBynoregis();
						// $datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
						$databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
						$data = [
							'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Dokumen RPL']),
							'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
							'datasubmit' => $data,
							'dataerror' => $Modaldokumen->errors()
						];
						return view('Front/rpl-mahasiswa-upload', $data);
					} else {
						$ModalBiodata = new ModelBiodata();
						$datadokumen = $Modaldokumen->getDataBynoregis();
						// $datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
						$databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
						$data = [
							'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Dokumen']),
							'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
							'datadok' => $datadokumen,
							'databio' => $databio,
							'datasubmit' => $data,
							'status' => true
						];
						return view('Front/rpl-mahasiswa-upload', $data);
					}
				} else {

					$data = [
						'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Dokumen RPL']),
						'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
						'datasubmit' => $data,
						'dataerror' => $userFile->getErrorString()
					];
					return view('Front/rpl-mahasiswa-upload', $data);
				}
			}
		}
	}

	public function AsessmentRespon()
	{
		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$noregis = session()->get('noregis');
			$this->request = service('request');
			$db      = \Config\Database::connect();
			$noregis = $db->escapeString($noregis);
			// $noregis = session()->get("noregis");
			$Modaldokumen = new ModelDokumen();
			$ModalBiodata = new ModelBiodata();
			$databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
			$modelklaimasessor = new ModelKlaimAsessor();
			$result = $modelklaimasessor->getDataResponAsessor($noregis);
			// $dataassementmandiri = $ModalAssesmentMandiri->getKlaimMk_mahasiswa($noregis);
			$data = [
				'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
				'page_title' => view('partials/rpl-page-title', ['title' => 'Tanggapan Asessor', 'pagetitle' => 'Dashboards']),
				'nama_mhs' => $databio[0]['nama'],
				'nm_prodi' => $this->getNamaProdi($databio[0]['kode_prodi']),
				'jenis_rpl' => $databio[0]['jenis_rpl'],
				'databio' => $databio,

				'noregis' => $noregis,
				'dataKlaimAsessor' => $result,


			];
			return view('Front/rpl-respon-asessor', $data);
		}
	}
	public function AssesmentMandiri()
	{

		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$noregis = session()->get("noregis");
			$Modaldokumen = new ModelDokumen();
			$ModalBiodata = new ModelBiodata();
			$ModalAssesmentMandiri = new ModelTransactionKlaim();
			$datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
			$databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
			$dataassementmandiri = "";
			$data = [
				'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
				'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
				'datadok' => $datadokumen,
				'nm_prodi' => $this->getNamaProdi($databio[0]['kode_prodi']),
				'getMatakuliah' => $this->getMatakuliahklaimperprodi($databio[0]['kode_prodi'], $noregis),
				'dataKlaimMhs' => $dataassementmandiri,
				'databio' => $databio,

			];
			return view('Front/rpl-assesment-mandiri-ok', $data);
		}
	}
	public function Logout()
	{
		session()->destroy();	//unet current user session 

		helper(['form']);
		$data = [
			'title_meta' => view('partials/rpl-title-meta', ['title' => 'login SILAJU']),
			'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Login']),
			'ta_akademik' => $this->getTa_akademik()
		];
		return view('auth/rpl-auth-login', $data);
	}

	public function getNamaProdi($kode_prodi)
	{
		$db      = \Config\Database::connect();
		$result = $db->query("select * from prodi where kode_prodi ='$kode_prodi'")->getRow();

		return $result->nama_prodi;
	}
	public function getNamaProdiFromRegis()
	{
		$db      = \Config\Database::connect();
		$noregis = session()->get("noregis");
		$result = $db->query("select kode_prodi from reg_peserta  where no_registrasi ='$noregis'")->getRow();

		return $result->kode_prodi;
	}

	public function Klaimmk()
	{
		$status = 2;
		$noregis = session()->get("noregis");
		$kodeprodi = $this->getkodeprodi($noregis);
		$ta_akademik = $this->getTa_akademik();
		$ModalTransactionKlaim = new ModelTransactionKlaim();
		$dataassementmandiri = $ModalTransactionKlaim->getKlaimMk_mahasiswaAll();

		$simpanklaim = $ModalTransactionKlaim->ajukanklaim($noregis);
	}
	public function ajukanKlaimmk()
	{

		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {

			$formdata = $this->request->getPost();
			$status = 2;
			$noregis = session()->get("noregis");
			$kodeprodi = $this->getkodeprodi($noregis);

			$ta_akademik = $this->getTa_akademik();
			$ModalTransactionKlaim = new ModelTransactionKlaim();
			$dataassementmandiri = $ModalTransactionKlaim->getKlaimMk_mahasiswaAll();

			$statusklaim = "";
			$simpanklaim = $ModalTransactionKlaim->ajukantanggapanklaim($formdata, $status, $kodeprodi, $ta_akademik);
		}
	}
	public function batalKlaimmk()
	{

		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$this->request = service('request');
			$db      = \Config\Database::connect();
			$idklaim = $db->escapeString($this->request->getPost('idklaim'));
			$noregis = session()->get("noregis");
			$kodeprodi = $this->getkodeprodi($noregis);
			$ta_akademik = $this->getTa_akademik();
			$ModalTransactionKlaim = new ModelTransactionKlaim();
			$statusmk = $ModalTransactionKlaim->cekstatusmk($idklaim);
			if ($statusmk != null) {
				if ($statusmk == 2) {
					echo "Klaim sedang diproses. Silahkan menunggu tanggapan Asessor di menu Respon Asessor";
				} else if ($statusmk == 1) {
					$ModalTransactionKlaim->batalklaim($idklaim);
				}
			}
		}
	}

	public function SimpanKlaimmk()
	{

		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$formdata = $this->request->getPost();
			$status = 1;
			$noregis = session()->get("noregis");
			$kodeprodi = $this->getkodeprodi($noregis);

			$ta_akademik = $this->getTa_akademik();
			$ModalTransactionKlaim = new ModelTransactionKlaim();
			$dataassementmandiri = $ModalTransactionKlaim->getKlaimMk_mahasiswaAll();

			$statusklaim = "";
			if ($dataassementmandiri != null) {
				// print_r($dataassementmandiri);
				foreach ($dataassementmandiri as $a) {
					$statusklaim = $a['statusklaim'];
				};

				// $simpanklaim = $ModalTransactionKlaim->simpanklaim($formdata, $status, $kodeprodi, $ta_akademik);
			}
			if ($statusklaim == 2) {
				echo "Tidak bisa mengubah data karena sudah diajukan";
			} else if ($statusklaim == 1) {
				$simpanklaim = $ModalTransactionKlaim->simpanklaim($formdata, $status, $kodeprodi, $ta_akademik);
			} else {
				$simpanklaim = $ModalTransactionKlaim->simpanklaim($formdata, $status, $kodeprodi, $ta_akademik);
			}
		}
	}

	public function getkodeprodi($noregis)
	{
		$db      = \Config\Database::connect();
		$result = $db->query("select * from bio_peserta where no_peserta ='$noregis'")->getRow();
		return $result->kode_prodi;
	}
	public function getMatakuliah($kode_prodi)
	{

		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$db      = \Config\Database::connect();
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

			return $result;
		}
	}
	public function AssesmentMandiri_mk($kdmk)
	{

		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$noregis = session()->get("noregis");
			$Modaldokumen = new ModelDokumen();
			$ModalBiodata = new ModelBiodata();
			$ModalAssesmentMandiri = new ModelTransactionKlaim();
			$datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
			$databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
			$dataassementmandiri = $ModalAssesmentMandiri->getKlaimMk_mahasiswa($kdmk);
			$datacpmk = $this->getcpmk($kdmk);
			foreach ($datacpmk as $r) {
				$nama_matakulah = $r->nama_matakuliah;
				$sks = $r->sks;
			}
			$data = [
				'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
				'page_title' => view('partials/rpl-page-title', ['title' => 'Form Klaim RPL', 'pagetitle' => 'Dashboards']),
				'datadok' => $datadokumen,
				'nm_prodi' => $this->getNamaProdi($databio[0]['kode_prodi']),
				'kdmk' => $kdmk,
				'sks' => $sks,
				'nama_matakuliah' => $nama_matakulah,
				// 'getMatakuliah' => $this->getMatakuliahklaimperprodi($databio[0]['kode_prodi'], $noregis),
				'dataKlaimMhs' => $dataassementmandiri,
				'dataCpmk' => $datacpmk,
				'databio' => $databio,

			];
			return view('Front/rpl-form-klaim', $data);
		}
	}
	public function tanggapanAsessmentMhs($kdmk)
	{

		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$noregis = session()->get("noregis");
			$Modaldokumen = new ModelDokumen();
			$ModalBiodata = new ModelBiodata();
			$modelklaimasessor = new ModelKlaimAsessor();
			$where = [
				"kode_matakuliah" => $kdmk,
				"no_peserta" => $noregis
			];
			$klaimAsessor = $modelklaimasessor->where($where)->findAll();
			$ModalAssesmentMandiri = new ModelTransactionKlaim();
			$datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
			$databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
			$dataassementmandiri = $ModalAssesmentMandiri->getKlaimMk_mahasiswa($kdmk);
			$datacpmk = $this->getcpmk($kdmk);
			foreach ($datacpmk as $r) {
				$nama_matakulah = $r->nama_matakuliah;
				$sks = $r->sks;
			}
			$data = [
				'title_meta' => view('partials/rpl-title-meta', ['title' => 'SILAJU RPL']),
				'page_title' => view('partials/rpl-page-title', ['title' => 'Form Klaim RPL', 'pagetitle' => 'Dashboards']),
				'datadok' => $datadokumen,
				'nm_prodi' => $this->getNamaProdi($databio[0]['kode_prodi']),
				'kdmk' => $kdmk,
				'sks' => $sks,
				'klaimAsessor' => $klaimAsessor,
				'nama_matakuliah' => $nama_matakulah,
				// 'getMatakuliah' => $this->getMatakuliahklaimperprodi($databio[0]['kode_prodi'], $noregis),
				'dataKlaimMhs' => $dataassementmandiri,
				'dataCpmk' => $datacpmk,
				'databio' => $databio,

			];
			return view('Front/rpl-form-tanggapan-mhs', $data);
		}
	}
	public function getcpmk($kode_matakuliah)
	{
		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$db      = \Config\Database::connect();
			$noregis = session()->get('noregis');

			$kode_prodi = $this->getkodeprodi(session()->get('noregis'));
			// $kode_matakuliah = $db->escapeString($this->request->getPost('kdmk'));
			$result = $db->query("SELECT
									matakuliah.id,
									matakuliah.`status`,
									matakuliah.kode_prodi,
									matakuliah.kode_matakuliah,
									matakuliah.nama_matakuliah,
									matakuliah.sks,
									matakuliah.id_kurikulum,
									mk_cpmk.idcpmk,
									mk_cpmk.cpmk,
									ref_klaim.no_dokumen,
									mk_klaim_detail.klaim,
									mk_klaim_detail.statusklaim
									FROM
										matakuliah
									LEFT JOIN mk_cpmk ON matakuliah.kode_matakuliah = mk_cpmk.kode_matakuliah
									AND mk_cpmk.kode_prodi = '$kode_prodi'
									LEFT JOIN mk_klaim_detail ON mk_cpmk.idcpmk = mk_klaim_detail.idcpmk
									AND mid(
										mk_klaim_detail.idklaim,
										6,
										10
									) = '$noregis'
									LEFT JOIN ref_klaim
									on mk_klaim_detail.idklaim = ref_klaim.idklaim 
									WHERE
										matakuliah.kode_prodi = '$kode_prodi' and matakuliah.kode_matakuliah='$kode_matakuliah'
									ORDER BY
										matakuliah.kode_matakuliah, mk_cpmk.idcpmk
									")->getResult();

			return $result;
		}
	}
	public function getMatakuliahklaimperprodi($kode_prodi, $noregis)
	{

		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$db      = \Config\Database::connect();
			$result = $db->query("SELECT
								matakuliah.*,
								mk_klaim_header.kode_matakuliah as kdmk_klaim,
								mk_klaim_header.idklaim as idklaim
								FROM
									matakuliah
								left join 
								mk_klaim_header
								on matakuliah.kode_matakuliah = mk_klaim_header.kode_matakuliah and mk_klaim_header.kode_prodi='$kode_prodi' and mk_klaim_header.no_peserta='$noregis'
								WHERE
									matakuliah.kode_prodi = '$kode_prodi'
								order by matakuliah.kode_matakuliah")->getResult();

			return $result;
		}
	}
	//--------------------------------------------------------------------

}
