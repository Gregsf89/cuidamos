<?php

use App\Http\Controllers\DeviceController;

Route::controller(DeviceController::class)->prefix('device')->group(
    function () {
        Route::post('/log', 'registerLog')->name('device_log');
        Route::middleware(['auth:api'])->group(function () {
            Route::post('/link', 'link')->name('device_link');
            Route::post('/imei/get', 'getByImei')->name('device_imei_get');
            Route::get('/list', 'list')->name('device_list');
            Route::post('/unlink', 'unlink')->name('device_unlink');
        });
    }
);
