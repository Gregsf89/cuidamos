<?php

use App\Http\Controllers\UserController;

Route::post('/user/create', [UserController::class, 'create']);
Route::post('/user/show', [UserController::class, 'show']);
Route::get('/user/list', [UserController::class, 'list']);
Route::post('/user/update', [UserController::class, 'update']);
Route::post('/user/delete', [UserController::class, 'delete']);
