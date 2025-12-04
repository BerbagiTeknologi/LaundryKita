<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'loginWeb'])->name('login.attempt');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'registerWeb'])->name('register.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('index');
    })->name('home');
    
    // Outlet
    Route::get('/outlet/edit', [OutletController::class, 'edit'])->name('outlet.edit');
    Route::post('/outlet/edit', [OutletController::class, 'update'])->name('outlet.update');
    Route::get('/outlet/manage', [\App\Http\Controllers\OutletController::class, 'manage'])->name('outlet.manage');
    Route::post('/outlet/update', [\App\Http\Controllers\OutletController::class, 'update'])->name('outlet.update');
    Route::get('/outlet/hours', [\App\Http\Controllers\OutletController::class, 'hours'])->name('outlet.hours');
    Route::post('/outlet/hours', [\App\Http\Controllers\OutletController::class, 'updateHours'])->name('outlet.hours.update');
    Route::get('/outlet/pickup', [\App\Http\Controllers\OutletController::class, 'pickup'])->name('outlet.pickup');
    Route::post('/outlet/pickup', [\App\Http\Controllers\OutletController::class, 'updatePickup'])->name('outlet.pickup.update');

    // Layanan
    Route::get('/services/manage', [ServiceController::class, 'manage'])->name('services.manage');
    Route::post('/services/regular', [ServiceController::class, 'storeRegular'])->name('services.regular.store');
    Route::post('/services/regular/{service}/update', [ServiceController::class, 'updateRegular'])->name('services.regular.update');
    Route::post('/services/regular/{service}/delete', [ServiceController::class, 'destroyRegular'])->name('services.regular.delete');

    // Akun
    Route::get('/account/settings', [AccountController::class, 'edit'])->name('account.settings');
    Route::post('/account/settings', [AccountController::class, 'update'])->name('account.settings.update');
});
