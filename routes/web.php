<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/struktur-organisasi', function () {
    return view('struktur-organisasi');
})->name('struktur-organisasi');
Route::get('/program-kerja', function () {
    return view('program-kerja');
})->name('program-kerja');