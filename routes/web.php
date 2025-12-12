<?php

use App\Http\Controllers\Admin\KelolaMakananController;
use App\Http\Controllers\Admin\AhliGiziController;
use App\Http\Controllers\Admin\ArtikelController as AdminArtikelController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\KategoriController as KategoriController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\KalkulatorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Makanan\CariKaloriController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ProfileController;
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
    Route::resource('kategori', KategoriController::class)->except('show', 'create');

    // ahligizi
    Route::resource('ahligizi', AhliGiziController::class);

    // makanan : kelola makanan
    Route::resource('kelolamakanan', KelolaMakananController::class);

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


    Route::get('makanan/carikalori', [CariKaloriController::class, 'index'])->name('makanan.carikalori.index');
    Route::get('makanan/cari-kalori/{id}', [CariKaloriController::class, 'show'])->name('makanan.carikalori.show');


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
