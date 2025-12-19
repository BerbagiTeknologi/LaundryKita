<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceRuleItemController;
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
    Route::post('/outlet/shipping/settings', [\App\Http\Controllers\OutletController::class, 'saveShippingSettings'])->name('outlet.shipping.save');
    Route::post('/outlet/shipping/zones', [\App\Http\Controllers\OutletController::class, 'storeShippingZone'])->name('outlet.shipping.zone.store');
    Route::post('/outlet/shipping/zones/{zone}/delete', [\App\Http\Controllers\OutletController::class, 'destroyShippingZone'])->name('outlet.shipping.zone.delete');
    Route::post('/outlet/reviews/template', [\App\Http\Controllers\OutletController::class, 'saveReviewTemplate'])->name('outlet.review.template');
    Route::post('/outlet/receipts/settings', [\App\Http\Controllers\OutletController::class, 'saveReceiptSettings'])->name('outlet.receipt.settings');
    Route::post('/outlet/receipts', [\App\Http\Controllers\OutletController::class, 'storeReceiptProof'])->name('outlet.receipt.store');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::post('/reports/coa', [ReportController::class, 'storeCoa'])->name('reports.coa.store');
    Route::post('/reports/coa/{coa}/update', [ReportController::class, 'updateCoa'])->name('reports.coa.update');
    Route::post('/reports/coa/{coa}/delete', [ReportController::class, 'destroyCoa'])->name('reports.coa.delete');
    Route::get('/reports/coa/download', [ReportController::class, 'downloadCoa'])->name('reports.coa.download');
    Route::post('/reports/coa/upload', [ReportController::class, 'uploadCoa'])->name('reports.coa.upload');
    Route::post('/reports/coa/mapping', [ReportController::class, 'storeMapping'])->name('reports.coa.mapping.store');
    Route::post('/reports/journal', [ReportController::class, 'storeJournal'])->name('reports.journal.store');
    Route::post('/reports/journal/line/{line}/reconcile', [ReportController::class, 'reconcileLine'])->name('reports.journal.reconcile');

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

    // Pegawai
    Route::get('/employees/manage', [EmployeeController::class, 'manage'])->name('employees.manage');
    Route::post('/employees/shifts', [EmployeeController::class, 'storeShift'])->name('employees.shifts.store');
    Route::post('/employees/shifts/{shift}/update', [EmployeeController::class, 'updateShift'])->name('employees.shifts.update');
    Route::post('/employees/shifts/{shift}/delete', [EmployeeController::class, 'deleteShift'])->name('employees.shifts.delete');
    Route::post('/employees/grades', [EmployeeController::class, 'storeGrade'])->name('employees.grades.store');
    Route::post('/employees/grades/{grade}/update', [EmployeeController::class, 'updateGrade'])->name('employees.grades.update');
    Route::post('/employees/grades/{grade}/delete', [EmployeeController::class, 'deleteGrade'])->name('employees.grades.delete');
    Route::post('/employees', [EmployeeController::class, 'storeEmployee'])->name('employees.store');
    Route::post('/employees/{employee}/update', [EmployeeController::class, 'updateEmployee'])->name('employees.update');
    Route::post('/employees/{employee}/delete', [EmployeeController::class, 'deleteEmployee'])->name('employees.delete');
    Route::post('/attendance/rules', [EmployeeController::class, 'saveAttendanceRule'])->name('attendance.rules.save');
    Route::post('/attendance/rules/delete', [EmployeeController::class, 'deleteAttendanceRule'])->name('attendance.rules.delete');
    Route::post('/attendance/rules/items', [EmployeeController::class, 'storeRuleItem'])->name('attendance.rules.items.store');
    Route::post('/attendance/rules/items/{item}/delete', [EmployeeController::class, 'deleteRuleItem'])->name('attendance.rules.items.delete');
    Route::post('/attendance/checkin', [EmployeeController::class, 'checkIn'])->name('attendance.checkin');

    // Akun
    Route::get('/account/settings', [AccountController::class, 'edit'])->name('account.settings');
    Route::post('/account/settings', [AccountController::class, 'update'])->name('account.settings.update');
});
