<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/', function () {
//     return view('siswa.material');
// });


// auth routes
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/siswa', function () {
        return view('siswa.index');
    })->name('siswa.index');
    Route::get('/pengajar', function () {
        return view('pengajar.index');
    })->name('pengajar.index');

    Route::post('/siswa/join-class', function (\Illuminate\Http\Request $request) {
        // Validasi kode kelas
        $request->validate([
            'kode_kelas' => 'required|string|max:255',
        ]);
        // TODO: Proses pencarian kelas dan join kelas di sini
        // Contoh: Kelas::where('kode', $request->kode_kelas)->first();

        // Sementara redirect kembali dengan pesan sukses
        return redirect()->route('siswa.index')->with('success', 'Berhasil mengirim permintaan gabung kelas!');
    })->name('siswa.joinClass');
});