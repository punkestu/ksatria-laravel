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
    $cabangs = Cabang::all()->map(function ($cabang) {
        return [
            'id' => $cabang->id,
            'data' => $cabang
        ];
    });
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
Route::get('/statistic', function () {
    /**
    @var User $me
     */
    $me = Auth::user();
    $cabang_id = null;
    if (!$me->isAdmin()) {
        $cabang_id = $me->cabang_id;
    }
    $years = ProgramKerjaItem::getYearStartToEnd($cabang_id);
    if (!$years) {
        return redirect()->route('home')->with('alert', [
            'type' => 'warning',
            'message' => 'Tidak ada data program kerja yang tersedia untuk statistik.'
        ]);
    }
    $status = ProgramKerjaItem::getByCabang($years, $cabang_id);
    $thisyear = date('Y');
    $mostApproved = ProgramKerjaItem::getMostApproved($thisyear);
    $mostApprovedAlltime = ProgramKerjaItem::getMostApproved();
    $longest = ProgramKerjaItem::getLongestDuration($thisyear);
    $mostExpensive = ProgramKerjaItem::getMostExpensive($thisyear);
    $cheapest = ProgramKerjaItem::getCheapest($thisyear);
    return view('statistik', compact('years', 'status', 'mostApproved', 'mostApprovedAlltime', 'longest', 'mostExpensive', 'cheapest', 'thisyear'));
})->middleware(["auth"])->name('statistic');

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
