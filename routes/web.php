<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderJasaController;
use App\Http\Controllers\JasaController;
use App\Services\OrderJasaService;
use App\Http\Controllers\LihatListOrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DriverController;



//main route
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');

//content route
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/history', [LihatListOrderController::class, 'index'])->name('history');
Route::get('/whatsapp', [PageController::class, 'whatsapp'])->name('whatsapp');

//Admin route
Route::get('/admin', [AdminController::class, 'admin'])->middleware('admin')->name('admin');
Route::post('/search', [AdminController::class, 'search'])->name('search');
Route::post('/cekStatus', [AdminController::class, 'cekStatus'])->name('cekStatus');
Route::post('/cekTanggal', [AdminController::class, 'cekTanggal'])->name('cekTanggal');
Route::post('/PaidDenda', [AdminController::class, 'PaidDenda'])->name('PaidDenda');
Route::post('/saveCageNumber', [AdminController::class, 'saveCageNumber'])->name('saveCageNumber');
Route::post('/insertStatus', [AdminController::class, 'insertStatus'])->name('insertStatus');
Route::get('/dismiss-alert', function () {
    session()->forget('alert');
    return redirect()->back();
})->name('dismissAlert');

//driver route
Route::get('/driver', [DriverController::class, 'driver'])->middleware('driver')->name('driver');
Route::post('/updatePesanan', [DriverController::class, 'updatePesanan'])->name('updatePesanan');

//profile route
Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('edit-profile');

//auth route
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/signup', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/signup', [RegisterController::class, 'register']);

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');


// Order
Route::get('/penitipan', [PageController::class, 'penitipan'])->name('penitipan');
Route::get('/grooming', [JasaController::class, 'index'])->name('grooming');
Route::get('/grooming-calculate-overview', [OrderJasaController::class, 'groomingCalculateOverview']);
Route::get('/penitipan-calculate-overview', [OrderJasaController::class, 'penitipanCalculateOverview']);
Route::post('/order-jasa', [OrderJasaController::class, 'store'])->name('order-jasa.store');

// Hitung Biaya Delivery
Route::get('/hitung-biaya-delivery', function () {
    $address = request()->query('address');

    $harga_delivery = (new OrderJasaService)->hitungBiayaDelivery($address);

    return $harga_delivery;
});
