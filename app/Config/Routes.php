<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Front');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// Authentication Routing ---- Removed 
// $routes->match(['get', 'post'], 'auth-login', 'AuthController::login');
// $routes->match(['get', 'post'], 'auth-register', 'AuthController::register');
// $routes->match(['get', 'post'], 'auth-recoverpw', 'AuthController::recoverpw');
// $routes->match(['get', 'post'], 'auth-updatepw', 'AuthController::updatepw');
// $routes->get('auth-logout', 'AuthController::logout');

$routes->get('/', 'Front::rpl_index');
$routes->get('/registrasi', 'Front::index');
$routes->get('/index', 'Front::rpl_index');
$routes->get('/home', 'Front::index');
$routes->get('/Biodata', 'Front::Pendaftar');
$routes->get('/logout', 'Front::Logout');
$routes->get('/upload', 'Front::Uploadberkas');
$routes->get('/importmka1', 'Front::importMkA1');
$routes->get('/uploada1', 'Front::Uploadberkasa1');
$routes->get('/assesment-mandiri', 'Front::AssesmentMandiri');
$routes->get('/respon-asessor', 'Front::AsessmentRespon');
$routes->get('/form-assesment/(:any)', 'Front::AssesmentMandiri_mk/$1');
$routes->get('/form-tanggapan/(:any)', 'Front::tanggapanAsessmentMhs/$1');

// FRONT POST
$routes->post('Front/Registrasi', 'Front::Registrasi');
$routes->post('/getProdiByRpl', 'Front::getProdiByRpl');
$routes->post('Front/SimpanMatakuliahA1', 'Front::SimpanMatakuliahA1');
$routes->post('Front/HapusMatakuliahA1', 'Front::HapusMatakuliahA1');
$routes->post('Front/SubmitMatakuliahA1', 'Front::SubmitMatakuliahA1');
$routes->post('generatemka1', 'Front::generateMkA1');
$routes->post('simpanklaimimport', 'Front::SimpanMatakuliahA1import');
$routes->post('Simpanberkas', 'Front::Simpanberkas');
$routes->post('klaimmk', 'Front::Klaimmk');
$routes->post('ajukantanggapan', 'Front::ajukanKlaimmk');
$routes->post('batalklaimmk', 'Front::batalKlaimmk');
$routes->post('simpanklaimmk', 'Front::SimpanKlaimmk');
$routes->post('getCpmk', 'Front::getcpmk');
$routes->post('deldok', 'Front::deleteDokumen');
$routes->post('getKab', 'Front::getKab');
$routes->post('searchtpasal', 'Front::searchtpasal');
$routes->post('konsentrasi-by-prodi', 'Front::getKonsentrasiByProdi');
$routes->post('updatebuktibayarmhs', 'Front::updateBuktiByrMhs');
$routes->post('updateidentitasmhs', 'Front::updateIdentitasMhs');
$routes->post('updateijazahmhs', 'Front::updateIjazahMhs');
$routes->post('setBiodataMhs', 'Front::setBiodataMhs');



//LOGIN
$routes->get('/Login', 'Front::login');
$routes->get('/login', 'Front::login');
//LOGIN AUTH
$routes->post('Auth/Login', 'AuthController::Login');


