<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'prefix' => '/v1'
], function () {
    Route::post('/pictures', [\App\Http\Controllers\PictureController::class, 'storeApi'])
        ->name('api.pictures.store')
        ->middleware('auth:sanctum');

    Route::get('/pictures', [\App\Http\Controllers\PictureController::class, 'getAllPicturesApi'])
        ->name('api.pictures.index')
        ->middleware('auth:sanctum');
});
