<?php

namespace App\Data\ExternalApi;

use App\Services\ExternalApi\EndpointConstants;
use Spatie\LaravelData\Attributes\MapInputName;

class PlacePhotoEndpointData extends BaseEndpointData
{
    public function __construct(
        #[MapInputName('photo_reference')]
        public string $photoReference,
        #[MapInputName('location_id')]
        public ?int $locationId,
        #[MapInputName('is_visited')]
        public ?int $isVisited = 0,
        #[MapInputName('user_id')]
        public ?string $userId = null,
    ) {
    }

    // ---------------------------------- GETTERS ------------------------------------------ //
    public function getPathPattern(): string
    {
        return EndpointConstants::GET_PLACE_PHOTO;
    }

    public function getBaseUrl(): string
    {
        return url()->to('/');
    }
}
