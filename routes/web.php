<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\aboutController;
use App\Http\Controllers\contactController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ArsikDetailController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;

Route::get('/produk', [ProdukController::class, 'index'])->name('produk.list');


// Auth
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// Halaman profil
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');

Route::get('/menu/arsik-ikan-mas', [ArsikDetailController::class, 'show']);


Route::get('card', [CardController::class, 'cart'])->name('kuliner.cart');

// Halaman kontak
Route::get('/contact', [contactController::class, 'index'])->name('contact');

// Halaman tentang kami
Route::get('/about', [aboutController::class, 'index'])->name('about');

// Halaman menu
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

// Halaman welcome (opsional)
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Halaman produk list (opsional)
Route::get('/produk', function () {
    return view('produk_list');
})->name('produk');
