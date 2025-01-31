<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\UserDetailController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\PesanController;

// Authentication Routes
Auth::routes();

// Home Routes
Route::get('/', [HomeController::class, 'index'])->name('home')->withoutMiddleware('auth');
Route::get('/home', [HomeController::class, 'index'])->name('home')->withoutMiddleware('auth');
// Divisi Routes
Route::get('/divisi', action: [DivisiController::class, 'index'])->name('divisi');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak')->withoutMiddleware('auth');

// Permohonan Routes (with authentication middleware)
Route::middleware('auth')->group(function () {
    Route::get('/pesan', [PesanController::class, 'index'])->name('pesan.index');
    Route::delete('/pesan/{id}', [PesanController::class, 'delete'])->name('pesan.delete');
    Route::post('/pesan', [PesanController::class, 'store'])->name('pesan.store');
    Route::delete('/pesan/{id}', [PesanController::class, 'delete'])->name('pesan.delete');
    Route::get('/permohonan', [PermohonanController::class, 'index'])->name('permohonan');
    Route::get('/permohonan/create', [PermohonanController::class, 'create'])->name('buatpermohonan');
    Route::post('/permohonan/create', [PermohonanController::class, 'store'])->name('simpanpermohonan');
    Route::get('/profile', [UserDetailController::class, 'index'])->name('profil.index');
    Route::post('/profile/store', [UserDetailController::class, 'store']);
    Route::put('/profile/edit', [UserDetailController::class, 'update'])->name('profile.update');
    // Download Routes
    Route::prefix('download')->group(function () {
        Route::get('/cv/{id}', [DownloadController::class, 'downloadCv'])->name('download.cv');
        Route::get('/sk_diterima/{id}', [DownloadController::class, 'downloadSKDiterima'])->name('download.skditerima');
        Route::get('/surat_pengantar/{id}', [DownloadController::class, 'downloadSuratPengantar'])->name('download.surat_pengantar');
        Route::get('/proposal/{id}', [DownloadController::class, 'downloadProposal'])->name('download.proposal');
        Route::get('/pedoman_magang', [DownloadController::class, 'pedomanMagang'])->name('download.pedoman_magang');
});
});
// Logout Route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/home');
});


