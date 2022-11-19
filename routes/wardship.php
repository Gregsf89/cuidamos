<?php

use App\Http\Controllers\WardshipController;

Route::middleware(['auth:api'])->prefix('wardship')->group(
    function () {
        Route::post('/create', [WardshipController::class, 'create']);
        Route::post('/show', [WardshipController::class, 'show']);
        Route::get('/list', [WardshipController::class, 'list']);
        Route::post('/update', [WardshipController::class, 'update']);
        Route::post('/delete', [WardshipController::class, 'delete']);
    }
);
