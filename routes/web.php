<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Dashboard route
Route::get('/dashboard', [\App\Http\Controllers\Map\DashboardController::class, 'dashboard'])->name('dashboard');

// Authentication routes
Route::group(['prefix' => 'auth'], function () {
    Route::get('/', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('auth');
    Route::get('/login/google', [\App\Http\Controllers\Auth\GoogleLoginController::class, 'redirectToGoogle']);
    Route::post('/login/google', [\App\Http\Controllers\Auth\GoogleLoginController::class, 'handleGoogleCallback']);
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
    Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout']);
    Route::post('/register', [\App\Http\Controllers\Auth\RegistrationController::class, 'register'])->name('register');
});

// AJAX routes
Route::group(['prefix' => 'ajax'], function () {
    // Authentication AJAX routes
    Route::get('/auth/fetchAuthForm', [\App\Http\Controllers\Auth\AjaxController::class, 'fetchAuthForm']);

    // Map-related AJAX routes
    Route::get('/fetchNearbyLocations', [\App\Http\Controllers\Map\GooglePlacesAjaxResourceController::class, 'fetchNearbyLocations']);
    Route::get('/fetchLocationModal', [\App\Http\Controllers\Map\LocationsAjaxController::class, 'fetchLocationModal']);
    Route::get('/fetchShareLocationsModal', [\App\Http\Controllers\Map\ShareLocationsAjaxController::class, 'fetchShareLocationsModal']);
    Route::get('/fetchShareLocationsButton', [\App\Http\Controllers\Map\ShareLocationsAjaxController::class, 'fetchShareLocationsButton']);
    Route::get('/fetchUserVisitedSharedLocations', [\App\Http\Controllers\Map\ShareLocationsAjaxController::class, 'fetchUserVisitedSharedLocations']);
    Route::post('/shareLocationsWithUser', [\App\Http\Controllers\Map\ShareLocationsAjaxController::class, 'shareLocationsWithUser']);
    Route::post('/markLocationAsVisited', [\App\Http\Controllers\Map\VisitedLocationsAjaxResourceController::class, 'markLocationAsVisited']);
    Route::get('/fetchVisitedLocations', [\App\Http\Controllers\Map\VisitedLocationsAjaxResourceController::class, 'fetchVisitedLocations']);
    Route::delete('/deleteVisitedLocation', [\App\Http\Controllers\Map\VisitedLocationsAjaxResourceController::class, 'deleteVisitedLocation']);
});

// Location photos route
Route::get('/location/{locationId}/photos', [\App\Http\Controllers\Map\VisitedLocationsAjaxResourceController::class, 'fetchLocationPhotos']);
Route::get('/getPlaceImage', [\App\Http\Controllers\Map\ImageProxyController::class, 'getPlaceImage']);
