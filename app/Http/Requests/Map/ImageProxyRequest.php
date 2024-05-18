<?php

namespace App\Http\Requests\Map;

use App\Http\Requests\MainGetRequest;
use App\Services\Map\ShareLocationsDataService;
use App\Services\Map\VisitedLocationsDataService;

class ImageProxyRequest extends MainGetRequest
{
    public function __construct(
        protected VisitedLocationsDataService $visitedLocationService,
        protected ShareLocationsDataService   $shareLocationsDataService
    )
    {
        parent::__construct();
    }

    public function authorize(): bool
    {
        $currentUserId = $this->currentUser->id;
        $requestUserId = $this->query('user_id');
        $locationId = $this->query('location_id');

        if ($currentUserId !== $requestUserId) {
            return $this->shareLocationsDataService->isLocationSharedWithUser(
                locationId: $locationId,
                userId: $currentUserId,
                locationShareUserId: $requestUserId
            );
        }

        return $this->visitedLocationService->isLocationVisitedByUser(
            locationId: $locationId,
            userId: $currentUserId
        );
    }
}
