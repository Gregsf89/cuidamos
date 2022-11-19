<?php

use App\Http\Controllers\ResourceController;

Route::middleware(['auth:api'])->controller(ResourceController::class)->prefix('resource')->group(
    function () {
        Route::post('/city/search', 'searchCity');
        Route::get('/federative_units/list', 'listFederativeUnits');
        Route::get('/gender/list', 'listGender');
    }
);
