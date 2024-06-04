<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use App\Http\Controllers\ImageController;

Route::post('/upload', [ImageController::class, 'upload'])->name('image.upload');
Route::get('/gallery', [ImageController::class, 'gallery'])->name('image.gallery');
Route::delete('/delete/{id}', [ImageController::class, 'delete'])->name('image.delete');
Route::get('/image/{id}', [ImageController::class, 'showImage'])->name('image.show');

