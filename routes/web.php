<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ReportController as UserReportController;
use App\Http\Controllers\User\ReportDataController as UserReportDataController;
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
    Route::put('reports/{report}', [UserReportController::class, 'update'])->name('user.report.update');
    Route::get('reports/{report}/data', [UserReportDataController::class, 'get'])->name('user.report.data.get');

    Route::get('account', [UserAccountController::class, 'show'])->name('user.account.show');
    Route::post('account', [UserAccountController::class, 'update'])->name('user.account.update');
    
});
