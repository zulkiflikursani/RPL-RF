<?php

namespace App\Controllers;

use App\Models\ModalMaintenence;
use App\Models\ModelBiodata;
use App\Models\ModelDokumen;
use App\Models\ModelKeu;
use App\Models\ModelKlaimAsessor;
use App\Models\ModelKonsentrasi;
use App\Models\ModelMasterRpl;
use App\Models\ModelMkA1;
use App\Models\ModelProv;
use App\Models\ModelPtIndo;
use App\Models\ModelRegistrasi;
use App\Models\ModelTransactionKlaim;
use App\Models\ModelNilai;
use App\Models\ModelPengguna;
use PHPExcel;
use PHPExcel_IOFactory;

class Front extends BaseController
{
	protected $helpers = ['url', 'form'];
	public function index()
	{
		$modelMaintenence = new ModalMaintenence();
		$status1 = $modelMaintenence->findAll();
		$status = $status1[0]['status'];

		if ($status == 1) {
			$data = [
				'title_meta' => view('partials/rpl-title-meta', ['title' => 'Registrasi RPL']),
				'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Registrasi']),
				'ta_akademik' => $this->getTa_akademik(),
				// 'dataprov' => $dataProv,
			];
			return view('Front/rpl-pages-maintenance', $data);
		} else {
			$modelProv = new ModelProv();
			$dataProv = $modelProv->getProv();

			$data = [
				'title_meta' => view('partials/rpl-title-meta', ['title' => 'Registrasi RPL']),
				'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Registrasi']),
				'ta_akademik' => $this->getTa_akademik(),
				'dataprov' => $dataProv,
			];
			return view('Front/rpl-layouts-horizontal', $data);
		}
	}

	public function rpl_index()
	{
		$data = [
			'title_meta' => view('partials/rpl-title-meta', ['title' => 'RPL']),
			'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Registrasi']),
			'ta_akademik' => $this->getTa_akademik(),
			// 'dataprov' => $dataProv,
		];

		return view('Front/rpl-index', $data);
	}
	public function registrasi()
	{
		$this->request = service('request');
		$db      = \Config\Database::connect();
		$ModalRegisrasi = new ModelRegistrasi();
		$modelProv = new ModelProv();
		$dataProv = $modelProv->getProv();
		helper('text');
		helper('File');
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
		$nama = trim($db->escapeString($this->request->getPost("nama")));
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



		$ijazah = $this->request->getFile('ijazah');
		$identitas = $this->request->getFile('identitas');
		$buktibayar = $this->request->getFile('buktiBayar');
		$password1 =  random_string('alnum', 6);
		$valid_prodi = 0;
		// $password1 =  "5465465465d";
		$validationRule = [
			'buktiBayar' =>  [
				'label' => "Bukti Pembayaran",
				'rules' => [
					'uploaded[buktiBayar]',
					'max_size[buktiBayar,1024]',
					'mime_in[buktiBayar,application/pdf]',
				]
			],
			'ijazah' =>  [
				'label' => "Ijazah",
				'rules' => [
					'uploaded[ijazah]',
					'max_size[ijazah,1024]',
					'mime_in[ijazah,application/pdf]',
				]
			],
			'identitas' =>  [
				'label' => "identitas",
				'rules' => [
					'uploaded[identitas]',
					'max_size[identitas,1024]',
					'mime_in[identitas,application/pdf]',
				]
			],


		];


		$messages = [
			'buktiBayar' =>  [
				'mime_in' => 'File harus berformat PDF.',
				'max_size' => 'Ukuran File Bukti Pembayaran maksimal  1 MB.',
			],
			'identitas' =>  [
				'mime_in' => 'File harus berformat PDF.',
				'max_size' => 'Ukuran File identitas maksimal  1 MB.',
			],
			'ijazah' =>  [
				'mime_in' => 'File harus berformat PDF.',
				'max_size' => 'Ukuran File ijazah maksimal  1 MB.',
			],
		];
		$password = password_hash($password1, PASSWORD_BCRYPT);
		$data = [
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
			'validasi_keu' => 1,
			'validasi_regis_prodi' => 0,
			'ktkunci' => $password,
			't_lahir' => $tlahir,
			'kode_konsentrasi' => $konsentrasi,
			'ttl' => $ttl,
			'nik' => $nik,
			'didikakhir' => $pendidikan,
			'ibu_kandung' => $ibukandung,
			'jenis_rpl' => $jenis_rpl,
			'dodi' => 0
		];


		$link = base_url("Login");
		$validation = \Config\Services::validation();
		$validation->setRules($validationRule, $messages);
		if (!$validation->run()) {
			// print_r($validation = $validation->getErrors());
			$datasave = $ModalRegisrasi->where('no_peserta', $noregis)->findAll();
			$data = [
				'title_meta' => view('partials/rpl-title-meta', ['title' => 'Registrasi RPL']),
				'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
				'datasubmit' => $data,
				'dataerror' => $validation->getErrors(),
				'dataprov' => $dataProv,
			];
			return view('Front/rpl-layouts-horizontal', $data);
		} else {
			$path_to_file = "uploads/berkas/$noregis/" . "bb" . trim($noregis) . ".pdf";
			$path_to_file_identitas = "uploads/berkas/$noregis/" . "ii" . trim($noregis) . ".pdf";
			$path_to_file_ijazah = "uploads/berkas/$noregis/" . "i" . trim($noregis) . ".pdf";
			if (file_exists($path_to_file)) {
				unlink($path_to_file);
			}
			if (file_exists($path_to_file_identitas)) {
				unlink($path_to_file_identitas);
			}
			if (file_exists($path_to_file_ijazah)) {
				unlink($path_to_file_ijazah);
			}
			$buktibayar->move("uploads/berkas/$noregis", "bb" . trim($noregis) . ".pdf");
			$identitas->move("uploads/berkas/$noregis", "ii" . trim($noregis) . ".pdf");
			$ijazah->move("uploads/berkas/$noregis", "i" . trim($noregis) . ".pdf");

			$result = $ModalRegisrasi->insert($data);
			if ($result === false) {
				unlink($path_to_file);
				unlink($path_to_file_ijazah);
				unlink($path_to_file_identitas);
				$datasave = $ModalRegisrasi->where('no_peserta', $noregis)->findAll();
				$data = [
					'title_meta' => view('partials/rpl-title-meta', ['title' => 'Registrasi RPL']),
					'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
					'datasubmit' => $data,
					'dataerror' => $ModalRegisrasi->errors(),
					'dataprov' => $dataProv,
				];
				return view('Front/rpl-layouts-horizontal', $data);
			} else {
				$message = "Terima Kasih telah melakukan pendaftaran pada Program RPL Unifa  <br>
						Berikut ini user untuk login ke Sistem RPL unifa <br>
						No. Reg	: " . $noregis . "<br>
						User 	: " . $email . "<br>
						Pass 	: " . $password1 . "<br>
						Silahkan Login di " . $link . " <br>
						Kontak Keuangan 0853-3333-4681 <br>
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
						'dataprov' => $dataProv,
					];
					return view('Front/rpl-layouts-horizontal', $data);
					// Generate error
				} else {
					$datasave = $ModalRegisrasi->where('no_peserta', $noregis)->findAll();
					$data = [
						'title_meta' => view('partials/rpl-title-meta', ['title' => 'Registrasi RPL']),
						'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
						'datasubmit' => $datasave,
						'emailstatus' => $emailgo->printDebugger(['headers']),
						'status' => true,
						'dataprov' => $dataProv,

					];
					return view('Front/rpl-layouts-horizontal', $data);
				}
			}
		}
	}

	public function getProdiByRpl()
	{
		$db      = \Config\Database::connect();
		$ModelMasterRpl = new ModelMasterRpl();
		$this->request = service('request');
		$jenis_rpl = $db->escapeString($this->request->getPost("jenis_rpl"));
		$prodi = $ModelMasterRpl->getProdiByRpl($jenis_rpl);
		echo json_encode($prodi, false);
	}

	public function getKab()
	{
		$this->request = service('request');
		$db      = \Config\Database::connect();

		$a = $db->escapeString($this->request->getPost("a"));

		$modelProv = new ModelProv();
		$where = [
			"tingkat" => 2,
			"idprov" => $a

		];
		$dataKab = $modelProv->where($where)->findAll();
		// SELECT idprov,nama_wilayah from wilayah where wilayah.tingkat=2 and wilayah.idprov=95 ORDER BY nama_wilayah?

		echo json_encode($dataKab, false);
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
			$jenisrpl = $db->escapeString($this->request->getPost("jenis_rpl"));
			$ijazah = $this->request->getFile('ijazah');
			$validationRule = [
				'ijazah' =>  [
					'label' => "Ijazah",
					'rules' => [
						'uploaded[ijazah]',
						'max_size[ijazah,1024]',
						'mime_in[ijazah,application/pdf]',
					]
				],

			];
			$messages = [
				'ijazah' =>  [
					'mime_in' => 'File harus berformat PDF.',
					'max_size' => 'Ukuran File maksimal  1 MB.',
				]
			];
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
			$cekberkas = $db->query("select no_peserta from dok_portofolio where no_peserta='$noregis'")->getRow();
			$validation = \Config\Services::validation();
			$validation->setRules($validationRule, $messages);
			if (!$validation->run()) {
				$result = false;
				$datasave = $ModalBiodata->where('no_peserta', $noregis)->findAll();
				$data = [
					'title_meta' => view('partials/rpl-title-meta', ['title' => 'Registrasi RPL']),
					'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
					'datasubmit' => $data1,
					'databio' => $datasave,
					'dataerror' => $validation->getErrors(),
				];
				return view('Front/rpl-mahasiswa', $data);
			} else {
				$path_to_file = "uploads/berkas/$noregis/" . "ijazah-" . trim($noregis) . ".pdf";
				if (file_exists($path_to_file)) {
					unlink($path_to_file);
				}
				$ijazah->move("uploads/berkas/$noregis", "ijazah-" . trim($noregis) . ".pdf");
				if (!isset($cekberkas)) {
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
				} else {
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
						'didikakhir' => $didakhir,
					];
				}



				$datasave = $ModalBiodata->where('no_peserta', $noregis)->findAll();
				if ($datasave) {
					$result = $ModalBiodata->update(['no_peserta' => $noregis], $data2);
				} else {
					$result = $ModalBiodata->insert($data1);
				}
				// print_r($result);
				if ($result === false) {
					$datasave = $ModalBiodata->where('no_peserta', $noregis)->findAll();
					$modelKonsentrasi = new ModelKonsentrasi();
					$getkonsentrasi = $modelKonsentrasi->where(['kode_konsentrasi' => $datasave['kode_konsentrasi'], "kode_prodi" => $datasave['kode_prodi']])->findAll();
					$konsentrasi = $getkonsentrasi['nama_konsentrasi'];
					$data = [
						'title_meta' => view('partials/rpl-title-meta', ['title' => 'Registrasi RPL']),
						'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
						'datasubmit' => $data1,
						'databio' => $datasave,
						'konsentrasi' => $datasave['kode_konsentrasi'],
						'dataerror' => $ModalBiodata->errors(),
					];

					return view('Front/rpl-mahasiswa', $data);
				} else {
					$datasave = $ModalBiodata->where('no_peserta', $noregis)->findAll();
					$modelKonsentrasi = new ModelKonsentrasi();
					$getkonsentrasi = $modelKonsentrasi->where(['kode_konsentrasi' => $datasave['kode_konsentrasi'], "kode_prodi" => $datasave['kode_prodi']])->findAll();
					$konsentrasi = $getkonsentrasi['nama_konsentrasi'];
					$data = [
						'title_meta' => view('partials/rpl-title-meta', ['title' => 'Registrasi RPL']),
						'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
						'datasubmit' => $datasave,
						'databio' => $datasave,
						'konsentrasi' => $konsentrasi,
						'status' => true,



					];
					return view('Front/rpl-mahasiswa', $data);
				}
			}
		}
	}

	public function getKonsentrasiByProdi()
	{
		$modelKonsentrasi = new ModelKonsentrasi();
		$this->request = service('request');
		$db = \Config\Database::connect();
		$prodi = $db->escapeString($this->request->getPost('prodi'));

		$result = $modelKonsentrasi->where('prodi', $prodi)->findAll();

		echo json_encode($result, false);
	}

	public function SimpanMatakuliahA1()
	{
		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$this->request = service('request');
			$db      = \Config\Database::connect();
			$modelMkA1 = new ModelMkA1();
			$ModalBiodata = new ModelBiodata();
			$Modaldokumen = new ModelDokumen();
			$ModalPtIndo = new ModelPtIndo();
			$noregis = session()->get("noregis");
			$ModalNilai  = new ModelNilai();
			$masternilai = $ModalNilai->findAll();

			$datasavebio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
			$datadokumen = $Modaldokumen->getDataBynoregis();
			$ptindo = "";

			// $noregis = session()->get("noregis");

			$ta_akademik = $this->getTa_akademik();
			$kode_matakuliah = trim($db->escapeString($this->request->getPost("kode_matakuliah")));
			$nama_matakuliah = trim($db->escapeString($this->request->getPost("nama_matakuliah")));
			$sks = $db->escapeString($this->request->getPost("sks"));
			$nilai = $db->escapeString($this->request->getPost("Nilai"));
			$kodept = $db->escapeString($this->request->getPost("kodept"));
			$nmpt = $db->escapeString($this->request->getPost("nmpt"));
			$data1 = [
				"ta_akademik" => $ta_akademik,
				"no_registrasi" => $noregis,
				"kode_perguruan_tinggi" => $kodept,
				"nama_perguruan_tinggi" => $nmpt,
				"kode_matakuliah" => $kode_matakuliah,
				"nama_matakuliah" => $nama_matakuliah,
				"jumlah_sks" => $sks,
				"status" => 1,
				"nilai" => $nilai,
			];


			$validatemka1 = $this->validatemka1($ta_akademik, $noregis, $kode_matakuliah);
			if ($validatemka1 == null) {
				$validateStatusMkA1 = $modelMkA1->where('status', 0)
					->where('no_registrasi', $noregis)->findAll();
				if ($validateStatusMkA1 == null) {
					$insert = $modelMkA1->insert($data1);
					$carikdptasal = $modelMkA1->where('no_registrasi', $noregis)->findAll();

					if ($datasavebio[0]['dodi'] == 1) {
						$kdptasal = "091045";
						$nmptasal = "Universitas Fajar";
					} else {

						if (isset($carikdptasal[0]['no_registrasi'])) {
							$kdptasal = $carikdptasal[0]['kode_perguruan_tinggi'];
							$nmptasal = $carikdptasal[0]['nama_perguruan_tinggi'];
						} else {
							$kdptasal = "";
							$nmptasal = "";
						}
					}
					if ($insert === false) {
						$data = [
							'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Berkas']),
							'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Biodata']),
							'datasubmit' => $datasavebio,
							'datadok' => $datadokumen,
							'databio' => $datasavebio,
							'ptasal' => $ptindo,
							'kdptasal' => $kdptasal,
							'nmptasal' => $nmptasal,
							'dataerror' => $modelMkA1->errors(),
							'dataMkA1' => $carikdptasal,
							'nilai' => $masternilai,
							// 'test' => $datasave,
							'ta_akademik' => $this->getTa_akademik()
						];
						return view('Front/rpl-mahasiswa-upload-a1', $data);
					} else {
						$data = [
							'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Berkas']),
							'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Biodata']),
							'datasubmit' => $datasavebio,
							'datadok' => $datadokumen,
							'databio' => $datasavebio,
							'ptasal' => $ptindo,
							'nmptasal' => $nmptasal,
							'kdptasal' => $kdptasal,
							'status' => true,
							'dataMkA1' => $carikdptasal,
							'nilai' => $masternilai,

							// 'test' => $datasave,
							'ta_akademik' => $this->getTa_akademik()
						];
						return view('Front/rpl-mahasiswa-upload-a1', $data);
					}
				} else {
					$error = [
						"error " => "Matakuliah sudah diajukan dan tidak bisa ditambahkan lagi !",
					];
					$carikdptasal = $modelMkA1->where('no_registrasi', $noregis)->findAll();

					if ($datasavebio[0]['dodi'] == 1) {
						$kdptasal = "091045";
						$nmptasal = "Universitas Fajar";
					} else {

						if (isset($carikdptasal[0]['no_registrasi'])) {
							$kdptasal = $carikdptasal[0]['kode_perguruan_tinggi'];
							$nmptasal = $carikdptasal[0]['nama_perguruan_tinggi'];
						} else {
							$kdptasal = "";
							$nmptasal = "";
						}
					}

					$data = [
						'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Berkas']),
						'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Biodata']),
						'datasubmit' => $datasavebio,
						'datadok' => $datadokumen,
						'databio' => $datasavebio,
						'ptasal' => $ptindo,
						'kdptasal' => $kdptasal,
						'nmptasal' => $nmptasal,
						'dataerror' => $error,
						'dataMkA1' => $carikdptasal,
						'nilai' => $masternilai,
						// 'test' => $datasave,
						'ta_akademik' => $this->getTa_akademik()
					];
					return view('Front/rpl-mahasiswa-upload-a1', $data);
				}
			} else {
				$error = [
					"error " => "Kode Matakuliah sudah ditambahkan sebelumnya",
				];
				$carikdptasal = $modelMkA1->where('no_registrasi', $noregis)->findAll();

				if ($datasavebio[0]['dodi'] == 1) {
					$kdptasal = "091045";
					$nmptasal = "Universitas Fajar";
				} else {

					if (isset($carikdptasal[0]['no_registrasi'])) {
						$kdptasal = $carikdptasal[0]['kode_perguruan_tinggi'];
						$nmptasal = $carikdptasal[0]['nama_perguruan_tinggi'];
					} else {
						$kdptasal = "";
						$nmptasal = "";
					}
				}

				$data = [
					'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Berkas']),
					'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Biodata']),
					'datasubmit' => $datasavebio,
					'datadok' => $datadokumen,
					'databio' => $datasavebio,
					'ptasal' => $ptindo,
					'kdptasal' => $kdptasal,
					'nmptasal' => $nmptasal,
					'dataerror' => $error,
					'dataMkA1' => $carikdptasal,
					'nilai' => $masternilai,
					// 'test' => $datasave,
					'ta_akademik' => $this->getTa_akademik()
				];
				return view('Front/rpl-mahasiswa-upload-a1', $data);
			}
		}
	}

	public function validatemka1($ta_akademik, $noregis, $kode_matakuliah)
	{
		$this->request = service('request');
		$db      = \Config\Database::connect();
		$result = $db->query("select kode_matakuliah from dok_a1 where ta_akademik='$ta_akademik' and no_registrasi='$noregis' and kode_matakuliah='$kode_matakuliah'")->getRow();

		return $result;
	}
	public function SimpanMatakuliahA1import()
	{
		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$this->request = service('request');
			$db      = \Config\Database::connect();
			$formdata = $this->request->getPost();
			$ta_akademik = $this->getTa_akademik();
			$ModalKlamMkAi = new ModelMkA1();
			$modelMkA1 = new ModelMkA1();
			$noregis = session()->get("noregis");
			$validateStatusMkA1 = $modelMkA1->where('status', 0)
				->where('no_registrasi', $noregis)->findAll();
			if ($validateStatusMkA1 == null) {
				$simpanmk = $ModalKlamMkAi->insertdata($formdata, $ta_akademik);
			} else {
				echo "Matakuliah sudah diajukan dan tidak bisa ditambahkan lagi!";
			}
		}
	}
	public function HapusMatakuliahA1()
	{
		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$this->request = service('request');
			$db      = \Config\Database::connect();
			$modelMkA1 = new ModelMkA1();
			$ModalBiodata = new ModelBiodata();
			$Modaldokumen = new ModelDokumen();
			$ModalNilai  = new ModelNilai();
			$masternilai = $ModalNilai->findAll();

			$ModalPtIndo = new ModelPtIndo();
			$noregis = session()->get("noregis");
			$datasavebio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
			$datadokumen = $Modaldokumen->getDataBynoregis();
			$ptindo = "";

			// $noregis = session()->get("noregis");

			$ta_akademik = $this->getTa_akademik();
			$kode_matakuliah = $db->escapeString($this->request->getPost("kode_matakuliah"));
			$data1 = [
				"ta_akademik" => $ta_akademik,
				"no_registrasi" => $noregis,
				"kode_matakuliah" => $kode_matakuliah,
			];
			$dataMkA1 = $modelMkA1->where('no_registrasi', $noregis)->findAll();
			$carikdptasal = $modelMkA1->where('no_registrasi', $noregis)->findAll();

			if ($datasavebio[0]['dodi'] == 1) {
				$kdptasal = "091045";
				$nmptasal = "Universitas Fajar";
			} else {

				if (isset($carikdptasal[0]['no_registrasi'])) {
					$kdptasal = $carikdptasal[0]['kode_perguruan_tinggi'];
					$nmptasal = $carikdptasal[0]['nama_perguruan_tinggi'];
				} else {
					$kdptasal = "";
					$nmptasal = "";
				}
			}
			$cekvalidmk = $this->cekvalidmka1($noregis);
			if ($cekvalidmk == true) {
				$delete = $modelMkA1->where($data1)->delete();
				$dataMkA1 = $modelMkA1->where('no_registrasi', $noregis)->findAll();
				$carikdptasal = $modelMkA1->where('no_registrasi', $noregis)->findAll();

				if (isset($carikdptasal[0]['no_registrasi'])) {
					$kdptasal = $carikdptasal[0]['kode_perguruan_tinggi'];
					$nmptasal = $carikdptasal[0]['nama_perguruan_tinggi'];
				} else {
					$kdptasal = "";
					$nmptasal = "";
				}
				if ($delete === false) {
					$data = [
						'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Berkas']),
						'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Biodata']),
						'datasubmit' => $datasavebio,
						'datadok' => $datadokumen,
						'databio' => $datasavebio,
						'ptasal' => $ptindo,
						'kdptasal' => $kdptasal,
						'nmptasal' => $nmptasal,
						'dataerror' => $modelMkA1->errors(),
						'dataMkA1' => $dataMkA1,
						'nilai' => $masternilai,
						// 'test' => $datasave,
						'ta_akademik' => $this->getTa_akademik()
					];
					return view('Front/rpl-mahasiswa-upload-a1', $data);
				} else {
					$data = [
						'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Berkas']),
						'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Biodata']),
						'datasubmit' => $datasavebio,
						'datadok' => $datadokumen,
						'databio' => $datasavebio,
						'ptasal' => $ptindo,
						'kdptasal' => $kdptasal,
						'nmptasal' => $nmptasal,
						'statushapus' => true,
						'dataMkA1' => $dataMkA1,
						'nilai' => $masternilai,
						// 'test' => $datasave,
						'ta_akademik' => $this->getTa_akademik()
					];
					return view('Front/rpl-mahasiswa-upload-a1', $data);
				}
			} else {
				$error = ['error' => "Tidak bisa menghapus matakuliah karena sudah diajukan"];
				$data = [
					'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Berkas']),
					'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Biodata']),
					'datasubmit' => $datasavebio,
					'datadok' => $datadokumen,
					'databio' => $datasavebio,
					'ptasal' => $ptindo,
					'kdptasal' => $kdptasal,
					'nmptasal' => $nmptasal,
					'dataerror' => $error,
					'dataMkA1' => $dataMkA1,
					// 'test' => $datasave,
					'nilai' => $masternilai,
					'ta_akademik' => $this->getTa_akademik()
				];
				return view('Front/rpl-mahasiswa-upload-a1', $data);
			}
		}
	}
	public function SubmitMatakuliahA1()
	{
		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$this->request = service('request');
			$db      = \Config\Database::connect();
			$modelMkA1 = new ModelMkA1();
			$ModalBiodata = new ModelBiodata();
			$Modaldokumen = new ModelDokumen();
			$ModalPtIndo = new ModelPtIndo();
			$noregis = session()->get("noregis");
			$datasavebio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
			$datadokumen = $Modaldokumen->getDataBynoregis();
			$ptindo = "";
			$ModalNilai  = new ModelNilai();
			$masternilai = $ModalNilai->findAll();


			$dataMkA1 = $modelMkA1->where('no_registrasi', $noregis)->findAll();
			$carikdptasal = $modelMkA1->where('no_registrasi', $noregis)->findAll();

			if ($datasavebio[0]['dodi'] == 1) {
				$kdptasal = "091045";
				$nmptasal = "Universitas Fajar";
			} else {

				if (isset($carikdptasal[0]['no_registrasi'])) {
					$kdptasal = $carikdptasal[0]['kode_perguruan_tinggi'];
					$nmptasal = $carikdptasal[0]['nama_perguruan_tinggi'];
				} else {
					$kdptasal = "";
					$nmptasal = "";
				}
			}
			$data2 = [
				"status" => 0
			];
			$update = $modelMkA1->where('no_registrasi', $noregis)->set($data2)->update();
			if ($update === false) {
				$data = [
					'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Berkas']),
					'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Biodata']),
					'datasubmit' => $datasavebio,
					'datadok' => $datadokumen,
					'databio' => $datasavebio,
					'ptasal' => $ptindo,
					'kdptasal' => $kdptasal,
					'nmptasal' => $nmptasal,
					'dataerror' => $modelMkA1->errors(),
					'dataMkA1' => $dataMkA1,
					'nilai' => $masternilai,
					// 'test' => $datasave,
					'ta_akademik' => $this->getTa_akademik()
				];
			} else {
				$data = [
					'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Berkas']),
					'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Biodata']),
					'datasubmit' => $datasavebio,
					'datadok' => $datadokumen,
					'databio' => $datasavebio,
					'ptasal' => $ptindo,
					'nmptasal' => $nmptasal,
					'kdptasal' => $kdptasal,
					'status' => true,
					'dataMkA1' => $dataMkA1,
					'nilai' => $masternilai,

					// 'test' => $datasave,
					'ta_akademik' => $this->getTa_akademik()
				];
			}
			return view('Front/rpl-mahasiswa-upload-a1', $data);
		}
	}

	public function cekvalidmka1($noregis)
	{
		$modelmk = new ModelMkA1();
		$find = $modelmk->where('no_registrasi', $noregis)->findAll();
		if ($find != null) {
			foreach ($find as $row) {
				$status =  $row['status'];
				if ($status == 1) {
					return true;
				}
			}
			return false;
		}
	}
	public function importMkA1()
	{
		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$modelMkA1 = new ModelMkA1();
			$ModalBiodata = new ModelBiodata();
			$Modaldokumen = new ModelDokumen();
			$ModalPtIndo = new ModelPtIndo();
			$noregis = session()->get("noregis");
			$datasavebio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
			$datadokumen = $Modaldokumen->getDataBynoregis();
			$ptindo = $ModalPtIndo->findAll();
			$carikdptasal = $modelMkA1->where('no_registrasi', $noregis)->findAll();

			// $objPHPExcel = PHPExcel_IOFactory::load();
			if ($datasavebio[0]['dodi'] == 1) {
				$kdptasal = "091045";
				$nmptasal = "Universitas Fajar";
			} else {

				if (isset($carikdptasal[0]['no_registrasi'])) {
					$kdptasal = $carikdptasal[0]['kode_perguruan_tinggi'];
					$nmptasal = $carikdptasal[0]['nama_perguruan_tinggi'];
				} else {
					$kdptasal = "";
					$nmptasal = "";
				}
			}
			$data = [
				'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Berkas']),
				'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Biodata']),
				'datasubmit' => $datasavebio,
				'datadok' => $datadokumen,
				'databio' => $datasavebio,
				'ptasal' => $ptindo,
				'nmptasal' => $nmptasal,
				'kdptasal' => $kdptasal,
				'dataMkA1' => $carikdptasal,

				// 'test' => $datasave,
				'ta_akademik' => $this->getTa_akademik()
			];
			return view('Front/rpl-mahasiswa-import-a1', $data);
		}
	}
	function __construct()
	{
		require_once APPPATH . "/ThirdParty/PHPExcel/PHPExcel.php";
	}

	public function generateMkA1()
	{
		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$this->request = service('request');
			$db      = \Config\Database::connect();
			$modelMkA1 = new ModelMkA1();
			$ModalBiodata = new ModelBiodata();
			$Modaldokumen = new ModelDokumen();
			$ModalPtIndo = new ModelPtIndo();
			$noregis = session()->get("noregis");
			$datasavebio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
			$datadokumen = $Modaldokumen->getDataBynoregis();
			$ptindo = $ModalPtIndo->findAll();
			$carikdptasal = $modelMkA1->where('no_registrasi', $noregis)->findAll();
			$fileupload = $this->request->getFile("datamka1");
			$html = "";
			if (file_exists($fileupload)) {
				// require_once(APPPATH . 'third_party/PHPExcel/PHPExcel.php');
				$fileLocation = $fileupload->getTempName();
				$excelReader  = new PHPExcel();

				$objPHPExcel = PHPExcel_IOFactory::load($fileLocation);
				$sheet	= $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
				$totalsks = 0;
				foreach ($sheet as $idx => $data) {
					if ($idx == 1) {
						continue;
					}
					$no = floatval($idx) - 1;
					$html .= "<tr>
								<td>$no</td>
								<td for='a'>" . $data['A'] . "</td>
								<td for='b'>" . $data['B'] . "</td>
								<td for='c'>" . $data['C'] . "</td>
								<td for='d'>" . $data['D'] . "</td>
							</tr>";
					$totalsks = $totalsks + $data['C'];
				}
			} else {
				$html = '';
			}

			if ($datasavebio[0]['dodi'] == 1) {
				$kdptasal = "091045";
				$nmptasal = "Universitas Fajar";
			} else {
				if (isset($carikdptasal[0]['no_registrasi'])) {
					$kdptasal = $carikdptasal[0]['kode_perguruan_tinggi'];
					$nmptasal = $carikdptasal[0]['nama_perguruan_tinggi'];
				} else {
					$kdptasal = "";
					$nmptasal = "";
				}
			}
			$data = [
				'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Berkas']),
				'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Biodata']),
				'datasubmit' => $datasavebio,
				'datadok' => $datadokumen,
				'databio' => $datasavebio,
				'ptasal' => $ptindo,
				'kdptasal' => $kdptasal,
				'nmptasal' => $nmptasal,
				'totsks' => $totalsks,
				'dataMkA1' => $carikdptasal,
				'dataGenerate' => $html,

				// 'test' => $datasave,
				'ta_akademik' => $this->getTa_akademik()
			];
			return view('Front/rpl-mahasiswa-import-a1', $data);
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
		$modelMaintenence = new ModalMaintenence();
		$status1 = $modelMaintenence->findAll();
		$status = $status1[0]['status'];

		if ($status == 1) {
			$data = [
				'title_meta' => view('partials/rpl-title-meta', ['title' => 'Registrasi RPL']),
				'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Registrasi']),
				'ta_akademik' => $this->getTa_akademik(),
				// 'dataprov' => $dataProv,
			];
			return view('Front/rpl-pages-maintenance', $data);
		} else {
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
	}

	public function Pendaftar()
	{
		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$ModalRegisrasi = new ModelRegistrasi();
			$ModalBiodata = new ModelBiodata();
			$noregisrasi = session()->get("noregis");
			$datasave = $ModalRegisrasi->where('no_peserta', $noregisrasi)->findAll();
			$datasavebio = $ModalBiodata->where('no_peserta', $noregisrasi)->findAll();
			$prodi = $this->getNamaProdi($this->getNamaProdiFromRegis());
			if ($datasavebio != null) {
				$databio = $datasavebio;
			} else {
				$databio = $datasave;
			}
			$modelKeu = new ModelKeu();
			$validasiprodi = $datasave[0]['validasi_regis_prodi'];
			$validasikeu = $modelKeu->cekvalidasi($noregisrasi);
			$modelKonsentrasi = new ModelKonsentrasi();
			$wherekons = [
				"kode_konsentrasi" => $databio[0]['kode_konsentrasi'],
				"prodi" => $databio[0]['kode_prodi']
			];
			$getkonsentrasi = $modelKonsentrasi->where($wherekons)->findAll();
			$konsentrasi = (isset($getkonsentrasi[0]['konsentrasi']) ? $getkonsentrasi[0]['konsentrasi'] : '');
			$modelPengguna = new ModelPengguna();
			$dataPICProdi = $modelPengguna->where([
				'sttpengguna' => '7',
				'kode_prodi' => $databio[0]['kode_prodi'],
			])->findAll();



			if ($validasiprodi == 0) {
				$data = [
					'title_meta' => view('partials/rpl-title-meta', ['title' => 'Biodata Peserta RPL']),
					'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Pengumuman']),
					'datasubmit' => $databio,
					'databio' => $databio,
					'prodi' => $prodi,
					'dataPIC' => $dataPICProdi,
					// 'test' => $datasave,
					'ta_akademik' => $this->getTa_akademik()
				];
				return view('Front/rpl-mahasiswa-belum-valid-reg-prodi', $data);
			} else if ($validasikeu == null) {
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
					'konsentrasi' => $konsentrasi,
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
			$ModalBiodata = new ModelRegistrasi();
			$Modaldokumen = new ModelDokumen();
			$noregisrasi = session()->get("noregis");
			$datasavebio = $ModalBiodata->where('no_peserta', $noregisrasi)->findAll();
			$datadokumen = $Modaldokumen->getDataBynoregis();
			$ModalNilai  = new ModelNilai();
			$nilai = $ModalNilai->findAll();
			$data = [
				'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Berkas']),
				'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Biodata']),
				'datasubmit' => $datasavebio,
				'datadok' => $datadokumen,
				'databio' => $datasavebio,
				'nilai' => $nilai,
				'ta_akademik' => $this->getTa_akademik()
			];
			return view('Front/rpl-mahasiswa-upload', $data);
		}
	}
	public function Uploadberkasa1()
	{
		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$ModalBiodata = new ModelRegistrasi();
			$Modaldokumen = new ModelDokumen();
			$ModalPtIndo = new ModelPtIndo();
			$modelMkA1 = new ModelMkA1();
			$noregisrasi = session()->get("noregis");
			$datasavebio = $ModalBiodata->where('no_peserta', $noregisrasi)->findAll();
			$datadokumen = $Modaldokumen->getDataBynoregis();
			$ptindo = "";
			$ModalNilai = new ModelNilai();
			$nilai = $ModalNilai->findAll();

			$carikdptasal = $modelMkA1->where('no_registrasi', $noregisrasi)->findAll();

			if ($datasavebio[0]['dodi'] == 1) {
				$kdptasal = "091045";
				$nmptasal = "Universitas Fajar";
			} else {

				if (isset($carikdptasal[0]['no_registrasi'])) {
					$kdptasal = $carikdptasal[0]['kode_perguruan_tinggi'];
					$nmptasal = $carikdptasal[0]['nama_perguruan_tinggi'];
				} else {
					$kdptasal = "";
					$nmptasal = "";
				}
			}
			$data = [
				'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Berkas']),
				'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Biodata']),
				'datasubmit' => $datasavebio,
				'databio' => $datasavebio,
				'datadok' => $datadokumen,
				'ptasal' => $ptindo,
				'kdptasal' => $kdptasal,
				'nmptasal' => $nmptasal,
				'dataMkA1' => $carikdptasal,
				// 'test' => $datasave,
				'nilai' => $nilai,
				'ta_akademik' => $this->getTa_akademik()
			];
			return view('Front/rpl-mahasiswa-upload-a1', $data);
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
			$cekstatuskalim = $db->query("(select no_peserta from mk_klaim_header where no_peserta= '$noregis')union(select no_registrasi from dok_a1 where no_registrasi='$noregis')")->getResult();
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
			$ModalBiodata = new ModelBiodata();
			$Modaldokumen = new ModelDokumen();
			$ModalPtIndo = new ModelPtIndo();
			$modelMkA1 = new ModelMkA1();
			$jenis_file = $db->escapeString($this->request->getPost('jenis_file'));
			$nmfile = $db->escapeString($this->request->getPost('nmfile'));
			$userFile = $this->request->getFile('userFile');
			$url = $db->escapeString($this->request->getPost('url'));
			$noregis = session()->get('noregis');
			// $noregisrasi = session()->get("noregis");
			$datasavebio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
			$datadokumen = $Modaldokumen->getDataBynoregis();
			$ptindo = "";
			$ModalNilai = new ModelNilai();
			$nilai = $ModalNilai->findAll();


			$carikdptasal = $modelMkA1->where('no_registrasi', $noregis)->findAll();

			if ($datasavebio[0]['dodi'] == 1) {
				$kdptasal = "091045";
				$nmptasal = "Universitas Fajar";
			} else {

				if (isset($carikdptasal[0]['no_registrasi'])) {
					$kdptasal = $carikdptasal[0]['kode_perguruan_tinggi'];
					$nmptasal = $carikdptasal[0]['nama_perguruan_tinggi'];
				} else {
					$kdptasal = "";
					$nmptasal = "";
				}
			}
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
				'userFile' => [
					'label' => 'Dokumen',
					'rules' => [
						'uploaded[userFile]',
						'max_size[userFile,1024]',
						'mime_in[userFile,application/pdf]',

					],
				],
			];
			$messages = [
				'userFile' =>  [
					'mime_in' => 'File harus berformat PDF.',
					'max_size' => 'Ukuran File maksimal  1024.',
				]
			];

			$validation = \Config\Services::validation();
			$validation->setRules($validationRule, $messages);

			$fileName = $userFile->getName();

			$cekkalimasessor = $this->cekklaimasessor($noregis);
			$databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();


			// $cekjenisrpl = $Modaldokumen->checkJenisRPL();
			$jenisrpl = $databio[0]['jenis_rpl'];
			if ($jenisrpl == 1) {
				$datadokumen = $Modaldokumen->getDataBynoregis();
				if ($datadokumen != null) {
					$validasiRPL = 0;
				} else {
					$validasiRPL = 1;
				}
			} else {
				$validasiRPL = 1;
			}

			// if ($cekkalimasessor == null) {
			if (!$validation->run()) {
				$data['error'] = $validation->getError('userFile');
				$ModalBiodata = new ModelBiodata();
				$datadokumen = $Modaldokumen->getDataBynoregis();
				// $datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
				$databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
				$data = [
					'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Dokumen RPL']),
					'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
					'datasubmit' => $data,
					'databio' => $databio,
					'datadok' => $datadokumen,
					'ptasal' => $ptindo,
					'kdptasal' => $kdptasal,
					'nmptasal' => $nmptasal,
					'dataMkA1' => $carikdptasal,
					'nilai' => $nilai,
					// 'test' => $datasave,
					'ta_akademik' => $this->getTa_akademik(),
					'dataerror' => $validation->getErrors(),

				];
			} else {
				if ($validasiRPL == 1) {
					$userFile->move("uploads/berkas/$noregis", $fileNameRandom);
					$path_to_file = "uploads/berkas/$noregis/$fileNameRandom";
					$datadokumen = $Modaldokumen->getDataBynoregis();
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
								'databio' => $databio,
								'datasubmit' => $data,
								'datadok' => $datadokumen,
								'ptasal' => $ptindo,
								'kdptasal' => $kdptasal,
								'nmptasal' => $nmptasal,
								'dataMkA1' => $carikdptasal,
								'nilai' => $nilai,

								// 'test' => $datasave,
								'ta_akademik' => $this->getTa_akademik(),
								'dataerror' => $Modaldokumen->errors()
							];
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
								'datadok' => $datadokumen,
								'ptasal' => $ptindo,
								'kdptasal' => $kdptasal,
								'nmptasal' => $nmptasal,
								'dataMkA1' => $carikdptasal,
								'nilai' => $nilai,

								// 'test' => $datasave,
								'ta_akademik' => $this->getTa_akademik(),
								'status' => true
							];
						}
					} else {
						$ModalBiodata = new ModelBiodata();
						$databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();

						$data = [
							'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Dokumen RPL']),
							'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
							'datasubmit' => $data,
							'databio' => $databio,
							'datadok' => $datadokumen,
							'ptasal' => $ptindo,
							'kdptasal' => $kdptasal,
							'nmptasal' => $nmptasal,
							'dataMkA1' => $carikdptasal,
							'nilai' => $nilai,

							// 'test' => $datasave,
							'ta_akademik' => $this->getTa_akademik(),
							'dataerror' => $userFile->getErrorString()
						];
					}
				} else {
					$databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();
					$error = ['error' => "Tidak Bisa menambahkan file Lebih dari satu"];
					$data = [
						'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Dokumen RPL']),
						'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
						'datasubmit' => $data,
						'databio' => $databio,
						'datadok' => $datadokumen,
						'ptasal' => $ptindo,
						'kdptasal' => $kdptasal,
						'nmptasal' => $nmptasal,
						'dataMkA1' => $carikdptasal,
						'nilai' => $nilai,

						// 'test' => $datasave,
						'ta_akademik' => $this->getTa_akademik(),
						'dataerror' => $error
					];
				}
			}
			// } else {

			// 	$ModalBiodata = new ModelBiodata();
			// 	$datadokumen = $Modaldokumen->getDataBynoregis();
			// 	// $datadokumen = $Modaldokumen->where('no_peserta', $noregis)->findAll();
			// 	$databio = $ModalBiodata->where('no_peserta', $noregis)->findAll();

			// 	$error = ['error' => "Tidak Bisa menambahkan file setalah divalidasi Asessor"];
			// 	$data = [
			// 		'title_meta' => view('partials/rpl-title-meta', ['title' => 'Upload Dokumen RPL']),
			// 		'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Dashboards']),
			// 		'datadok' => $datadokumen,
			// 		'databio' => $databio,
			// 		'datasubmit' => $data,
			// 		'dataerror' => $error,
			// 		'datadok' => $datadokumen,
			// 		'ptasal' => $ptindo,
			// 		'kdptasal' => $kdptasal,
			// 		'nmptasal' => $nmptasal,
			// 		'dataMkA1' => $carikdptasal,
			// 		'nilai' => $nilai,

			// 		// 'test' => $datasave,
			// 		'ta_akademik' => $this->getTa_akademik()
			// 	];
			// }
			if ($databio[0]['jenis_rpl'] == 1) {
				return view('Front/rpl-mahasiswa-upload-a1', $data);
			} else {

				return view('Front/rpl-mahasiswa-upload', $data);
			}
		}
	}

	public function cekklaimasessor($noregis)
	{
		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$db      = \Config\Database::connect();
			$modelklaimasessor = new ModelKlaimAsessor();

			$data = $modelklaimasessor->where('no_peserta', $noregis)->findAll();
		}
		return $data;
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
				'getMatakuliah' => $this->getMatakuliahklaimperprodi($databio[0]['kode_prodi'], $noregis, $databio[0]['kode_konsentrasi']),
				'dataKlaimMhs' => $dataassementmandiri,
				'databio' => $databio,

			];
			return view('Front/rpl-assesment-mandiri-ok', $data);
		}
	}
	public function Logout()
	{
		session()->destroy();	//unet current user session 

		$modelMaintenence = new ModalMaintenence();
		$status1 = $modelMaintenence->findAll();
		$status = $status1[0]['status'];

		if ($status == 1) {
			$data = [
				'title_meta' => view('partials/rpl-title-meta', ['title' => 'Registrasi RPL']),
				'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Registrasi']),
				'ta_akademik' => $this->getTa_akademik(),
				// 'dataprov' => $dataProv,
			];
			return view('Front/rpl-pages-maintenance', $data);
		} else {
			helper(['form']);
			$data = [
				'title_meta' => view('partials/rpl-title-meta', ['title' => 'login SILAJU']),
				'page_title' => view('partials/rpl-page-title', ['title' => 'RPL', 'pagetitle' => 'Login']),
				'ta_akademik' => $this->getTa_akademik()
			];
			return view('auth/rpl-auth-login', $data);
		}
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
		$result = $db->query("select kode_prodi from bio_peserta  where no_peserta ='$noregis'")->getRow();

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
					echo "Klaim sedang diproses. Silahkan menunggu tanggapan Asessor di menu Respon Asessor ";
				} else if ($statusmk == 1) {
					$ModalTransactionKlaim->batalklaim($idklaim);
				} else if ($statusmk == 3) {
					echo "Klaim anda membutuhkan tanggapan. Silahkan melakukan tanggapan di menu Respon Asessor";
				}
			} else {
				echo $statusmk;
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
			if ($datacpmk == null) {
				$datacpmk = $this->getcpmkdetail($noregis, $kdmk);
			}
			$nama_matakulah = "";
			$sks = "";
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
			if ($datacpmk == null) {
				$datacpmk = $this->getcpmkdetail($noregis, $kdmk);
			}
			$nama_matakulah = "";
			$sks = "";
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
									AND (mk_cpmk.kode_prodi = '$kode_prodi' or (mk_cpmk.kode_prodi='0' and matakuliah.jenis_matakuliah < 3))
									LEFT JOIN mk_klaim_detail ON mk_cpmk.idcpmk = mk_klaim_detail.idcpmk
									AND mid(
										mk_klaim_detail.idklaim,
										6,
										10
									) = '$noregis'
									LEFT JOIN ref_klaim
									on mk_klaim_detail.idklaim = ref_klaim.idklaim 
									WHERE
										((matakuliah.kode_prodi = '$kode_prodi' and matakuliah.jenis_matakuliah > 2)  or (mk_cpmk.kode_prodi='0' and matakuliah.jenis_matakuliah < 3)) and matakuliah.kode_matakuliah='$kode_matakuliah' and mk_cpmk.idcpmk is not null
									ORDER BY
										matakuliah.kode_matakuliah, mk_cpmk.idcpmk 
									")->getResult();

			return $result;
		}
	}
	public function getcpmkdetail($noregis, $kdmk)
	{
		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$db      = \Config\Database::connect();
			$noregis = session()->get('noregis');

			$kode_prodi = $this->getkodeprodi(session()->get('noregis'));
			// $kode_matakuliah = $db->escapeString($this->request->getPost('kdmk'));
			$result = $db->query("SELECT
							mk_klaim_header.idklaim,
							mk_klaim_header.ta_akademik,
							mk_klaim_header.kode_matakuliah,
							mk_klaim_header.nama_matakuliah,
							mk_klaim_header.sks,
							mk_klaim_detail.idcpmk,
							mk_klaim_detail.cpmk
							FROM
							mk_klaim_header
							left JOIN mk_klaim_detail ON mk_klaim_header.idklaim = mk_klaim_detail.idklaim
							WHERE
							mid(mk_klaim_header.idklaim,6,10)='$noregis' and mk_klaim_header.kode_matakuliah='$kdmk'")->getResult();

			return $result;
		}
	}

	public function getJenjang($kode_prodi)
	{
		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$db = \Config\Database::connect();
			$result = $db->query("select id_jenjang from prodi where kode_prodi ='$kode_prodi'")->getRow();
			return $result->id_jenjang;
		}
	}
	public function getMatakuliahklaimperprodi($kode_prodi, $noregis, $kode_konsentrasi)
	{

		if (!session()->get('noregis')) {
			return redirect()->to('/logout');
		} else {
			$db      = \Config\Database::connect();
			$ta_akademik = $this->getTa_akademik();
			$id_jenjang = $this->getJenjang($kode_prodi);
			$mku = "";
			if ($id_jenjang == "S2-R") {
			} else {
				$mku = "(
					SELECT
						matakuliah.kode_matakuliah,
						matakuliah.nama_matakuliah,
						matakuliah.kode_prodi,
						matakuliah.sks			
						FROM
					matakuliah
				LEFT JOIN mk_cpmk ON (
					
					matakuliah.kode_matakuliah = mk_cpmk.kode_matakuliah and mk_cpmk.ta_akademik='$ta_akademik'
				)
				WHERE
					 matakuliah.kode_prodi='0' and (matakuliah.jenis_matakuliah='1' or matakuliah.jenis_matakuliah='2')
				AND mk_cpmk.kode_matakuliah IS NOT NULL 
				)
				union";
			};

			$result = $db->query("SELECT
									mm.kode_matakuliah,
									mm.nama_matakuliah,
									mm.sks,
									mm.kode_prodi,
									-- mk_cpmk.kode_prodi AS prodi,
									mm.kode_matakuliah AS kdmk_klaim,
									mk_klaim_header.idklaim AS idklaim
								FROM
									(
										$mku
										(
											SELECT
												matakuliah.kode_matakuliah,
												matakuliah.nama_matakuliah,
												matakuliah.kode_prodi,
												matakuliah.sks			
												FROM
											matakuliah
										LEFT JOIN mk_cpmk ON (
											matakuliah.kode_prodi = mk_cpmk.kode_prodi
											AND matakuliah.kode_matakuliah = mk_cpmk.kode_matakuliah and mk_cpmk.ta_akademik='$ta_akademik'
										)
										WHERE
										matakuliah.kode_prodi = '$kode_prodi' and (matakuliah.kode_konsentrasi='$kode_konsentrasi' or matakuliah.kode_konsentrasi='' or matakuliah.kode_konsentrasi IS NULL) and matakuliah.jenis_matakuliah>'2'
										AND mk_cpmk.kode_matakuliah IS NOT NULL
										)
										UNION
											(
												SELECT
													mk_klaim_header.kode_matakuliah,
													mk_klaim_header.nama_matakuliah,
													mk_klaim_header.kode_prodi,
													mk_klaim_header.sks
												FROM
													mk_klaim_header
												WHERE
													mk_klaim_header.no_peserta = '$noregis'
											)
										) mm
										
										LEFT JOIN mk_klaim_header ON mm.kode_matakuliah = mk_klaim_header.kode_matakuliah
										AND mk_klaim_header.kode_prodi = '$kode_prodi'
										AND mk_klaim_header.no_peserta = '$noregis'
										GROUP BY
											mm.kode_matakuliah
										ORDER BY
											mm.kode_matakuliah")->getResult();

			return $result;
		}
	}
	public function searchtpasal()
	{
		$db      = \Config\Database::connect();
		$search = $db->escapeString($this->request->getPost('searchTerm'));
		$data = [];
		if (strlen($search) > 2) {

			$result = $db->query("select kode_perguruan_tinggi, nama_perguruan_tinggi from perguruan_tinggi where nama_perguruan_tinggi like '%$search%'")->getResult();
			if ($result != null) {
				foreach ($result as $row) {
					$data[] = array("id" => $row->kode_perguruan_tinggi, "text" => $row->nama_perguruan_tinggi,);
				}
			}

			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}
	//--------------------------------------------------------------------

}
