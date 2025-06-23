<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    MenuController,
    AboutController,
    ContactController,
    CartController,
    ProfilController,
    AuthController,
    KulinerController,
    OrderController,
    RatingController
};
use App\Http\Controllers\Admin\{
    AdminAuthController,
    DashboardController,
    KulinerController as AdminKulinerController,
    OrderController as AdminOrderController
};

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Menu Routes
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/{kuliner}', [MenuController::class, 'show'])->name('menu.detail');
Route::get('/rekomendasi', [KulinerController::class, 'rekomendasi'])->name('rekomendasi');

// About Route
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Contact Route
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Redirect /home to root URL
Route::get('/home', function () {
    return redirect('/');
})->name('home');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile
    Route::prefix('profil')->group(function () {
        Route::get('/', [ProfilController::class, 'index'])->name('profil.index');
        Route::post('/update-alamat', [ProfilController::class, 'updateAlamat'])->name('profil.updateAlamat');
    });
    
    // Cart
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/add', [CartController::class, 'add'])->name('cart.add');
        Route::put('/update', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
    });

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::put('/update', [CartController::class, 'update'])->name('update');
        Route::post('/ajax-update', [CartController::class, 'ajaxUpdate'])->name('ajax-update');
        Route::delete('/remove/{kuliner}', [CartController::class, 'remove'])->name('remove');
    });
    
    // Orders
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::post('/', [OrderController::class, 'store'])->name('orders.store');
        Route::post('/place', [OrderController::class, 'place'])->name('orders.place');
        Route::post('/notification', [OrderController::class, 'notification'])->name('orders.notification');
        Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/{order}/confirm', [OrderController::class, 'confirmReceived'])->name('orders.confirm');
        
    });

    Route::prefix('order')->name('order.')->group(function () {
        Route::post('/place', [OrderController::class, 'place'])->name('place');
        Route::get('/history', [OrderController::class, 'history'])->name('history');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    });
    
    // Ratings
    Route::prefix('rating')->group(function () {
        Route::post('/{kuliner}', [RatingController::class, 'store'])->name('rating.store');
        Route::put('/{rating}', [RatingController::class, 'update'])->name('rating.update');
        Route::delete('/{rating}', [RatingController::class, 'destroy'])->name('rating.destroy');
    });
});

// Midtrans Routes
Route::post('/payment/notification', [OrderController::class, 'notification'])->name('payment.notification');
Route::get('/payment/finish', [OrderController::class, 'finish'])->name('payment.finish');
Route::get('/payment/unfinish', [OrderController::class, 'unfinish'])->name('payment.unfinish');
Route::get('/payment/error', [OrderController::class, 'error'])->name('payment.error');
Route::get('/orders/{orderId}/receipt', [OrderController::class, 'showReceipt'])->name('orders.receipt');

// Admin Authentication Routes (Guest Only)
Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
});

// Protected Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Kuliner Management
    Route::resource('kuliner', AdminKulinerController::class);
    
    // Order Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
        Route::patch('/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('updateStatus');
    });
});