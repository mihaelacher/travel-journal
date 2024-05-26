<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

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
    Route::get('/auth/form', [\App\Http\Controllers\Auth\AjaxController::class, 'fetchAuthForm']);
});
