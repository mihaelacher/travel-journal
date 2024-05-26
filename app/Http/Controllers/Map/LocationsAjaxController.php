<?php

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Requests\Map\FetchModalGetRequest;
use Carbon\Carbon;
use Illuminate\View\View;

class LocationsAjaxController extends AuthController
{
    /**
     * Fetches location's modal
     *
     * GET /ajax/location-model
     * @param FetchModalGetRequest $request
     * @return View
     */
    public function fetchLocationModal(FetchModalGetRequest $request): View
    {
        $location = $request->query('location');
        $visitedAt = $request->query('visited_at')
            ? Carbon::parse($request->query('visited_at'))->format('M d, Y')
            : '';

        $params = [
            'photoUrls'   => $request->query('photo_urls'),
            'name'        => $request->query('name'),
            'latitude'    => $location['lat'] ?? null,
            'longitude'   => $location['lng'] ?? null,
            'visitedAt'   => $visitedAt,
            'locationId'  => $request->query('location_id'),
            'isShared'    => $request->query('is_shared'),
        ];

        return view('map.location-modal', $params);
    }
}
