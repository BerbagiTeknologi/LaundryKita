<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OutletController;
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
    Route::get('/outlet/edit', [OutletController::class, 'edit'])->name('outlet.edit');
    Route::post('/outlet/edit', [OutletController::class, 'update'])->name('outlet.update');
    Route::get('/outlet/hours', [OutletController::class, 'hours'])->name('outlet.hours');
    Route::post('/outlet/hours', [OutletController::class, 'updateHours'])->name('outlet.hours.update');
    Route::get('/outlet/pickup', [OutletController::class, 'pickup'])->name('outlet.pickup');
    Route::post('/outlet/pickup', [OutletController::class, 'updatePickup'])->name('outlet.pickup.update');
    Route::get('/account/settings', [AccountController::class, 'edit'])->name('account.settings');
    Route::post('/account/settings', [AccountController::class, 'update'])->name('account.settings.update');
});
