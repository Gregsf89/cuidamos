<?php

use App\Http\Controllers\UserController;

Route::middleware(['auth:api'])->controller(UserController::class)->prefix('user')->group(
    function () {
        Route::post('/add', 'add')->name('user_add');
        Route::get('/show', 'show')->name('user_show');
    }
);
