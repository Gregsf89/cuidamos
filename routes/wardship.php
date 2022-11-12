<?php

use App\Http\Controllers\WardshipController;

Route::post('/wardship/create', [WardshipController::class, 'create']);
Route::post('/wardship/show', [WardshipController::class, 'show']);
Route::get('/wardship/list', [WardshipController::class, 'list']);
Route::post('/wardship/update', [WardshipController::class, 'update']);
Route::post('/wardship/delete', [WardshipController::class, 'delete']);
