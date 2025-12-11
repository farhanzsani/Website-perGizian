<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\KalkulatorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KeluargaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('onboarding');
})->name('onboarding');




Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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
    //artikel
    Route::controller(ArtikelController::class)->group(function () {
    Route::get('/artikel', 'index')->name('artikel.index');
    Route::get('/artikel/{id}', 'show')->name('artikel.show');

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

    });

});



require __DIR__.'/auth.php';
