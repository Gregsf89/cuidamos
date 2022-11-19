<?php

use App\Http\Controllers\UserController;

Route::middleware(['auth:api'])->controller(UserController::class)->prefix('user')->group(
    function () {
        Route::post('/create', 'create');
        Route::post('/show', 'show');
        Route::get('/list', 'list');
        Route::post('/update', 'update');
        Route::post('/delete', 'delete');
    }
);
