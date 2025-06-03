<?php

use App\Http\Controllers\AlamatController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DiskusiController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KomisiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MerchandiseController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PenitipanController;
use App\Http\Controllers\PenitipController;
use App\Http\Controllers\PenukaranController;
use App\Http\Controllers\ReqDonasiController;
use Illuminate\Support\Facades\Route;

// Public Routes

// Registration routes (handled by individual controllers' store methods)
Route::post('/pembeli/register', [PembeliController::class, 'store'])->name('pembeli.store');
Route::post('/penitip/register', [PenitipController::class, 'store'])->name('penitip.store');
Route::post('/pegawai/register', [PegawaiController::class, 'store'])->name('pegawai.store');
Route::post('/organisasi/register', [OrganisasiController::class, 'store'])->name('organisasi.store');

// Unified Login route (handled by LoginController)
// This replaces the individual login routes below
Route::post('/login', [LoginController::class, 'login'])->name('login');

// Individual Login routes (REMOVED as they are now handled by the unified /login)
// Route::post('/pembeli/login', [PembeliController::class, 'login'])->name('pembeli.login');
// Route::post('/penitip/login', [PenitipController::class, 'login'])->name('penitip.login');
// Route::post('/pegawai/login', [PegawaiController::class, 'login'])->name('pegawai.login');
// Route::post('/organisasi/login', [OrganisasiController::class, 'login'])->name('organisasi.login');

// General Authenticated Routes (for any authenticated user type)
Route::middleware('auth:sanctum')->group(function () {
    // Get authenticated user info (handled by LoginController)
    Route::get('/user', [LoginController::class, 'getUser'])->name('user.authenticated');
    // Logout route (handled by LoginController)
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // You can add other routes here that are accessible to ANY authenticated user
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/pegawai/authenticated', [PegawaiController::class, 'index'])->name('pegawai.index.authenticated');                   // Renamed for clarity
    Route::get('/pegawai/authenticated/{id}', [PegawaiController::class, 'show'])->name('pegawai.show.authenticated');                // Renamed for clarity
    Route::post('/pegawai/create/authenticated', [PegawaiController::class, 'store'])->name('pegawai.create.authenticated');          // Renamed
    Route::put('/pegawai/update/authenticated/{id}', [PegawaiController::class, 'update'])->name('pegawai.update.authenticated');     // Renamed
    Route::delete('/pegawai/delete/authenticated/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.delete.authenticated'); // Renamed

});

// Authenticated Routes for Pembeli
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/pembeli/authenticated', [PembeliController::class, 'index'])->name('pembeli.index.authenticated');                   // Renamed for clarity
    Route::get('/pembeli/authenticated/{id}', [PembeliController::class, 'show'])->name('pembeli.show.authenticated');                // Renamed for clarity
    Route::post('/pembeli/create/authenticated', [PembeliController::class, 'store'])->name('pembeli.create.authenticated');          // Renamed
    Route::put('/pembeli/update/authenticated/{id}', [PembeliController::class, 'update'])->name('pembeli.update.authenticated');     // Renamed
    Route::delete('/pembeli/delete/authenticated/{id}', [PembeliController::class, 'destroy'])->name('pembeli.delete.authenticated'); // Renamed

});

// Authenticated Routes for Penitip
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/penitip/authenticated', [PenitipController::class, 'index'])->name('penitip.index.authenticated');
    Route::get('/penitip/authenticated/{id}', [PenitipController::class, 'show'])->name('penitip.show.authenticated');
    Route::post('/penitip/create/authenticated', [PenitipController::class, 'store'])->name('penitip.create.authenticated');
    Route::put('/penitip/update/authenticated/{id}', [PenitipController::class, 'update'])->name('penitip.update.authenticated');
    Route::delete('/penitip/delete/authenticated/{id}', [PenitipController::class, 'destroy'])->name('penitip.delete.authenticated');

});

// Authenticated Routes for Organisasi
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/organisasi/authenticated', [OrganisasiController::class, 'index'])->name('organisasi.index.authenticated');                   // Renamed for clarity
    Route::get('/organisasi/authenticated/{id}', [OrganisasiController::class, 'show'])->name('organisasi.show.authenticated');                // Renamed for clarity
    Route::post('/organisasi/create/authenticated', [OrganisasiController::class, 'store'])->name('organisasi.create.authenticated');          // Renamed
    Route::put('/organisasi/update/authenticated/{id}', [OrganisasiController::class, 'update'])->name('organisasi.update.authenticated');     // Renamed
    Route::delete('/organisasi/delete/authenticated/{id}', [OrganisasiController::class, 'destroy'])->name('organisasi.delete.authenticated'); // Renamed

});

