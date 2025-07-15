<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FaceController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FaceRegisterController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\KaryawanController;

// =======================
// GUEST ROUTES
// =======================
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.store');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/import-users', [UserController::class, 'importForm'])->name('users.importForm');
Route::post('/import-users', [UserController::class, 'import'])->name('users.import');
Route::get('/admin/karyawan', [AdminController::class, 'dataKaryawan'])->name('admin.karyawan');

// =======================
// AUTH ROUTES
// =======================
Route::middleware(['auth'])->group(function () {

    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // USER ROUTES
    Route::get('/face', [FaceController::class, 'index'])->name('face');
    Route::post('/face', [FaceController::class, 'store']);
    Route::post('/face/absen', [FaceController::class, 'store'])->name('face.absen');
    Route::post('/face/register', [FaceController::class, 'registerStore'])->name('face.register.store');
    Route::get('/face/register', [FaceController::class, 'showRegisterForm'])->name('face.register');
    Route::post('/daftar-wajah', [FaceController::class, 'storeRegisterFace'])->name('face.register.store');

    // ✅ Tambahkan route simpan wajah snapshot (untuk tombol "Simpan Wajah")
    Route::post('/face/save', [FaceController::class, 'save'])->name('face.save');

    // ADMIN ROUTES (pastikan role = admin)
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/absensi', [AdminController::class, 'absensi'])->name('admin.absensi');
        Route::get('/admin/lokasi', [AdminController::class, 'lokasi'])->name('admin.lokasi');
        Route::post('/admin/lokasi', [AdminController::class, 'updateLokasi'])->name('admin.lokasi.update');
        Route::post('/admin/lokasi/toggle', [LokasiController::class, 'toggleAktif'])->name('admin.lokasi.toggle');
        Route::get('/admin/karyawan', [AdminController::class, 'karyawan'])->name('admin.karyawan');
        Route::get('/admin/shift', [AdminController::class, 'shift'])->name('admin.shift');
        Route::get('/admin/karyawan/daftar-wajah/{id}', [FaceRegisterController::class, 'show'])->name('admin.karyawan.face');
        Route::post('/admin/karyawan/daftar-wajah/{id}', [FaceRegisterController::class, 'store'])->name('admin.karyawan.face.store');
        Route::get('/admin/generate-wajah', [FaceRegisterController::class, 'generateFromFoto'])->name('admin.generate.wajah');
        Route::get('/admin/generate-wajah', [FaceRegisterController::class, 'batchRegister'])->name('admin.karyawan.batch-face');
    });

    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('jabatan', JabatanController::class);
    });

    Route::get('/test-user', function () {
        if (auth()->check()) {
            return 'Logged in as: ' . auth()->user()->email . ' | Role: ' . auth()->user()->role;
        } else {
            return 'Kamu belum login.';
        }
    });

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/karyawan/{id}/edit', [AdminController::class, 'editKaryawan'])->name('karyawan.edit');
        Route::put('/karyawan/{id}', [AdminController::class, 'updateKaryawan'])->name('karyawan.update');
    });

});
