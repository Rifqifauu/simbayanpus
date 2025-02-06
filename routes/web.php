<?php
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\UserDetailController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PesanController;


// Authentication Routes
Auth::routes();

// Home Routes
Route::get('/', [HomeController::class, 'index'])->name('home')->withoutMiddleware('auth');
Route::get('/home', [HomeController::class, 'index'])->name('home')->withoutMiddleware('auth');
// Divisi Routes
Route::get('/divisi', action: [DivisiController::class, 'index'])->name('divisi');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak')->withoutMiddleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/pesan', [PesanController::class, 'index'])->name('pesan.index');
    Route::delete('/pesan/{id}', [PesanController::class, 'delete'])->name('pesan.delete');
    Route::post('/pesan', [PesanController::class, 'store'])->name('pesan.store');
    Route::delete('/pesan/{id}', [PesanController::class, 'delete'])->name('pesan.delete');
    Route::get('/permohonan', [PermohonanController::class, 'index'])->name('permohonan');
    Route::get('/permohonan/create', [PermohonanController::class, 'create'])->name('buatpermohonan');
    Route::post('/permohonan/create', [PermohonanController::class, 'store'])->name('simpanpermohonan');
    Route::delete('/permohonan/delete/{id}', [PermohonanController::class, 'destroy'])->name('hapuspermohonan');
    Route::get('/profile', [UserDetailController::class, 'index'])->name('profil.index');
    Route::post('/profile/store', [UserDetailController::class, 'store']);
    Route::put('/profile/edit', [UserDetailController::class, 'update'])->name('profile.update');
    // Download Routes
    Route::prefix('view')->group(function () {
        Route::get('/cv/{id}', [FileController::class, 'viewCV'])->name('view.cv');
        Route::get('/sk_diterima', [FileController::class, 'viewSKDiterima'])->name('view.skditerima');
        Route::get('/sk_selesai', [FileController::class, 'viewSelesai'])->name('view.skselesai');
        Route::get('/surat_pengantar/{id}', [FileController::class, 'viewSuratPengantar'])->name('view.surat_pengantar');
        Route::get('/proposal/{id}', [FileController::class, 'viewProposal'])->name('view.proposal');
        Route::get('/pedoman_magang', [FileController::class, 'viewpedomanMagang'])->name('view.pedoman_magang');
        Route::get('/surat-pernyataan', [FileController::class, 'viewSuratPernyataan'])->name('view.surat_pernyataan');
});
});


// Logout Route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/home');
});
Route::fallback(function () {
    return Inertia::render('404', [
        'user' => Auth::user()
    ])->toResponse(request())->setStatusCode(404);
});



