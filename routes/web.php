<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfCompressController;
// Route::get('/', function () {
//     return view('welcome');
// });
//
Route::get('/', function () {
    return view('index');
});
Route::post('pdf-compressor', [PdfCompressController::class,'index'])->name('pdf.compressor');