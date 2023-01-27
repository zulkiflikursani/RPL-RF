<?php

namespace App\Controllers;

use App\Models\ModelBiodata;
use App\Models\ModelDokumen;
use App\Models\ModelKlaimMkDetail;
use App\Models\ModelKlaimMkHeader;
use App\Models\ModelRefKlaim;
use App\Models\ModelRegistrasi;
use App\Models\ModelTransactionKlaim;
use CodeIgniter\Files\File;

class Front extends BaseController
{
	protected $helpers = ['url', 'form'];
	public function index()
	{

		$data = [
			'title_meta' => view('partials/rpl-title-meta', ['title' => 'Registrasi RPL']),
			'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
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
			'validasi_keu' => 0,
			'ktkunci' => $password,
		];


		$link = base_url("Login");

		$message = "Terima Kasih telah melakukan pendaftarn pada Program RPL Unifa  <br>
						Berikut ada user untuk login ke Sistem RPL unifa <br>
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

		// $emailgo->setCC('another@emailHere'); //CC
		// $emailgo->setBCC('thirdEmail@emialHere'); // and BCC


		// $emailgo->send();
		if (!$emailgo->send()) {
			$email_status = $emailgo->printDebugger(['headers']);
			// Generate error
		} else {
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
		$data = [
			'title_meta' => view('partials/rpl-title-meta', ['title' => 'login RPL']),
			'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Login']),
			'ta_akademik' => $this->getTa_akademik()
		];
		return view('auth/rpl-auth-login', $data);
	}

	public function Pendaftar()
	{
		$ModalRegisrasi = new ModelRegistrasi();
		$ModalBiodata = new ModelBiodata();
		$noregisrasi = session()->get("noregis");
		$datasave = $ModalRegisrasi->where('no_registrasi', $noregisrasi)->findAll();
		$datasavebio = $ModalBiodata->where('no_peserta', $noregisrasi)->findAll();
		if ($datasavebio != null) {
			$databio = $datasavebio;
		} else {
			$databio = $datasave;
		}
		$data = [
			'title_meta' => view('partials/rpl-title-meta', ['title' => 'Bidata Peserta RPL']),
			'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Biodata']),
			'datasubmit' => $databio,
			'databio' => $databio,
			// 'test' => $datasave,
			'ta_akademik' => $this->getTa_akademik()
		];
		return view('Front/rpl-mahasiswa', $data);
	}
	public function Uploadberkas()
	{
		$ModalBiodata = new ModelBiodata();
		$Modaldokumen = new ModelDokumen();
		$noregisrasi = session()->get("noregis");
		$datasavebio = $ModalBiodata->where('no_peserta', $noregisrasi)->findAll();
		$datadokumen = $Modaldokumen->where('no_peserta', $noregisrasi)->findAll();
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
	public function Simpanberkas()
	{
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

		$Modaldokumen = new ModelDokumen();
		$id_dokumen = rand(100000, 999999);
		$data = [
			"ta_akademik" => $this->getTa_akademik(),
			"no_peserta" => $noregis,
			"jenis_dokumen" => $jenis_file,
			"no_dokumen" => $id_dokumen,
			"nmfile" => $nmfile,
			"lokasi_file" => "uploads/berkas/$noregis",
			"nmfile_asli" => $userFile->getRandomName(),
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
		$fileNameRandom = $userFile->getRandomName();

		if ($validation->hasError('userFile')) {
			$data['error'] = $validation->getError('userFile');
		} else {
			$userFile->move("uploads/berkas/$noregis", $fileNameRandom);
			$path_to_file = "uploads/berkas/$noregis/$fileNameRandom";
			if ($userFile->hasMoved()) {
				$result1 = $Modaldokumen->insert($data);
				if ($result1 === false) {
					unlink($path_to_file);
					$data = [
						'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Dokumen RPL']),
						'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
						'datasubmit' => $data,
						'dataerror' => $Modaldokumen->errors()
					];
					return view('Front/rpl-mahasiswa-upload', $data);
				} else {
					$ModalBiodata = new ModelBiodata();
					$datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
					$databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
					$data = [
						'title_meta' => view('partials/rpl-title-meta', ['title' => 'Registrasi RPL']),
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

	public function AssesmentMandiri()
	{
		$noregis = session()->get("noregis");
		$Modaldokumen = new ModelDokumen();
		$ModalBiodata = new ModelBiodata();
		$ModalAssesmentMandiri = new ModelTransactionKlaim();
		$datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
		$databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
		$dataassementmandiri = $ModalAssesmentMandiri->getKlaimMk_mahasiswa();
		$data = [
			'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Dokumen RPL']),
			'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
			'datadok' => $datadokumen,
			'nm_prodi' => $this->getNamaProdi($databio[0]['kode_prodi']),
			'getMatakuliah' => $this->getMatakuliah($databio[0]['kode_prodi']),
			'dataKlaimMhs' => $dataassementmandiri,
			'databio' => $databio,

		];
		return view('Front/rpl-assesment-mandiri', $data);
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

	public function Klaimmk()
	{
		$formdata = $this->request->getPost();
		$lastdata = array();
		$noregis = session()->get("noregis");
		$kodeprodi = $this->getkodeprodi($noregis);
		$db      = \Config\Database::connect();
		$ModalMkHeader = new ModelKlaimMkHeader();
		$ModalMkDetail = new ModelKlaimMkDetail();
		$ModalRefKlaim = new ModelRefKlaim();
		$ta_akademik = $this->getTa_akademik();
		$ModalTransactionKlaim = new ModelTransactionKlaim();

		$simpanklaim = $ModalTransactionKlaim->simpanklaim($formdata, $kodeprodi, $ta_akademik);

		// $this->db->transOff();
		// $db->transStart();
		// $idklaim1 = "";
		// foreach ($formdata['jsonObj'] as $a) {
		// 	$idklaim = $ta_akademik . $noregis . $a['kdmk'];

		// 	// $kdmk = $a['kdmk'];
		// 	$dataMKHeader = [
		// 		"idklaim" => $idklaim,
		// 		"ta_akademik" => $ta_akademik,
		// 		"no_peserta" => $noregis,
		// 		"kode_prodi" => $kodeprodi,
		// 		"kode_matakuliah" => $a['kdmk'],
		// 		"nama_matakuliah" => $a['nmmk'],
		// 		"sks" => $a['sks'],
		// 	];
		// 	$dataMKdetail = [
		// 		"idklaim" => $idklaim,
		// 		"idcpmk" => $a['idcpmk'],
		// 		"cpmk" => $a['cpmk'],
		// 		"klaim" => $a['nilai'],
		// 		"statusklaim" => 1,
		// 	];
		// 	if ($idklaim1 != $idklaim) {
		// 		$insertMkheader = $ModalMkHeader->insert($dataMKHeader);
		// 		$idklaim1 = $idklaim;
		// 	}
		// 	$insertMkhdetail = $ModalMkDetail->insert($dataMKdetail);
		// 	foreach ($a['ref'] as $ref) {
		// 		$dataRef = [
		// 			"idklaim" => $idklaim,
		// 			"kode_matakuliah" => $a['kdmk'],
		// 			"no_dokumen" => $ref,
		// 			"lokasi_file" => "-",
		// 			"nmfile_asli" => "-",
		// 		];
		// 		$insertRefKlaim = $ModalRefKlaim->insert($dataRef);
		// 	}
		// }
		// if ($db->transStatus() === false && $insertMkheader && $insertMkhdetail && $insertRefKlaim) {
		// 	$db->transRollback();
		// 	print_r($ModalMkHeader->errors());
		// 	print_r($ModalMkDetail->errors());
		// 	print_r($ModalRefKlaim->errors());
		// } else {
		// 	$db->transCommit();
		// 	print_r($ModalMkHeader->errors());
		// 	print_r($ModalMkDetail->errors());
		// 	print_r($ModalRefKlaim->errors());
		// 	echo "sukses" . $db->transStatus();
		// }

		// print_r($formdata);
		// echo "masuk";
	}

	public function getkodeprodi($noregis)
	{
		$db      = \Config\Database::connect();
		$result = $db->query("select * from bio_peserta where no_peserta ='$noregis'")->getRow();

		return $result->kode_prodi;
	}
	public function getMatakuliah($kode_prodi)
	{
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
	//--------------------------------------------------------------------

}