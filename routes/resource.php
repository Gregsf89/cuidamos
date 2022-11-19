<?php

use App\Http\Controllers\ResourceController;

Route::middleware(['auth:api'])->prefix('resource')->group(
    function () {
        Route::post('/city/search', [ResourceController::class, 'searchCity']);
        Route::get('/federative_units/list', [ResourceController::class, 'listFederativeUnits']);
        Route::get('/gender/list', [ResourceController::class, 'listGender']);
    }
);
