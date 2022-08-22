<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ReportController as UserReportController;
use App\Http\Controllers\User\AccountController as UserAccountController;
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

    Route::get('reports', [UserReportController::class, 'index'])->name('user.report.index');
    Route::get('reports/{report}', [UserReportController::class, 'show'])->name('user.report.show');
    Route::get('reports/{report}/data', [UserReportController::class, 'getData'])->name('user.report.getData');
    Route::patch('reports/{report}', [UserReportController::class, 'update'])->name('user.report.update');
    Route::post('reports/{report}/files', [UserReportController::class, 'storeFile'])->name('user.report.files.store');
    Route::delete('reports/{report}/files/{media}', [UserReportController::class, 'destroyFile'])->name('user.report.files.destroy');

    Route::get('account', [UserAccountController::class, 'show'])->name('user.account.show');
    Route::post('account', [UserAccountController::class, 'update'])->name('user.account.update');
    
});
