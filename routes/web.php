<?php

use App\Models\Cabang;
use App\Models\ProgramKerjaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/struktur-organisasi', function () {
    $cabangs = Cabang::all();
    return view('struktur-organisasi', compact('cabangs'));
})->name('struktur-organisasi');
Route::get('/program-kerja', function () {
    return view('program-kerja');
})->name('program-kerja');
Route::get('/notification', function (Request $request) {
    if (Auth::user()->unreadNotifications->count() > 0) {
        if ($request->session()->get('notification_read') === true) {
            Auth::user()->unreadNotifications->markAsRead();
            $request->session()->put('notification_read', false);
        } else {
            $request->session()->put('notification_read', true);
        }
    } else {
        $request->session()->put('notification_read', false);
    }
    return view('notification');
})->middleware(["auth"])->name('notification');
Route::get('/statistic', [\App\Http\Controllers\OtherController::class, "statisticPage"])->middleware(["auth"])->name('statistic');

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

Route::resource('agenda', \App\Http\Controllers\AgendaController::class)
    ->middleware(['auth'])
    ->names('agenda');

Route::resource('cabang', \App\Http\Controllers\Dashboard\CabangController::class)
    ->middleware(['auth', 'admin'])
    ->names('dashboard.cabang');
Route::resource('user', \App\Http\Controllers\Dashboard\UserController::class)
    ->middleware(['auth', 'admin'])
    ->names('dashboard.user');
Route::resource('programkerja', \App\Http\Controllers\Dashboard\ProgramkerjaController::class)
    ->middleware(['auth', 'admin'])
    ->names('dashboard.programkerja');
Route::resource('karyawan', \App\Http\Controllers\Dashboard\KaryawanController::class)
    ->middleware(['auth', 'admin'])
    ->names('dashboard.karyawan');

Route::group([
    'prefix' => '/pengajuanproker',
    'middleware' => ['auth']
], function () {
    Route::get('/pengajuanproker/export', [\App\Http\Controllers\ProgramkerjaController::class, 'export'])
        ->name('pengajuanproker.export');
    Route::get('/pengajuanproker/{pengajuanproker}/export', [\App\Http\Controllers\ProgramkerjaController::class, 'exportpdf'])
        ->name('pengajuanproker.exportpdf');

    Route::post('/pengajuanproker/import', [\App\Http\Controllers\ProgramkerjaController::class, 'import'])
        ->name('pengajuanproker.import');
});
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
