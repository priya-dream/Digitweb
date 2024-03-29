<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\LineChartController;
use App\Http\Controllers\ChartJSController;
use App\Http\Controllers\MainDataController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PdfController;


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

Route::get('/chart',[ChartController::class,'index']);
Route::get('/formResult',[ChartController::class,'formResult'])->name('formResult');
Route::get('/report',[ReportController::class,'index']);

//Route::get('/test',[ChartController::class,'test']);
Route::get('/test1',[ChartController::class,'test1']);

Route::get('linechart', [ChartJSController::class, 'index']);

//Route::get('/test', [LineChartController::class, 'lineChart']);

Route::get('/create-form', [MainDataController::class,'create']);
Route::get('/get-districts/{sourceId}', [MainDataController::class,'getDistricts']);

Route::get('/get-sub-sources/{source}', [App\Http\Controllers\ChartController::class, 'getSubSources'])->name('get-sub-sources');


Route::get('/upload', [PdfController::class, 'showForm']);
Route::post('/upload', [PdfController::class, 'upload'])->name('upload');
Route::post('/check-string-in-pdf', [PdfController::class, 'checkStringInPdf'])->name('checkStringInPdf');
Route::get('/check_address_in_pdf', [PdfController::class, 'checkAddressInPdf']);
