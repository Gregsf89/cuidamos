<?php

use App\Http\Controllers\ResourceController;

Route::post('/resource/city/search', [ResourceController::class, 'searchCity']);
Route::get('/resource/federative_units/list', [ResourceController::class, 'listFederativeUnits']);
Route::get('/resource/gender/list', [ResourceController::class, 'listGender']);
