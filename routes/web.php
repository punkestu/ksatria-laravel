<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/struktur-organisasi', function () {
    return view('struktur-organisasi');
})->name('struktur-organisasi');
Route::get('/program-kerja', function () {
    return view('program-kerja');
})->name('program-kerja');

Route::group([
    'prefix' => '/login',
    'middleware' => ['guest']
], function () {
    Route::get('/', function () {
        return view('login');
    })->name('login');
    Route::post('/', [\App\Http\Controllers\AuthController::class, "login"])->name('login.post');
});
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/user-profile', function () {
    return view('user-profile');
})->name('user-profile')->middleware('auth');

Route::resource('cabang', \App\Http\Controllers\Dashboard\CabangController::class)
    ->middleware(['auth', 'admin'])
    ->names('dashboard.cabang');
