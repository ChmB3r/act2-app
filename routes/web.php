<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

use App\Http\Controllers\ManhwaController;

Route::get('/', function () {
    return inertia('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [ManhwaController::class, 'index'])->name('dashboard');
    Route::resource('manhwa', ManhwaController::class)->except(['index']);
});

require __DIR__.'/settings.php';
