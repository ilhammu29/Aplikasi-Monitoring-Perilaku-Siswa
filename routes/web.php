<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\OrangTuaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'guru':
                return redirect()->route('guru.dashboard');
            case 'siswa':
                return redirect()->route('siswa.dashboard');
            case 'orang_tua':
                return redirect()->route('orangtua.dashboard');
            default:
                return redirect('/');
        }
    })->name('dashboard');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/kelola-pengguna', [AdminController::class, 'kelolaPengguna'])->name('admin.kelola-pengguna');
    Route::post('/tambah-pengguna', [AdminController::class, 'tambahPengguna'])->name('admin.tambah-pengguna');
    Route::put('/pengguna/{id}', [AdminController::class, 'editPengguna'])->name('admin.edit-pengguna');
    Route::resource('kategori-perilaku', \App\Http\Controllers\Admin\KategoriPerilakuController::class)
    ->names('admin.kategori-perilaku');
    Route::get('/daftar-siswa', [AdminController::class, 'daftarSiswa'])->name('admin.daftar-siswa');
    Route::get('/input-perilaku/{id_siswa}', [AdminController::class, 'showInputPerilakuForm'])->name('admin.show-input-perilaku');
    Route::post('/input-perilaku', [AdminController::class, 'storePerilaku'])->name('admin.store-perilaku');
    Route::delete('/pengguna/{id}', [AdminController::class, 'hapusPengguna'])->name('admin.hapus-pengguna');
    Route::get('/admin/tambah-orang-tua', [AdminController::class, 'formTambahOrangTua'])->name('admin.form-tambah-orang-tua');
Route::post('/admin/tambah-orang-tua', [AdminController::class, 'tambahOrangTua'])->name('admin.tambah-orang-tua');

});


// Guru Routes
Route::prefix('guru')->middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');
    Route::get('/daftar-siswa', [GuruController::class, 'daftarSiswa'])->name('guru.daftar-siswa');
   // routes/web.php
   Route::get('/daftar-siswa', [GuruController::class, 'daftarSiswa'])->name('guru.daftar-siswa');
   Route::get('/input-perilaku/{id_siswa}', [GuruController::class, 'showInputPerilakuForm'])->name('guru.show-input-perilaku');
   Route::post('/store-perilaku', [GuruController::class, 'storePerilaku'])->name('guru.store-perilaku');
    Route::get('/lihat-orangtua/{id_siswa}', [GuruController::class, 'lihatOrangTua'])->name('guru.lihat-orangtua');
});
 
// Siswa Routes
Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'index'])->name('siswa.dashboard');
    Route::get('/perilaku', [SiswaController::class, 'semuaPerilaku'])->name('siswa.semua-perilaku');
    Route::post('/laporan/{id_laporan}/komentar', [SiswaController::class, 'beriKomentar'])->name('siswa.beri-komentar');
});

// Orang Tua Routes
Route::prefix('orangtua')->middleware(['auth', 'role:orang_tua'])->group(function () {
    Route::get('/dashboard', [OrangTuaController::class, 'index'])->name('orangtua.dashboard');
});
// Halaman semua perilaku
Route::get('/perilaku', [OrangTuaController::class, 'semuaPerilaku'])->name('orangtua.semua-perilaku');

require __DIR__.'/auth.php';