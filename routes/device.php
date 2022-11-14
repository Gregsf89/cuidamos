<?php

use App\Http\Controllers\DeviceController;

Route::middleware(['auth:api'])->prefix('device')->group(function () {
    Route::post('/link', [DeviceController::class, 'link']);
    Route::post('/imei/get', [DeviceController::class, 'getByImei']);
    Route::get('/list', [DeviceController::class, 'list']);
    Route::post('/unlink', [DeviceController::class, 'unlink']);
});
