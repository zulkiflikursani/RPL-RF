<?php

namespace App\Controllers;

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
		$password = 'dkajdshkasd';
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
						Pass 	: " . $password . "<br>
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
					'status' => true,

				];
				return view('Front/rpl-layouts-horizontal', $data);
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
		$data = [
			'title_meta' => view('partials/rpl-title-meta', ['title' => 'login RPL']),
			'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Login']),
			'ta_akademik' => $this->getTa_akademik()
		];
		return view('auth/rpl-auth-login', $data);
	}
	//--------------------------------------------------------------------

}