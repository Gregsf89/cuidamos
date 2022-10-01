<?php

use App\Http\Controllers\DeviceController;

Route::post('/device/link', [DeviceController::class, 'link']);
Route::post('/device/getByImei', [DeviceController::class, 'getByImei']);
Route::get('/device/list', [DeviceController::class, 'list']);
Route::post('/device/unlink', [DeviceController::class, 'unlink']);
