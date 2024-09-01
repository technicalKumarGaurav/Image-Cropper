<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfCompressController;

// Route for the home page (view)
Route::get('/', function () {
    return view('index');
});

// Route to handle image upload
Route::post('upload-image', [PdfCompressController::class, 'uploadImage'])->name('upload.image');
