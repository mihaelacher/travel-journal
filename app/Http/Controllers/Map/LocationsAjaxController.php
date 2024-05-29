<?php

namespace App\Http\Controllers\Map;

use App\Data\Map\LocationModalData;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Requests\Map\FetchModalGetRequest;
use Carbon\Carbon;
use Illuminate\View\View;

class LocationsAjaxController extends AuthController
{
    /**
     * Fetches location's modal
     *
     * GET /ajax/location-modal
     * @param FetchModalGetRequest $request
     * @return View
     */
    public function fetchLocationModal(FetchModalGetRequest $request): View
    {
        $data = LocationModalData::from($request->all());

        return view('map.location-modal', $data->toArray());
    }
}
