<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/dashboard');

// Dashboard route
Route::get('/dashboard', [\App\Http\Controllers\Map\DashboardController::class, 'dashboard'])->name('dashboard');



