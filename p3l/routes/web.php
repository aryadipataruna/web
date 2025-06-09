<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('homePage');
})->name('home');

Route::match(['GET', 'POST'], '/login-regis', function () {
    return view('loginRegister');
})->name('login-regis');

Route::post('/register', [RegistrationHandleController::class, 'handleRegistration'])->name('handle.registration');

Route::get('/adminPageMerchandise', function () {
    return view('admin.adminPageMerchandise');
})->name('adminPageMerchandise');

Route::get('/adminPagePegawai', function () {
    return view('admin.adminPagePegawai');
})->name('adminPagePegawai');

Route::get('/adminPageOrganisasi', function () {
    return view('admin.adminPageOrganisasi');
})->name('adminPageOrganisasi');

Route::get('/adminPageOwner', function () {
    return view('admin.adminPageOwner');
})->name('adminPageOwner');

Route::get('/adminPageCS', function () {
    return view('admin.adminPageCS');
})->name('adminPageCS');

Route::match(['GET', 'POST', 'PUT'], '/adminPageGudang', function () {
    return view('admin.adminPageGudang');
})->name('adminPageGudang');

Route::get('/detailBarang/{id}', function ($id) {
    return view('detailBarangPage', ['id' => $id]);
})->name('detailBarang');

Route::match(['GET', 'POST', 'PUT'], '/cartPembeli', function () {
    return view('cart');
})->name('cartPembeli');

Route::get('/historyPage', function () {
    return view('history.historyPage');
})->name('historyPage');

Route::get('/ratingPage', function () {
    return view('ratingPage');
})->name('ratingPage');

Route::get('/cartPembeli', function () {
    return view('cart');
})->name('cartPembeli');

Route::get('/cartPembeli', function () {
    return view('cart');
})->name('cartPembeli');

// Route::get('/passwordBiasa'), fuction (){
//     return view('password.passwordTglLahir');
// })->name('passwordEmail');
