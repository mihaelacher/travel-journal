<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Map web Routes
|--------------------------------------------------------------------------
*/

// AJAX routes
Route::group(['prefix' => 'ajax'], function () {
    Route::get('/nearby-locations', [\App\Http\Controllers\Map\GooglePlacesAjaxResourceController::class, 'fetchNearbyLocations']);
    Route::get('/location-model', [\App\Http\Controllers\Map\LocationsAjaxController::class, 'fetchLocationModal']);
    Route::get('/share-locations-modal', [\App\Http\Controllers\Map\ShareLocationsAjaxController::class, 'fetchShareLocationsModal']);
    Route::get('/share-locations-button', [\App\Http\Controllers\Map\ShareLocationsAjaxController::class, 'fetchShareLocationsButton']);
    Route::get('/users/{userId}/shared-locations', [\App\Http\Controllers\Map\ShareLocationsAjaxController::class, 'fetchUserSharedLocations']);
    Route::post('/users/{userId}/share-locations', [\App\Http\Controllers\Map\ShareLocationsAjaxController::class, 'shareLocationsWithUser']);
    Route::post('/location/{latitude}/{longitude}/mark-as-visited', [\App\Http\Controllers\Map\VisitedLocationsAjaxResourceController::class, 'markLocationAsVisited']);
    Route::get('/visited-locations', [\App\Http\Controllers\Map\VisitedLocationsAjaxResourceController::class, 'fetchVisitedLocations']);
    Route::delete('/visited-locations/{locationId}', [\App\Http\Controllers\Map\VisitedLocationsAjaxResourceController::class, 'deleteVisitedLocation']);
});

// Location photos route
Route::get('/location/{locationId}/photos', [\App\Http\Controllers\Map\VisitedLocationsAjaxResourceController::class, 'fetchLocationPhotos']);
Route::get('/place/image', [\App\Http\Controllers\Map\ImageProxyController::class, 'getPlaceImage']);
