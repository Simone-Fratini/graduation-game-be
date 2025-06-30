<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route per le statistiche
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    Route::post('/statistics/tasks', [StatisticsController::class, 'store'])->name('statistics.tasks.store');
    Route::put('/statistics/tasks/{task}', [StatisticsController::class, 'update'])->name('statistics.tasks.update');
    Route::delete('/statistics/tasks/{task}', [StatisticsController::class, 'destroy'])->name('statistics.tasks.destroy');
});

require __DIR__ . '/auth.php';