//Admin
$routes->get('/Admin', 'Admin::index');
$routes->get('/pengguna', 'Admin::pengguna');
$routes->get('/log-pengguna', 'Admin::log_activity');
$routes->get('/asessor', 'Admin::Asessor');
$routes->get('/dataasessor', 'Admin::dataAsessor');
$routes->get('/data-peserta', 'Admin::dataPeserta');
$routes->get('/data-peserta/(:any)', 'Admin::dataPeserta1/$1');
$routes->get('/statusklaim', 'Admin::datastatusklaim');
$routes->get('/cpmk', 'Admin::inputcpmk');
$routes->get('/cpmk-prodi', 'Admin::inputcpmk_prodi');
$routes->get('/mk-prodi', 'Admin::inputmk_prodi');
$routes->get('/mk-admin', 'Admin::inputmk_admin');
$routes->get('/resetpassmhs', 'Admin::resetpassmhs');
$routes->get('/tanggapanasessor/(:any)', 'Admin::tanggapanAsessor/$1');
$routes->get('/unvalidasessor/(:any)', 'Admin::batalklaimasessor/$1');
$routes->get('/tanggapanasessora1/(:any)', 'Admin::tanggapanAsessorA1/$1');
$routes->get('/validprodi/(:any)/(:any)', 'Admin::validprodi/$1/$2');
$routes->get('/validprodia1/(:any)/(:any)', 'Admin::validprodia1/$1/$2');
$routes->get('/validprodia1/(:any)', 'Admin::validprodia1/$1');
$routes->get('/validprodi/(:any)', 'Admin::validprodi/$1');
$routes->get('/validdekan/(:any)/(:any)', 'Admin::validdekan/$1/$2');
$routes->get('/validdekana1/(:any)/(:any)', 'Admin::validdekana1/$1/$2');
$routes->get('/validdekan/(:any)/', 'Admin::validdekan/$1');
$routes->get('/validdekana1/(:any)/', 'Admin::validdekana1/$1');
$routes->get('/bamahasiswaa1/(:any)/', 'Admin::beritaAcaraPerMahasiswaa1/$1');
$routes->get('/bamahasiswa/(:any)/', 'Admin::beritaAcaraPerMahasiswa/$1');
$routes->get('/data-asessor-prodi', 'Admin::data_asessor_prodi');
$routes->get('/data-keuangan', 'Admin::dataKeuangan');
$routes->get('/setup-tarif', 'Admin::setupTarif');
$routes->get('/asessia1', 'Admin::asessiA1');
$routes->get('/daftar-mk-rpl-prodi', 'Admin::daftarMkRplProdi');
$routes->get('/daftar-mk-rpl-admin', 'Admin::daftarMkRplAdmin');
//report
$routes->get('/print-transkrip/(:any)/', 'Admin::printTranskrip/$1');
$routes->get('/print-tagihan/(:any)/', 'Admin::printTagihan/$1');
$routes->get('/print-klaim-a1/(:any)/', 'Admin::printKlaimMk/$1');
$routes->get('/data-status-mhs/(:any)/', 'Admin::statusMhsKeu/$1');

$routes->get('/convert-excel/(:any)/', 'Admin::exportexcel/$1');
$routes->get('/data-mhs-per-prodi/(:any)', 'Admin::dataMhsPerpodiOk/$1');
$routes->get('/menu-data-mhs-per-prodi', 'Admin::menuDataMhsPerpodi');
$routes->get('/menu-rekap-mhs-per-periode', 'Admin::menuRekapMhsPerperiode');
$routes->get('/data-asessi-prodi', 'Admin::data_asessi_prodi');
$routes->get('/adminklaim', 'Admin::adminklaimmhs');
$routes->get('/setup-taakademik', 'Admin::setupTaakademik');
$routes->get('/setup-konsentrasi', 'Admin::setupKonsentrasi');
$routes->get('/setup-rpl', 'Admin::setupRpl');
$routes->get('/biodata-mahasiswa/(:any)', 'Admin::updateBiodataMahasiswa/$1');
$routes->get('/form-nilai-mahasiswa/(:any)', 'Admin::form_nilai/$1');
$routes->get('/data-mahasiswa-siska/(:any)', 'Admin::data_mhs_siska/$1');
$routes->get('/home-akademik-2', 'Admin::home_akademik_2_nofilter');
$routes->get('/home-akademik-2/(:any)', 'Admin::home_akademik_2/$1');
$routes->get('/keuangan/(:any)', 'Admin::keuangan/$1');
$routes->get('/pt', 'Admin::perguruan_tinggi');



$routes->post('Admin/SimpanPengguna', 'Admin::SimpanPengguna');
$routes->post('hapuspengguna', 'Admin::HapusPengguna');
$routes->post('batalklaimmhs', 'Admin::batalKlaimMhs');
$routes->post('batalklaimdokA1', 'Admin::batalKlaimdokA1');
$routes->post('setBiodata', 'Admin::setBiodata');
$routes->post('updatebuktibayar', 'Admin::updataBuktiBayar');
$routes->post('updateidentitas', 'Admin::updateIdentitas');
$routes->post('updateijazah', 'Admin::updateIjazah');
$routes->post('batalasesi', 'Admin::batalAsesi');
$routes->post('getStatusMhsRpl', 'Admin::getDataStatusMhsPerProdi');
$routes->post('cekstatusmka1', 'Admin::cekStatusMkA1');



