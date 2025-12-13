<?php

use App\Http\Controllers\Admin\PengajuanController as AdminPengajuanController;
use App\Http\Controllers\Admin\KelolaMakananController;
use App\Http\Controllers\Admin\AhliGiziController;
use App\Http\Controllers\Admin\ArtikelController as AdminArtikelController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\KategoriController as KategoriController;
use App\Http\Controllers\Admin\KategoriMakananController as KategoriMakananController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\KalkulatorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\JadwalMakanController;
use App\Http\Controllers\Makanan\CariKaloriController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [OnboardingController::class, 'index'])->name('onboarding');
Route::get('/ahli-gizi/{id}', [OnboardingController::class, 'showAhliGizi'])->name('ahligizi.show.public');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('profile', [AdminProfileController::class, 'index'])->name('profile.index');
    Route::get('profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile/edit', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::patch('profile/destroy', [AdminProfileController::class, 'destroy'])->name('profile.destroy');

    // Users
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    // Artikel
    Route::resource('artikel', AdminArtikelController::class);

    //kategori artikel
    Route::resource('kategori', KategoriController::class)->except('show', 'create', 'edit');

    // ahligizi
    Route::resource('ahligizi', AhliGiziController::class);

    // makanan : kelola makanan
    Route::resource('kelolamakanan', KelolaMakananController::class);

    Route::resource('kategorimakanan', KategoriMakananController::class)->except('show', 'create');

    // pelacakan makanan

    // pengajuan
    Route::get('pengajuan', [AdminPengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('pengajuan/{id}', [AdminPengajuanController::class, 'show'])->name('pengajuan.show');
    Route::put('pengajuan/{id}/setujui', [AdminPengajuanController::class, 'setuju'])->name('pengajuan.setuju');
    Route::put('pengajuan/{id}/tolak/', [AdminPengajuanController::class, 'tolak'])->name('pengajuan.tolak');


});

Route::middleware(['auth', 'role:user'])->group(function () {

    // profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit/data', [ProfileController::class, 'editdata'])->name('profile.edit.data');
    Route::patch('/profile/edit/data', [ProfileController::class, 'updatedata'])->name('profile.update.data');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Kalkulator
    Route::resource('kalkulator', KalkulatorController::class)->only(['index', 'store']);

    Route::prefix('keluarga')->name('keluarga.')->group(function () {
        Route::get('/', [KeluargaController::class, 'index'])->name('index');
        Route::get('/create', [KeluargaController::class, 'create'])->name('create');
        Route::post('/store', [KeluargaController::class, 'store'])->name('store');
        Route::get('/edit', [KeluargaController::class, 'edit'])->name('edit');
        Route::put('/update', [KeluargaController::class, 'update'])->name('update');
        Route::delete('/destroy', [KeluargaController::class, 'destroy'])->name('destroy');
        Route::post('/leave', [KeluargaController::class, 'leave'])->name('leave');
        Route::delete('/kick/{id}', [KeluargaController::class, 'kickMember'])->name('kick');
        Route::get('/invite', [KeluargaController::class, 'invite'])->name('invite');
        Route::post('/join', [KeluargaController::class, 'join'])->name('join');
        Route::get('/join', [KeluargaController::class, 'join'])->name('join');
    });


    Route::prefix('makanan')->name('makanan.')->group(function (){

        Route::get('carikalori', [CariKaloriController::class, 'index'])->name('carikalori.index');
        Route::get('cari-kalori/{id}', [CariKaloriController::class, 'show'])->name('carikalori.show');

        // pengajuan
        Route::get('pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
        Route::post('pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
        Route::get('pengajuan/{id}/edit', [PengajuanController::class, 'edit'])->name('pengajuan.edit');
        Route::put('pengajuan/{id}/update', [PengajuanController::class, 'update'])->name('pengajuan.update');
        Route::delete('pengajuan/{id}/destroy', [PengajuanController::class, 'destroy'])->name('pengajuan.destroy');
    });

    Route::resource('trackingkalori', TrackingController::class);

    Route::resource('jadwal', JadwalMakanController::class)->only(['index', 'store', 'destroy']);


});



//artikel
Route::controller(ArtikelController::class)->group(function () {
        Route::get('/artikel', 'index')->name('artikel.index');
        Route::get('/artikel/{id}', 'show')->name('artikel.show');
});


//google
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);



require __DIR__.'/auth.php';
