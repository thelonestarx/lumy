<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PakanController;
use App\Http\Controllers\DeviceController;


//Halaman Login (GET)
Route::get('/', [LoginController::class, 'showLogin'])->name('login');

//Halaman Dashboard (GET)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//Halaman Monitoring (GET)
Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring');

//Halaman Pakan (GET)
Route::get('/pakan', [PakanController::class, 'index'])->name('pakan');
Route::post('/pakan/threshold', [PakanController::class, 'storeThreshold'])->name('pakan.storeThreshold');

// Halaman Device
Route::get('/device', [DeviceController::class, 'index'])->name('device');

// Kontrol pemberian pakan manual
Route::post('/device/control/feed', [DeviceController::class, 'feed'])
    ->name('device.feed');

// Kontrol mode otomatis pompa
Route::post('/device/control/filter', [DeviceController::class, 'filter'])
    ->name('device.filter');

// Override manual pompa
Route::post('/device/control/pump', [DeviceController::class, 'manualPump'])
    ->name('device.pump');
    
//Proses Logout (POST) -> Pastikan URL-nya adalah '/logout'
Route::post('/logout', function () {
    return redirect()->route('login');
})->name('logout');