$routes->post('getlog', 'Admin::getLog');
$routes->post('getmatakuliah', 'Admin::getMatakuliah');
$routes->post('getcpmk', 'Admin::getcpmk');
$routes->post('getcpmk-admin', 'Admin::getcpmkAdmin');
$routes->post('simpancpmk', 'Admin::simpanCpmk');
$routes->post('simpanmk', 'Admin::simpanMk');
$routes->post('simpanmk-admin', 'Admin::simpanMkAdmin');
$routes->post('editcpmk', 'Admin::editCpmk');
$routes->post('editmk', 'Admin::editMk');
$routes->post('hapuscpmk', 'Admin::hapusCpmk');
$routes->post('hapusmk', 'Admin::hapusMk');
$routes->post('validasikeu', 'Admin::validKeu');
$routes->post('validasiregprodi', 'Admin::validasi_regis_prodi');
$routes->post('unvalidasikeu', 'Admin::unvalidKeu');
$routes->post('validasibayar', 'Admin::validbayarKeu');
$routes->post('unvalidasibayar', 'Admin::unvalidbayarKeu');
$routes->post('resetpassword', 'Admin::resetPassword');
$routes->post('resetpasswordprodi', 'Admin::resetPasswordProdi');
$routes->post('resetmhs', 'Admin::resetPasswordMhs');
$routes->post('getDataMhsPerAsessor', 'Admin::getDataMhsPerAsessor');
$routes->post('getdatamhsblmpunyaassessor', 'Admin::getdatamahsiswaBelumPunyaAsessor');
$routes->post('klaimmkAsessor', 'Admin::KlaimmkAsessor');
$routes->post('klaimmkAsessorA1', 'Admin::KlaimmkAsessorA1');
$routes->post('batalklaimmkAsessorA1', 'Admin::batalKlaimmkA1');
$routes->post('getDataKlaimAsessor', 'Admin::getDataKlaimasessor');
$routes->post('simpanpesertaasessor', 'Admin::simpanpesertaasessor');
$routes->post('simpanpesertaasessorprodi', 'Admin::simpanpesertaasessor_prodi');
$routes->post('setvalidprodi', 'Admin::validasiprodi');
$routes->post('setunvalidprodi', 'Admin::unvalidasiprodi');
$routes->post('setvaliddekan', 'Admin::validasidekan');
$routes->post('setunvaliddekan', 'Admin::unvalidasidekan');
$routes->post('updatetarif', 'Admin::updateTarif');
$routes->post('udpate-taakademik', 'Admin::updateTaAkademik');
$routes->post('udpate-batas-bayar', 'Admin::updateBatasPembayaran');
$routes->post('simpan-konsentrasi', 'Admin::simpankons');
$routes->post('update-konsentrasi', 'Admin::udpatekons');
$routes->post('delete-konsentrasi', 'Admin::deletekons');
$routes->post('update-mk-rpl', 'Admin::updateMkRpl');
$routes->post('update-mk-rpl-admin', 'Admin::updateMkRplAdmin');
$routes->post('update-jenisrpl', 'Admin::updatejenisrpl');
$routes->post('data-mahasiswa-siska-nim', 'Admin::data_mhs_siska_nim');
$routes->post('push-siska', 'Admin::push_siska');
$routes->post('singkron-mk-siska', 'Admin::sinkronmksiska');
$routes->post('singkron-mk-siska-mku', 'Admin::sinkronMkformku');
$routes->post('updatedatapt', 'Admin::update_perguruan_tinggi');
$routes->post('insertdatapt', 'Admin::insert_perguruan_tinggi');

// $routes->post('singkron-mk-siska-mku', 'Admin::sinkronmksiskamku');


// Api Routing
// $routes->group('api/v1', ['namespace' => 'App\Controllers\Api\V1'], function ($routes) {
// 	// Define version 1 API routes here
// 	$routes->get('data', 'ControllerApi::index');
// 	$routes->post('insert', 'ControllerApi::create');
// 	// $routes->post('users', 'UserController::create');
// 	// $routes->get('users/(:num)', 'UserController::show/$1');
// 	// $routes->put('users/(:num)', 'UserController::update/$1');
// 	// $routes->delete('users/(:num)', 'UserController::delete/$1');
// });

$routes->resource('api/v1', ['controller' => 'ControllerApi']);

//Multi-language functionality 
$routes->get('/lang/{locale}', 'Language::index');

//Layout section routing

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}