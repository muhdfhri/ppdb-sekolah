<?php

use Illuminate\Support\Facades\Route;

// ── Auth Controllers ─────────────────────────────────────────────
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// ── Public Controllers ───────────────────────────────────────────
use App\Http\Controllers\PengumumanPublikController;

// ── Siswa Controllers ────────────────────────────────────────────
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\PendaftaranController;

// ── Admin Controllers ────────────────────────────────────────────
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PendaftarController;
use App\Http\Controllers\Admin\VerifikasiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\PenggunaController;


// ================================================================
// LANDING PAGE
// ================================================================
Route::get('/', function () {
    return view('landing.index');
})->name('home');

// ================================================================
// PUBLIC ROUTES (Tanpa Login)
// ================================================================
Route::get('/pengumuman', [PengumumanPublikController::class, 'index'])->name('pengumuman.publik');
Route::get('/pengumuman/{id}', [PengumumanPublikController::class, 'show'])->name('pengumuman.publik.show');

// ================================================================
// AUTH ROUTES (Guest Only)
// ================================================================
Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ================================================================
// SISWA ROUTES — middleware: auth + siswa
// ================================================================
Route::middleware(['auth', 'siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {

        Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profil', [SiswaDashboardController::class, 'profil'])->name('profil');
        Route::get('/pengumuman', [SiswaDashboardController::class, 'pengumuman'])->name('pengumuman');

        Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {

            Route::get('/', [PendaftaranController::class, 'index'])->name('index');

            Route::get('/step/1', [PendaftaranController::class, 'step1'])->name('step1');
            Route::post('/step/1', [PendaftaranController::class, 'step1Store'])->name('step1.store');

            Route::get('/step/2', [PendaftaranController::class, 'step2'])->name('step2');
            Route::post('/step/2', [PendaftaranController::class, 'step2Store'])->name('step2.store');

            Route::get('/step/3', [PendaftaranController::class, 'step3'])->name('step3');
            Route::post('/step/3', [PendaftaranController::class, 'step3Store'])->name('step3.store');

            Route::get('/step/4', [PendaftaranController::class, 'step4'])->name('step4');
            Route::post('/step/4', [PendaftaranController::class, 'step4Store'])->name('step4.store');

            Route::get('/step/5', [PendaftaranController::class, 'step5'])->name('step5');
            Route::post('/step/5', [PendaftaranController::class, 'step5Store'])->name('step5.store');

            Route::get('/cetak', [PendaftaranController::class, 'cetak'])->name('cetak');
            Route::get('/cetak/pdf', [PendaftaranController::class, 'cetakPdf'])->name('cetak.pdf');

            Route::post('/pilih-periode', [PendaftaranController::class, 'pilihPeriode'])->name('pilih-periode');

            Route::get('/riwayat', [PendaftaranController::class, 'riwayat'])->name('riwayat');
        });

    });

// ================================================================
// ADMIN ROUTES — middleware: auth + admin
// ================================================================
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // ── Calon Siswa / Pendaftar ──────────────────────────
        Route::prefix('pendaftar')->name('pendaftar.')->group(function () {
            Route::get('/', [PendaftarController::class, 'index'])->name('index');
            Route::get('/{id}', [PendaftarController::class, 'show'])->name('show');

            // TAMBAHKAN ROUTE DELETE DI SINI
            Route::delete('/{id}', [PendaftarController::class, 'destroy'])->name('destroy');

            // Aksi utama
            Route::patch('/{id}/terima', [PendaftarController::class, 'terima'])->name('terima');
            Route::patch('/{id}/tolak', [PendaftarController::class, 'tolak'])->name('tolak');
            Route::patch('/{id}/verifikasi', [PendaftarController::class, 'verifikasi'])->name('verifikasi');

            // Verifikasi per dokumen & pembayaran
            Route::post('/{id}/dokumen/{dokumenId}/verifikasi', [PendaftarController::class, 'verifikasiDokumen'])->name('verifikasi-dokumen');
            Route::post('/{id}/pembayaran/verifikasi', [PendaftarController::class, 'verifikasiPembayaran'])->name('verifikasi-pembayaran');

            // Catatan admin
            Route::post('/{id}/catatan', [PendaftarController::class, 'updateCatatan'])->name('catatan');
        });

        // ── Verifikasi Dokumen (halaman tersendiri) ──────────
        Route::prefix('verifikasi')->name('verifikasi.')->group(function () {
            Route::get('/', [VerifikasiController::class, 'index'])->name('index');
            Route::post('/dokumen/{id}', [VerifikasiController::class, 'verifikasiDokumen'])->name('dokumen');
        });

        // ── Pengumuman ───────────────────────────────────────
        Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
            Route::get('/', [PengumumanController::class, 'index'])->name('index');
            Route::get('/create', [PengumumanController::class, 'create'])->name('create');
            Route::post('/', [PengumumanController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [PengumumanController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PengumumanController::class, 'update'])->name('update');
            Route::patch('/{id}/toggle', [PengumumanController::class, 'togglePublish'])->name('toggle');
            Route::delete('/{id}', [PengumumanController::class, 'destroy'])->name('destroy');
        });

        // ── Laporan ──────────────────────────────────────────
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [LaporanController::class, 'index'])->name('index');
            Route::get('/export/{format}', [LaporanController::class, 'export'])->name('export')
                ->where('format', 'xlsx|pdf');
        });

        // ── Jurusan ──────────────────────────────────────────
        Route::prefix('jurusan')->name('jurusan.')->group(function () {
            Route::get('/create', [JurusanController::class, 'create'])->name('create');
            Route::post('/', [JurusanController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [JurusanController::class, 'edit'])->name('edit');
            Route::put('/{id}', [JurusanController::class, 'update'])->name('update');
            Route::patch('/{id}/toggle', [JurusanController::class, 'toggleActive'])->name('toggle');
            Route::delete('/{id}', [JurusanController::class, 'destroy'])->name('destroy');
        });

        // ── Pengaturan ───────────────────────────────────────
        Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
            Route::get('/', [PengaturanController::class, 'index'])->name('index');
            Route::put('/update', [PengaturanController::class, 'update'])->name('update');

            Route::get('/periode/create', [PengaturanController::class, 'createPeriode'])->name('periode.create');
            Route::post('/periode', [PengaturanController::class, 'storePeriode'])->name('periode.store');
            Route::get('/periode/{id}', [PengaturanController::class, 'showPeriode'])->name('periode.show');
            Route::get('/periode/{id}/edit', [PengaturanController::class, 'editPeriode'])->name('periode.edit');
            Route::put('/periode/{id}', [PengaturanController::class, 'updatePeriode'])->name('periode.update');
            Route::delete('/periode/{id}', [PengaturanController::class, 'destroyPeriode'])->name('periode.destroy');
            Route::patch('/periode/{id}/toggle', [PengaturanController::class, 'toggleActive'])->name('periode.toggle');

            Route::put('/kuota', [PengaturanController::class, 'updateKuota'])->name('kuota');
        });

        // ── Kelola Pengguna ──────────────────────────────────
        Route::prefix('pengguna')->name('pengguna.')->group(function () {
            Route::get('/', [PenggunaController::class, 'index'])->name('index');
            Route::post('/', [PenggunaController::class, 'store'])->name('store');
            Route::put('/{id}', [PenggunaController::class, 'update'])->name('update');
            Route::delete('/{id}', [PenggunaController::class, 'destroy'])->name('destroy');
            Route::patch('/{id}/reset-password', [PenggunaController::class, 'resetPassword'])->name('reset-password');
        });

    });

Route::fallback(function () {
    return response()->view('404', [], 404);
});