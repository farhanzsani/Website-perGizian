<?php

use App\Http\Controllers\Admin\ArtikelController as AdminArtikelController;
use App\Http\Controllers\Admin\KategoriController as KategoriController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\KalkulatorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('onboarding');
})->name('onboarding');




Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Artikel
    Route::resource('artikel', AdminArtikelController::class);

    //kategori artikel
    Route::resource('kategori', KategoriController::class)->except('show', 'create');
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

});

//artikel
Route::controller(ArtikelController::class)->group(function () {
        Route::get('/artikel', 'index')->name('artikel.index');
        Route::get('/artikel/{id}', 'show')->name('artikel.show');
});



require __DIR__.'/auth.php';
