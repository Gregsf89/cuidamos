<?php

use App\Http\Controllers\DeviceController;

Route::post('/device/create', [DeviceController::class, 'create']);
Route::post('/device/show', [DeviceController::class, 'show']);
Route::get('/device/list', [DeviceController::class, 'list']);
Route::post('/device/update', [DeviceController::class, 'update']);
Route::post('/device/delete', [DeviceController::class, 'delete']);
