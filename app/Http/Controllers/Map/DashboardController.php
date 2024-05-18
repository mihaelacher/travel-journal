<?php

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Requests\Map\DashboardGetRequest;
use Illuminate\Contracts\View\View;

class DashboardController extends AuthController
{
    /**
     * GET /dashboard
     * @param DashboardGetRequest $request
     * @return View
     */
    public function dashboard(DashboardGetRequest $request): View
    {
        return view('map.dashboard');
    }
}
