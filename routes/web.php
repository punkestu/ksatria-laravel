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
Route::get('/auth', [\App\Http\Controllers\AuthController::class, 'getSanctumTokenApi'])
        ->name('api.auth.getSanctumToken');
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/user-profile', function () {
    return view('user-profile');
})->name('user-profile')->middleware('auth');

Route::resource('cabang', \App\Http\Controllers\Dashboard\CabangController::class)
    ->middleware(['auth', 'admin'])
    ->names('dashboard.cabang');
Route::resource('user', \App\Http\Controllers\Dashboard\UserController::class)
    ->middleware(['auth', 'admin'])
    ->names('dashboard.user');
Route::resource('programkerja', \App\Http\Controllers\Dashboard\ProgramkerjaController::class)
    ->middleware(['auth', 'admin'])
    ->names('dashboard.programkerja');

Route::resource('pengajuanproker', \App\Http\Controllers\ProgramkerjaController::class)
    ->middleware(['auth'])
    ->names('pengajuanproker');
Route::group([], function () {
    Route::patch('/pengajuanproker/{pengajuanproker}/approve', [\App\Http\Controllers\ProgramkerjaController::class, 'approve'])
        ->name('pengajuanproker.approve')
        ->middleware(['auth', 'admin']);
    Route::patch('/pengajuanproker/{pengajuanproker}/reject', [\App\Http\Controllers\ProgramkerjaController::class, 'reject'])
        ->name('pengajuanproker.reject')
        ->middleware(['auth', 'admin']);
    Route::patch('/pengajuanproker/{pengajuanproker}/complete', [\App\Http\Controllers\ProgramkerjaController::class, 'complete'])
        ->name('pengajuanproker.complete')
        ->middleware(['auth', 'admin']);
    Route::patch('/pengajuanproker/{pengajuanproker}/cancel', [\App\Http\Controllers\ProgramkerjaController::class, 'cancel'])
        ->name('pengajuanproker.cancel')
        ->middleware(['auth', 'admin']);
});
