<?php

use App\Http\Controllers\AuthController;

Route::prefix('auth')->group(
    function () {
        Route::post('/login', [AuthController::class, 'login'])->name('auth_login');
        Route::get('/logout', [AuthController::class, 'logout'])->name('auth_logout');
        Route::post('/create', [AuthController::class, 'create'])->name('auth_create');
    }
);
