<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockImportExportController;
use App\Http\Controllers\OrderImportExportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/import',[StockImportExportController::class, 'import'])->name('platform.store.import');
Route::get('/export',[StockImportExportController::class, 'export'])->name('platform.store.export');
Route::post('/order/import',[OrderImportExportController::class, 'import'])->name('platform.order.import');
Route::post('/order/import/before',[OrderImportExportController::class, 'importBefore'])->name('platform.order.importBefore');
Route::get('/order/export',[OrderImportExportController::class, 'export'])->name('platform.order.export');