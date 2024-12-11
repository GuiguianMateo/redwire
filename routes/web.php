<?php

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MotifController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('/user', UserController::class)->withTrashed();
    Route::resource('/absence', AbsenceController::class)->withTrashed();
    Route::resource('/motif', MotifController::class)->withTrashed();

    Route::get('/motif/{motif}/restore', [MotifController::class, 'restore'])->withTrashed()->name('motif.restore');
    Route::get('/absence/{absence}/restore', [AbsenceController::class, 'restore'])->withTrashed()->name('absence.restore');
    Route::get('/user/{user}/restore', [UserController::class, 'restore'])->withTrashed()->name('user.restore');

    Route::get('/demande', [AbsenceController::class, 'demande'])->name('absence.demande');
    Route::get('/status/{absence}/status', [AbsenceController::class, 'status'])->name('absence.status');

    Route::get('language/{code_iso}', [LanguageController::class, 'change'])->name('language.change');

});
require __DIR__.'/auth.php';
