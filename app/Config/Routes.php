<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

/**
 * ROUTES HALAMAN LANDING PAGE
 */
$routes->get('/', 'Landing::index');

/**
 * ROUTES HALAMAN ADMIN
 */
$routes->get('/home', 'Home::index', ['filter' => 'role:admin,useropd']);

// master-user
$routes->get('/master-user', 'UserController::index', ['filter' => 'role:admin']);
$routes->match(['get', 'post'], '/master-user/data', 'UserController::getData', ['filter' => 'role:admin']);
$routes->get('/master-user/create', 'UserController::create', ['filter' => 'role:admin']);
$routes->post('/master-user/store', 'UserController::store', ['filter' => 'role:admin']);
$routes->get('/master-user/edit/(:num)', 'UserController::edit/$1', ['filter' => 'role:admin']);
$routes->post('/master-user/update', 'UserController::update', ['filter' => 'role:admin']);
$routes->get('/master-user/delete/(:num)', 'UserController::delete/$1', ['filter' => 'role:admin']);

// master-slider
$routes->get('/master-slider', 'SliderController::index', ['filter' => 'role:admin']);
$routes->match(['get', 'post'], '/master-slider/data', 'SliderController::getData', ['filter' => 'role:admin']);
$routes->get('/master-slider/create', 'SliderController::create', ['filter' => 'role:admin']);
$routes->post('/master-slider/store', 'SliderController::store', ['filter' => 'role:admin']);
$routes->get('/master-slider/edit/(:num)', 'SliderController::edit/$1', ['filter' => 'role:admin']);
$routes->post('/master-slider/update', 'SliderController::update', ['filter' => 'role:admin']);
$routes->get('/master-slider/delete/(:num)', 'SliderController::delete/$1', ['filter' => 'role:admin']);

// master-ruang
$routes->get('/master-ruang', 'RuangController::index', ['filter' => 'role:admin']);
$routes->match(['get', 'post'], '/master-ruang/data', 'RuangController::getData', ['filter' => 'role:admin']);
$routes->get('/master-ruang/create', 'RuangController::create', ['filter' => 'role:admin']);
$routes->post('/master-ruang/store', 'RuangController::store', ['filter' => 'role:admin']);
$routes->get('/master-ruang/edit/(:num)', 'RuangController::edit/$1', ['filter' => 'role:admin']);
$routes->post('/master-ruang/update', 'RuangController::update', ['filter' => 'role:admin']);
$routes->get('/master-ruang/delete/(:num)', 'RuangController::delete/$1', ['filter' => 'role:admin']);

// master-ketentuan
$routes->get('/master-ketentuan', 'KetentuanController::index', ['filter' => 'role:admin']);
$routes->match(['get', 'post'], '/master-ketentuan/data', 'KetentuanController::getData', ['filter' => 'role:admin']);
$routes->get('/master-ketentuan/create', 'KetentuanController::create', ['filter' => 'role:admin']);
$routes->post('/master-ketentuan/store', 'KetentuanController::store', ['filter' => 'role:admin']);
$routes->get('/master-ketentuan/edit/(:num)', 'KetentuanController::edit/$1', ['filter' => 'role:admin']);
$routes->post('/master-ketentuan/update', 'KetentuanController::update', ['filter' => 'role:admin']);
$routes->get('/master-ketentuan/delete/(:num)', 'KetentuanController::delete/$1', ['filter' => 'role:admin']);

// setting-tentang-kami
$routes->get('/setting-tentang-kami', 'TentangKamiController::index', ['filter' => 'role:admin']);
$routes->post('/setting-tentang-kami/store', 'TentangKamiController::store', ['filter' => 'role:admin']);
$routes->post('/setting-tentang-kami/update', 'TentangKamiController::update', ['filter' => 'role:admin']);

