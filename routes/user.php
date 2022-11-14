<?php

use App\Http\Controllers\UserController;

Route::prefix('user')->group(
    function () {
        Route::post('/create', [UserController::class, 'create']);
        Route::post('/show', [UserController::class, 'show']);
        Route::get('/list', [UserController::class, 'list']);
        Route::post('/update', [UserController::class, 'update']);
        Route::post('/delete', [UserController::class, 'delete']);
    }
);
