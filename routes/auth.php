<?php

use App\Http\Controllers\AuthController;

Route::prefix('auth')->controller(AuthController::class)->group(
    function () {
        Route::post('/login', 'login')->name('auth_login');
        Route::post('/create', 'create')->name('auth_create');
        Route::middleware(['auth:api'])->group(function () {
            Route::post('/phone/validate', 'validatePhone')->name('auth_validate_phone');
            Route::get('/logout', 'logout')->name('auth_logout');
        });
    }
);
