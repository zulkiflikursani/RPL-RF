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

$routes->get('/', 'Front::index');
$routes->get('/home', 'Front::index');
$routes->get('/Biodata', 'Front::Pendaftar');
$routes->get('/logout', 'Front::Logout');
$routes->get('/upload', 'Front::Uploadberkas');
$routes->get('/assesment-mandiri', 'Front::AssesmentMandiri');
$routes->get('/respon-asessor', 'Front::AsessmentRespon');
$routes->get('/form-assesment/(:any)', 'Front::AssesmentMandiri_mk/$1');
$routes->get('/form-tanggapan/(:any)', 'Front::tanggapanAsessmentMhs/$1');

// FRONT POST
$routes->post('Front/Registrasi', 'Front::Registrasi');
$routes->post('Simpanberkas', 'Front::Simpanberkas');
$routes->post('klaimmk', 'Front::Klaimmk');
$routes->post('ajukantanggapan', 'Front::ajukanKlaimmk');
$routes->post('batalklaimmk', 'Front::batalKlaimmk');
$routes->post('simpanklaimmk', 'Front::SimpanKlaimmk');
$routes->post('getCpmk', 'Front::getcpmk');
$routes->post('deldok', 'Front::deleteDokumen');



//LOGIN
$routes->get('/Login', 'Front::login');
$routes->get('/login', 'Front::login');
//LOGIN AUTH
$routes->post('Auth/Login', 'AuthController::Login');


//Admin
$routes->get('/Admin', 'Admin::index');
$routes->get('/pengguna', 'Admin::pengguna');
$routes->get('/asessor', 'Admin::Asessor');
$routes->get('/dataasessor', 'Admin::dataAsessor');
$routes->get('/cpmk', 'Admin::inputcpmk');
$routes->get('/resetpassmhs', 'Admin::resetpassmhs');
$routes->get('/tanggapanasessor/(:any)', 'Admin::tanggapanAsessor/$1');
$routes->get('/validprodi/(:any)/(:any)', 'Admin::validprodi/$1/$2');
$routes->get('/validprodi/(:any)', 'Admin::validprodi/$1');
$routes->get('/validdekan/(:any)/(:any)', 'Admin::validdekan/$1/$2');
$routes->get('/validdekan/(:any)/', 'Admin::validdekan/$1');
//report
$routes->get('/print-transkrip/(:any)/', 'Admin::printTranskrip/$1');
$routes->get('/data-mhs-per-prodi', 'Admin::dataMhsPerpodiOk');



$routes->post('Admin/SimpanPengguna', 'Admin::SimpanPengguna');
$routes->post('getmatakuliah', 'Admin::getMatakuliah');
$routes->post('getcpmk', 'Admin::getcpmk');
$routes->post('simpancpmk', 'Admin::simpanCpmk');
$routes->post('editcpmk', 'Admin::editCpmk');
$routes->post('hapuscpmk', 'Admin::hapusCpmk');
$routes->post('validasikeu', 'Admin::validKeu');
$routes->post('unvalidasikeu', 'Admin::unvalidKeu');
$routes->post('resetpassword', 'Admin::resetPassword');
$routes->post('resetmhs', 'Admin::resetPasswordMhs');
$routes->post('getDataMhsPerAsessor', 'Admin::getDataMhsPerAsessor');
$routes->post('getdatamhsblmpunyaassessor', 'Admin::getdatamahsiswaBelumPunyaAsessor');
$routes->post('klaimmkAsessor', 'Admin::KlaimmkAsessor');
$routes->post('getDataKlaimAsessor', 'Admin::getDataKlaimasessor');
$routes->post('simpanpesertaasessor', 'Admin::simpanpesertaasessor');
$routes->post('setvalidprodi', 'Admin::validasiprodi');
$routes->post('setunvalidprodi', 'Admin::unvalidasiprodi');
$routes->post('setvaliddekan', 'Admin::validasidekan');
$routes->post('setunvaliddekan', 'Admin::unvalidasidekan');



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
