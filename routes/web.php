<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDetailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\PermohonanController;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;



Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name( 'home')->withoutMiddleware('auth');
Route::get('/', [HomeController::class, 'index'])->name( 'home')->withoutMiddleware('auth');
Route::get('/kontak', [HomeController::class, 'kontak'])->name( 'kontak')->withoutMiddleware('auth');
Route::get('/divisi', [DivisiController::class, 'index'])->name( 'divisi');
Route::middleware('auth')->get('/permohonan', [PermohonanController::class, 'index'])->name( 'permohonan');
Route::middleware('auth')->get('/permohonan/create', [PermohonanController::class, 'create'])->name( 'buatpermohonan');
Route::middleware('auth')->post('/permohonan/create', [PermohonanController::class, 'store'])->name( 'simpanpermohonan');

// Profil Routes
Route::get('/profile', [UserDetailController::class, 'index'])->name('profil');
Route::get('profile/create', [UserDetailController::class, 'create'])->name('create');
Route::post('/profile/store', [UserDetailController::class, 'store']);
Route::middleware(['auth'])->group(function () {
    Route::put('/profile/edit', [UserDetailController::class, 'update'])->name('profile.update');
});
// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login'); 
});

Route::get('/download/cv/{id}', [DownloadController::class, 'downloadCv'])->name('download.cv');
Route::get('/download/surat_pengantar/{id}', [DownloadController::class, 'downloadSuratPengantar'])->name('download.surat_pengantar');
Route::get('/download/proposal/{id}', [DownloadController::class, 'downloadProposal'])->name('download.proposal');
Route::get('/download/pedoman_magang/{id}', [DownloadController::class, 'downloadPedomanMagang'])->name('download.pedoman_magang');
