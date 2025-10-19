<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ✅ Common routes for all logged-in users
    Route::resource('tasks', TaskController::class);
    Route::resource('categories', CategoryController::class)->only(['index','show']);

    // ✅ Admin-only routes
    Route::middleware(['admin'])->group(function () {
        Route::resource('categories', CategoryController::class)->except(['index','show']);
    });
});

require __DIR__.'/auth.php';
