<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'prefix' => '/v1'
], function () {
    Route::post('/resources', [\App\Http\Controllers\ResourceController::class, 'storeApi'])
        ->name('api.resources.store')
        ->middleware('auth:sanctum');

    Route::get('/resources', [\App\Http\Controllers\ResourceController::class, 'getAllresourcesApi'])
        ->name('api.resources.index')
        ->middleware('auth:sanctum');

    Route::get('/agenda', [\App\Http\Controllers\AgendaController::class, 'getAgendaApi'])
        ->name('api.agenda.index')
        ->middleware('auth:sanctum');

    Route::get('/dist_proker', [\App\Http\Controllers\OtherController::class, 'distprokerApi'])
        ->name('api.dist_proker.index')
        ->middleware('auth:sanctum');

    Route::post('/welcome_video', [\App\Http\Controllers\Dashboard\SettingController::class, 'update_welcome_video'])
        ->name('api.welcome_video.update')
        ->middleware(['auth:sanctum', 'admin']);
});
