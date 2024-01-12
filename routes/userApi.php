<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/profile')->group(function () {
    Route::get('/{user}', [UserController::class, 'show'])->name('show-profile');
    Route::put('/{user}', [UserController::class, 'updateProfile'])->name('update-profile');
});

Route::prefix('/param')->group(function () {
    Route::get('/{user}', [UserController::class, 'showNewsParam'])->name('show-news-param');
    Route::put('/{user}', [UserController::class, 'updateNewsParam'])->name('update-news-param');
});