// setting-pertanyaan
$routes->get('/setting-pertanyaan', 'PertanyaanController::index', ['filter' => 'role:admin']);
$routes->match(['get', 'post'], '/setting-pertanyaan/data', 'PertanyaanController::getData', ['filter' => 'role:admin']);
$routes->get('/setting-pertanyaan/create', 'PertanyaanController::create', ['filter' => 'role:admin']);
$routes->post('/setting-pertanyaan/store', 'PertanyaanController::store', ['filter' => 'role:admin']);
$routes->get('/setting-pertanyaan/edit/(:num)', 'PertanyaanController::edit/$1', ['filter' => 'role:admin']);
$routes->post('/setting-pertanyaan/update', 'PertanyaanController::update', ['filter' => 'role:admin']);
$routes->get('/setting-pertanyaan/delete/(:num)', 'PertanyaanController::delete/$1', ['filter' => 'role:admin']);

// setting-kontak-kami
$routes->get('/setting-kontak-kami', 'KontakKamiController::index', ['filter' => 'role:admin']);
$routes->post('/setting-kontak-kami/store', 'KontakKamiController::store', ['filter' => 'role:admin']);
$routes->post('/setting-kontak-kami/update', 'KontakKamiController::update', ['filter' => 'role:admin']);

// peminjaman-ruang-opd
$routes->get('/peminjaman-ruang-opd', 'PeminjamanRuangOpdController::index', ['filter' => 'role:useropd']);
$routes->match(['get', 'post'], '/peminjaman-ruang-opd/data', 'PeminjamanRuangOpdController::getData', ['filter' => 'role:useropd']);
$routes->get('/peminjaman-ruang-opd/create', 'PeminjamanRuangOpdController::create', ['filter' => 'role:useropd']);
$routes->post('/peminjaman-ruang-opd/timeline', 'PeminjamanRuangOpdController::timeline', ['filter' => 'role:useropd']);
$routes->post('/peminjaman-ruang-opd/store', 'PeminjamanRuangOpdController::store', ['filter' => 'role:useropd']);
$routes->get('/peminjaman-ruang-opd/edit/(:num)', 'PeminjamanRuangOpdController::edit/$1', ['filter' => 'role:useropd']);
$routes->get('/peminjaman-ruang-opd/detail/(:num)', 'PeminjamanRuangOpdController::detail/$1', ['filter' => 'role:useropd']);
$routes->post('/peminjaman-ruang-opd/update', 'PeminjamanRuangOpdController::update', ['filter' => 'role:useropd']);
$routes->get('/peminjaman-ruang-opd/delete/(:num)', 'PeminjamanRuangOpdController::delete/$1', ['filter' => 'role:useropd']);
$routes->get('/peminjaman-ruang-opd/cetak/(:num)', 'PeminjamanRuangOpdController::cetak/$1', ['filter' => 'role:useropd']);

// verifikasi-peminjaman-ruang
$routes->get('/verifikasi-peminjaman-ruang', 'VerifikasiPeminjamanRuangController::index', ['filter' => 'role:admin']);
$routes->match(['get', 'post'], '/verifikasi-peminjaman-ruang/data', 'VerifikasiPeminjamanRuangController::getData', ['filter' => 'role:admin']);
$routes->get('/verifikasi-peminjaman-ruang/detail/(:num)', 'VerifikasiPeminjamanRuangController::detail/$1', ['filter' => 'role:admin']);
$routes->get('/verifikasi-peminjaman-ruang/cetak/(:num)', 'VerifikasiPeminjamanRuangController::cetak/$1', ['filter' => 'role:admin']);
$routes->post('/verifikasi-peminjaman-ruang/update', 'VerifikasiPeminjamanRuangController::update', ['filter' => 'role:admin']);

// Halaman publik untuk verifikasi bukti pemesanan melalui QR Code.
$routes->get('/bukti-pemesanan/(:any)', 'VerifikasiPeminjamanRuangController::publik/$1');

// kalender-pinjam-ruang
$routes->get('/kalender-pinjam-ruang', 'KalenderPinjamRuangController::index/$1', ['filter' => 'role:admin,useropd']);
