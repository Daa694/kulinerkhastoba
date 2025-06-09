<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KulinerController;

// Halaman produk (ambil data dari database via controller)
Route::get('/produk', [KulinerController::class, 'index'])->name('produk');

// Auth
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard (hanya admin)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('admin');

// Halaman profil
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::post('/profil/update-alamat', [ProfilController::class, 'updateAlamat'])->name('profil.updateAlamat');

// Detail Arsik
Route::get('/menu/arsik-ikan-mas', [ArsikDetailController::class, 'show'])->name('arsik.detail');

// Keranjang
Route::get('/card', [CardController::class, 'cart'])->name('kuliner.cart');

// Halaman kontak
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Halaman tentang kami
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Halaman menu
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

// Halaman welcome (opsional)
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Resource kuliner: hanya admin yang bisa CRUD, user hanya bisa melihat (index)
Route::resource('kuliner', KulinerController::class)->except(['index'])->middleware('admin');
// Route index tetap bisa diakses semua user
Route::get('kuliner', [KulinerController::class, 'index'])->name('kuliner.index');

// Detail produk (bisa diakses user)
Route::get('/produk/{kuliner}', [KulinerController::class, 'show'])->name('produk.detail');
// Rating produk (user)
Route::post('/produk/{kuliner}/rating', [KulinerController::class, 'beriRating'])->name('produk.rating');
// Tambah ke keranjang (user)
Route::post('/produk/{kuliner}/card', [KulinerController::class, 'tambahKeranjang'])->name('produk.keranjang');
// Detail produk/menu
Route::get('/produk/{kuliner}', [KulinerController::class, 'show'])->name('produk.detail');
// Form beri rating (harus login)
Route::post('/produk/{kuliner}/rating', [KulinerController::class, 'beriRating'])
    ->middleware('auth')
    ->name('produk.rating');