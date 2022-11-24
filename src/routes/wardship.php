<?php

use App\Http\Controllers\WardshipController;

Route::middleware(['auth:api'])->controller(WardshipController::class)->prefix('wardship')->group(
    function () {
        Route::put('/add', 'add')->name('wardship_add');
        Route::get('/list', 'list')->name('wardship_list');
        Route::delete('/delete/{id}', 'delete')->name('wardship_delete');
        Route::get('/show/{id}', function ($id) {
            return 'Wardship ' . $id;
        })->name('wardship_show');
    }
);
