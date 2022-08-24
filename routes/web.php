<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ReportController as UserReportController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\User\AccountController as UserAccountController;
use App\Http\Controllers\Admin\StatController as AdminStatController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'middleware' => ['auth', 'verified']
], function() {

    Route::get('dashboard', [DashboardController::class, 'show'])->name('dashboard.show');

    Route::get('my-reports', [UserReportController::class, 'index'])->name('user.report.index');
    Route::get('my-reports/{report}', [UserReportController::class, 'show'])->name('user.report.show');
    Route::get('my-reports/{report}/data', [UserReportController::class, 'getData'])->name('user.report.getData');
    Route::patch('my-reports/{report}', [UserReportController::class, 'update'])->name('user.report.update');
    Route::post('my-reports/{report}/files', [UserReportController::class, 'storeFile'])->name('user.report.files.store');
    Route::delete('my-reports/{report}/files/{media}', [UserReportController::class, 'destroyFile'])->name('user.report.files.destroy');

    Route::get('my-account', [UserAccountController::class, 'show'])->name('user.account.show');
    Route::post('my-account', [UserAccountController::class, 'update'])->name('user.account.update');
    
});

Route::group([
    'middleware' => ['auth', 'verified', 'admin']
], function() {

    Route::get('all-reports', [AdminReportController::class, 'index'])->name('admin.report.index');
    Route::get('all-reports/{report}', [AdminReportController::class, 'show'])->name('admin.report.show');
    Route::get('all-reports/{report}/data', [AdminReportController::class, 'getData'])->name('admin.report.getData');

    Route::get('statistics', [AdminStatController::class, 'show'])->name('admin.stats');
    Route::get('statistics/club', [AdminStatController::class, 'getClub'])->name('admin.stats.getClub');

});
