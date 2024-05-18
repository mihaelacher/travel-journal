<?php

namespace App\Data\ExternalApi;

use App\Services\ExternalApi\EndpointConstants;
use Spatie\LaravelData\Attributes\MapInputName;

class GooglePlacePhotoEndpointData extends BaseEndpointData
{
    public string $apiKey;

    public function __construct(
        #[MapInputName('photo_reference')]
        public string $photoReference
    ) {
        $this->apiKey = $this->getApiKey();
    }

    // ---------------------------------- GETTERS ------------------------------------------ //
    public function getPathPattern(): string
    {
        return EndpointConstants::GET_GOOGLE_PLACE_PHOTO;
    }

    public function getBaseUrl()
    {
        return config('services.google_places.base_url');
    }

    private function getApiKey(): mixed
    {
        return config('services.google_places.api_key');
    }
}
