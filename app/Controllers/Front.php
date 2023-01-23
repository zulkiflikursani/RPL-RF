<?php

namespace App\Controllers;

use App\Models\ModelBiodata;
use App\Models\ModelRegistrasi;

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

		$message = "Terima Kasih telah melakukan pendaftara pada Program RPL Unifa  <br>
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
			// 'email' => $email,
			'kode_prodi' => $prodi,
			'jenis_rpl' => $jenisrpl,
			'didikakhir' => $didakhir,
		];


		$datasave = $ModalBiodata->where('no_peserta', $noregis)->findAll();
		if ($datasave) {
			$result = $ModalBiodata->update(['no_peserta' => $noregis], $data1);
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
				'databio' => $datasave[0],

				'dataerror' => $ModalBiodata->errors(),
			];

			return view('Front/rpl-mahasiswa', $data);
		} else {
			$datasave = $ModalBiodata->where('no_peserta', $noregis)->findAll();
			$data = [
				'title_meta' => view('partials/rpl-title-meta', ['title' => 'Registrasi RPL']),
				'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
				'datasubmit' => $datasave[0],
				'databio' => $datasave[0],
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
		$Modaldokumen = new ModalDokumen();
		$noregisrasi = session()->get("noregis");
		$datasavebio = $ModalBiodata->where('no_peserta', $noregisrasi)->findAll();


		$data = [
			'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Berkas']),
			'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Biodata']),
			'datasubmit' => $datasavebio,
			// 'test' => $datasave,
			'ta_akademik' => $this->getTa_akademik()
		];
		return view('Front/rpl-mahasiswa-upload', $data);
	}

	public function Logout()
	{
		session()->destroy();	//unet current user session 

		helper(['form']);
		$data = [
			'title_meta' => view('partials/rpl-title-meta', ['title' => 'login RPL']),
			'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Login']),
			'ta_akademik' => $this->getTa_akademik()
		];
		return view('auth/rpl-auth-login', $data);
	}
	//--------------------------------------------------------------------

}