Route::get('/alamat', [AlamatController::class, 'index'])->name('alamat.index');
Route::get('/alamat/{id}', [AlamatController::class, 'show'])->name('alamat.show');
Route::post('/alamat/create', [AlamatController::class, 'store'])->name('alamat.store');
Route::put('/alamat/update/{id}', [AlamatController::class, 'update'])->name('alamat.update');
Route::delete('/alamat/delete/{id}', [AlamatController::class, 'destroy'])->name('alamat.destroy');

Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::get('/barang/{id}', [BarangController::class, 'show'])->name('barang.show');
Route::get('/barang/terjual', [BarangController::class, 'produkTerjual']);
Route::post('/barang/create', [BarangController::class, 'store'])->name('barang.store');
Route::put('/barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');
Route::delete('/barang/delete/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
Route::put('/barang/{id}/extend', [BarangController::class, 'extend'])->name('barang.extend');

Route::get('/nota-penitipan/{no_nota}/pdf', [PenitipanController::class, 'generateNotaPdf'])->name('nota.generate');
Route::get('/penjualan/nota/{nomor_nota}/pdf', [PenjualanController::class, 'generateNotaPdf'])->name('penjualan.nota.pdf');

Route::get('/diskusi', [DiskusiController::class, 'index'])->name('diskusi.index');
Route::get('/diskusi/{id}', [DiskusiController::class, 'show'])->name('diskusi.show');
Route::post('/diskusi/create', [DiskusiController::class, 'store'])->name('diskusi.store');
Route::put('/diskusi/update/{id}', [DiskusiController::class, 'update'])->name('diskusi.update');
Route::delete('/diskusi/delete/{id}', [DiskusiController::class, 'destroy'])->name('diskusi.destroy');

Route::get('/donasi', [DonasiController::class, 'index'])->name('donasi.index');
Route::get('/donasi/{id}', [DonasiController::class, 'show'])->name('donasi.show');
Route::post('/donasi/create', [DonasiController::class, 'store'])->name('donasi.store');
Route::put('/donasi/update/{id}', [DonasiController::class, 'update'])->name('donasi.update');
Route::delete('/donasi/delete/{id}', [DonasiController::class, 'destroy'])->name('donasi.destroy');

Route::get('/jabatan', [JabatanController::class, 'index'])->name('jabatan.index');
Route::get('/jabatan/{id}', [JabatanController::class, 'show'])->name('jabatan.show');
Route::post('/jabatan/create', [JabatanController::class, 'store'])->name('jabatan.store');
Route::put('/jabatan/update/{id}', [JabatanController::class, 'update'])->name('jabatan.update');
Route::delete('/jabatan/delete/{id}', [JabatanController::class, 'destroy'])->name('jabatan.destroy');

Route::get('/komisi', [KomisiController::class, 'index'])->name('komisi.index');
Route::get('/komisi/{id}', [KomisiController::class, 'show'])->name('komisi.show');
Route::post('/komisi/create', [KomisiController::class, 'store'])->name('komisi.store');
Route::put('/komisi/update/{id}', [KomisiController::class, 'update'])->name('komisi.update');
Route::delete('/komisi/delete/{id}', [KomisiController::class, 'destroy'])->name('komisi.destroy');

Route::get('/merchandise', [MerchandiseController::class, 'index'])->name('merchandise.index');
Route::get('/merchandise/{id}', [MerchandiseController::class, 'show'])->name('merchandise.show');
Route::post('/merchandise/create', [MerchandiseController::class, 'store'])->name('merchandise.store');
Route::put('/merchandise/update/{id}', [MerchandiseController::class, 'update'])->name('merchandise.update');
Route::delete('/merchandise/delete/{id}', [MerchandiseController::class, 'destroy'])->name('merchandise.destroy');

Route::get('/penukaran', [PenukaranController::class, 'index'])->name('penukaran.index');
Route::get('/penukaran/{id}', [PenukaranController::class, 'show'])->name('penukaran.show');
Route::post('/penukaran/create', [PenukaranController::class, 'store'])->name('penukaran.store');
Route::put('/penukaran/update/{id}', [PenukaranController::class, 'update'])->name('penukaran.update');
Route::delete('/penukaran/delete/{id}', [PenukaranController::class, 'destroy'])->name('penukaran.destroy');

Route::get('/reqDonasi', [ReqDonasiController::class, 'index'])->name('reqDonasi.index');
Route::get('/reqDonasi/{id}', [ReqDonasiController::class, 'show'])->name('reqDonasi.show');
Route::post('/reqDonasi/create', [ReqDonasiController::class, 'store'])->name('reqDonasi.store');
Route::put('/reqDonasi/update/{id}', [ReqDonasiController::class, 'update'])->name('reqDonasi.update');
Route::delete('/reqDonasi/delete/{id}', [ReqDonasiController::class, 'destroy'])->name('reqDonasi.destroy');
