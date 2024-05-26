<?php

namespace App\Http\Requests\Map;

use App\Http\Requests\MainGetRequest;
use App\Services\Map\ShareLocationsDataService;

class FetchUserSharedLocationsGetRequest extends MainGetRequest
{
    public function __construct(public ShareLocationsDataService $locationService)
    {
        parent::__construct();
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->locationService->isLocationSharedWithUser(
            userId: $this->currentUser->id,
            locationShareUserId: $this->route('userId'),
        );
    }

}
