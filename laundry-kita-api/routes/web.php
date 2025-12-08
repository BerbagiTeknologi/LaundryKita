<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ReportController;
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
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::post('/reports/coa', [ReportController::class, 'storeCoa'])->name('reports.coa.store');
    Route::post('/reports/coa/{coa}/update', [ReportController::class, 'updateCoa'])->name('reports.coa.update');
    Route::post('/reports/coa/{coa}/delete', [ReportController::class, 'destroyCoa'])->name('reports.coa.delete');
    Route::get('/reports/coa/download', [ReportController::class, 'downloadCoa'])->name('reports.coa.download');
    Route::post('/reports/coa/upload', [ReportController::class, 'uploadCoa'])->name('reports.coa.upload');

    // Layanan
    Route::get('/services/manage', [ServiceController::class, 'manage'])->name('services.manage');
    Route::post('/services/regular', [ServiceController::class, 'storeRegular'])->name('services.regular.store');
    Route::post('/services/regular/{service}/update', [ServiceController::class, 'updateRegular'])->name('services.regular.update');
    Route::post('/services/regular/{service}/delete', [ServiceController::class, 'destroyRegular'])->name('services.regular.delete');
    Route::post('/services/regular/group/{group}/rename', [ServiceController::class, 'renameRegularGroup'])->name('services.regular.group.rename');
    Route::post('/services/regular/group/{group}/delete', [ServiceController::class, 'deleteRegularGroup'])->name('services.regular.group.delete');
    Route::post('/services/package', [ServiceController::class, 'storePackage'])->name('services.package.store');
    Route::post('/services/package/{package}/update', [ServiceController::class, 'updatePackage'])->name('services.package.update');
    Route::post('/services/package/{package}/delete', [ServiceController::class, 'destroyPackage'])->name('services.package.delete');
    Route::post('/services/addon', [ServiceController::class, 'storeAddon'])->name('services.addon.store');
    Route::post('/services/addon/{addon}/update', [ServiceController::class, 'updateAddon'])->name('services.addon.update');
    Route::post('/services/addon/{addon}/delete', [ServiceController::class, 'destroyAddon'])->name('services.addon.delete');
    Route::post('/services/addon/type', [ServiceController::class, 'storeAddonType'])->name('services.addon.type.store');
    Route::post('/services/addon/type/{type}/update', [ServiceController::class, 'updateAddonType'])->name('services.addon.type.update');
    Route::post('/services/addon/type/{type}/delete', [ServiceController::class, 'destroyAddonType'])->name('services.addon.type.delete');
    Route::post('/services/promo', [ServiceController::class, 'storePromo'])->name('services.promo.store');
    Route::post('/services/promo/{promo}/update', [ServiceController::class, 'updatePromo'])->name('services.promo.update');
    Route::post('/services/promo/{promo}/delete', [ServiceController::class, 'destroyPromo'])->name('services.promo.delete');
    Route::post('/services/unit', [ServiceController::class, 'storeUnit'])->name('services.unit.store');
    Route::post('/services/unit/{unit}/update', [ServiceController::class, 'updateUnit'])->name('services.unit.update');
    Route::post('/services/unit/{unit}/delete', [ServiceController::class, 'destroyUnit'])->name('services.unit.delete');
    Route::post('/services/category', [ServiceController::class, 'storeCategory'])->name('services.category.store');
    Route::post('/services/category/{category}/update', [ServiceController::class, 'updateCategory'])->name('services.category.update');
    Route::post('/services/category/{category}/delete', [ServiceController::class, 'destroyCategory'])->name('services.category.delete');
    Route::post('/services/product', [ServiceController::class, 'storeProduct'])->name('services.product.store');
    Route::post('/services/product/{product}/update', [ServiceController::class, 'updateProduct'])->name('services.product.update');
    Route::post('/services/product/{product}/delete', [ServiceController::class, 'destroyProduct'])->name('services.product.delete');

    // Akun
    Route::get('/account/settings', [AccountController::class, 'edit'])->name('account.settings');
    Route::post('/account/settings', [AccountController::class, 'update'])->name('account.settings.update');
});
