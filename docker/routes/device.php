<?php

use App\Http\Controllers\DeviceController;

Route::controller(DeviceController::class)->prefix('device')->group(
    function () {
        Route::post('/log', 'log');
        Route::middleware(['auth:api'])->group(function () {
            Route::post('/link', 'link');
            Route::post('/imei/get', 'getByImei');
            Route::get('/list', 'list');
            Route::post('/unlink', 'unlink');
            Route::get('/position/get', 'getPosition');
        });
    }
);
