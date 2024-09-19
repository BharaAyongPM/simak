<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');  // Alihkan ke rute login
});
Route::get('/login', [SessionsController::class, 'create'])->name('login');
Route::post('/login', [SessionsController::class, 'store'])->name('sessions.store');
// Route untuk menyimpan data pendaftaran (store method)
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/form', [DashboardController::class, 'form'])->name('form');
    Route::get('/kalender', [DashboardController::class, 'kalender'])->name('kalender');
    Route::get('/tukarshift', [DashboardController::class, 'tukarshift'])->name('tukarshift');
    Route::get('/tukardepo', [DashboardController::class, 'tukardepo'])->name('tukardepo');
    Route::get('/dinasluar', [DashboardController::class, 'dinasluar'])->name('dinasluar');
    Route::get('/datangterlambat', [DashboardController::class, 'datangterlambat'])->name('datangterlambat');
    Route::get('/dokumen', [DashboardController::class, 'dokumen'])->name('dokumen');
    Route::get('/pelatihan', [DashboardController::class, 'pelatihan'])->name('pelatihan');
    Route::get('/historydepo', [DashboardController::class, 'historydepo'])->name('history-deposit');
    Route::get('/rekappelatihan', [DashboardController::class, 'rekappelatihan'])->name('rekap-pelatihan');
    Route::get('/profile', [ProfileController::class, 'create'])->name('user-profile');

    //ABSENSi
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi');
    Route::post('/absensi/masuk', [AbsensiController::class, 'absenMasuk'])->name('absensi.masuk');
    Route::post('/absensi/pulang/{id}', [AbsensiController::class, 'absenPulang'])->name('absensi.pulang');
    //PROFIL
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Route untuk logout (destroy method)
    Route::post('/logout', [SessionsController::class, 'destroy'])->name('logout');

    // Halaman user management juga menggunakan middleware
    Route::get('/user', function () {
        return view('pages/laravel-examples/user-management');
    })->name('user-management');
});
