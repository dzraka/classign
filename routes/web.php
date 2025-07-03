<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('siswa.index');
});


// auth routes
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    // Route::get('/profile', [HomeController::class, 'profile'])->name('profile');

    // Route::resource('kontaks', KontakController::class); 
    // Route::resource('mahasiswa', MahasiswaController::class)->except(['show']); 
    // Route::get('/mahasiswa/get-data', [MahasiswaController::class, 'getData'])->name('mahasiswa.get-data'); 
});