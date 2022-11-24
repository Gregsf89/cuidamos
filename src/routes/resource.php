<?php

use App\Http\Controllers\ResourceController;

Route::middleware(['auth:api'])->controller(ResourceController::class)->prefix('resource')->group(
    function () {
        Route::post('/city/search', 'searchCity')->name('resource_city_search');
        Route::get('/federative_units/list', 'listFederativeUnits')->name('resource_federative_unit_list');
        Route::get('/gender/list', 'listGender')->name('resource_gender_list');
    }
);
