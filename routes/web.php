<?php

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
    return view('welcome');
});
Route::get('/login', [SessionsController::class, 'create'])->name('login');
Route::post('/login', [SessionsController::class, 'store'])->name('sessions.store');
// Route untuk menyimpan data pendaftaran (store method)
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'create'])->name('user-profile');

    // Route untuk memperbarui profile (update method)
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Route untuk logout (destroy method)
    Route::post('/logout', [SessionsController::class, 'destroy'])->name('logout');

    // Halaman user management juga menggunakan middleware
    Route::get('/user', function () {
        return view('pages/laravel-examples/user-management');
    })->name('user-management');
});
