<?php

use App\Http\Controllers\UserController;

Route::middleware(['auth:api'])->controller(UserController::class)->prefix('user')->group(
    function () {
        Route::post('/create', 'create')->name('user_create');
        Route::post('/show', 'show')->name('user_show');
        Route::post('/update', 'update')->name('user_update');
    }
);
