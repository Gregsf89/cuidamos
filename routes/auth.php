<?php

use App\Http\Controllers\AuthController;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/auth/logout', [AuthController::class, 'logout']);
Route::post('/auth/create', [AuthController::class, 'create']);
Route::post('/auth/show', [AuthController::class, 'show']);
