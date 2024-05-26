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
     * GET /ajax/location-modal/{locationId}
     * @param FetchModalGetRequest $request
     * @param int $locationId
     * @return View
     * @throws \Exception
     */
    public function fetchLocationModal(FetchModalGetRequest $request, int $locationId): View
    {
        $data = LocationModalData::from(
            $request->all() + array(['location_id' => $locationId])
        );

        return view('map.location-modal', $data->toArray());
    }
}
