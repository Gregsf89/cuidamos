<?php

use App\Http\Controllers\DeviceController;

Route::middleware(['auth:api'])->group(function () {
    Route::post('/device/link', [DeviceController::class, 'link']);
    Route::post('/device/imei/get', [DeviceController::class, 'getByImei']);
    Route::get('/device/list', [DeviceController::class, 'list']);
    Route::post('/device/unlink', [DeviceController::class, 'unlink']);
});
