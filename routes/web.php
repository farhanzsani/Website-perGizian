<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\KalkulatorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('onboarding');
})->name('onboarding');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

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

Route::controller(ArtikelController::class)->group(function () {
    Route::get('/artikel', 'index')->name('artikel.index');
    Route::get('/artikel/{id}', 'show')->name('artikel.show');
});

require __DIR__.'/auth.php';
