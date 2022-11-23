<?php

use App\Http\Controllers\WardshipController;

Route::middleware(['auth:api'])->controller(WardshipController::class)->prefix('wardship')->group(
    function () {
        Route::put('/add', 'add');
        Route::get('/list', 'list');
        Route::delete('/delete/{id}', 'delete');
        Route::get('/show/{id}', function ($id) {
            return 'Wardship ' . $id;
        });
    }
);
