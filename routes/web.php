<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageCorpperController;

// Route for the home page (view)
Route::get('/', function () {
    return view('index');
});

// Route to handle image upload
Route::post('upload-image', [ImageCorpperController::class, 'uploadImage'])->name('upload.image');
