<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\UsulanController as UserUsulan;
use App\Http\Controllers\User\BerkasController as UserBerkas;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UsulanController as AdminUsulan;

Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');
    Route::get('/usulan', [UserUsulan::class, 'index'])->name('usulan.index');
    Route::post('/usulan', [UserUsulan::class, 'store'])->name('usulan.store');
    Route::delete('/usulan/{usulan}', [UserUsulan::class, 'destroy'])->name('usulan.destroy');
    Route::post('/usulan/{usulan}/kirim', [UserUsulan::class, 'kirim'])->name('usulan.kirim');
    Route::get('/usulan/generate-nomor', [UserUsulan::class, 'generateNomor'])->name('usulan.generate-nomor');
    Route::get('/usulan/{usulan}/berkas', [UserBerkas::class, 'index'])->name('berkas.index');
    Route::get('/usulan/{usulan}/berkas/create', [UserBerkas::class, 'create'])->name('berkas.create');
    Route::post('/usulan/{usulan}/berkas', [UserBerkas::class, 'store'])->name('berkas.store');
    Route::delete('/usulan/{usulan}/berkas/{berkas}', [UserBerkas::class, 'destroy'])->name('berkas.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::get('/usulan', [AdminUsulan::class, 'index'])->name('usulan.index');
    Route::get('/usulan/{usulan}', [AdminUsulan::class, 'show'])->name('usulan.show');
    Route::post('/usulan/{usulan}/setujui', [AdminUsulan::class, 'setujui'])->name('usulan.setujui');
    Route::post('/usulan/{usulan}/tolak', [AdminUsulan::class, 'tolak'])->name('usulan.tolak');
});
