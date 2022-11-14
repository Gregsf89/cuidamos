<?php

use App\Http\Controllers\ResourceController;

Route::prefix('resource')->group(
    function () {
        Route::post('/city/search', [ResourceController::class, 'searchCity']);
        Route::get('/federative_units/list', [ResourceController::class, 'listFederativeUnits']);
        Route::get('/gender/list', [ResourceController::class, 'listGender']);
    }
);
