<?php

use App\Http\Controllers\WardshipController;

Route::middleware(['auth:api'])->controller(WardshipController::class)->prefix('wardship')->group(
    function () {
        Route::post('/create', 'create');
        Route::post('/show', 'show');
        Route::get('/list', 'list');
        Route::post('/update', 'update');
        Route::post('/delete', 'delete');
    }
);
