<?php

namespace App\Http\Requests\Map;

use App\Http\Requests\MainGetRequest;
use App\Services\Map\ShareLocationsDataService;
use App\Services\Map\VisitedLocationsDataService;

class FetchModalGetRequest extends MainGetRequest
{
    public function __construct(
        protected VisitedLocationsDataService $visitedLocationService,
        protected ShareLocationsDataService   $shareLocationsDataService
    )
    {
        parent::__construct();
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        $locationId = $this->query('location_id');
        $userId = $this->currentUser->id;
        return $this->visitedLocationService->isLocationVisitedByUser(
                locationId: $locationId,
                userId: $userId
            )
            || $this->shareLocationsDataService->isLocationSharedWithUser(
                locationId: $locationId,
                userId: $userId
            );
    }
}
