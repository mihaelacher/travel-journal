<?php

namespace App\Data\ExternalApi;

use App\Services\ExternalApi\EndpointConstants;
use Spatie\LaravelData\Attributes\MapInputName;

class GooglePlacesEndpointData extends BaseEndpointData
{
    public string $placeLocation;
    public string $apiKey;

    public function __construct(
        array $location,
        #[MapInputName('radius')]
        public int $placeRadius = 5000,
        #[MapInputName('type')]
        public string $placeType = 'tourist_attraction',
    ) {
        $this->placeLocation = $location['lat'] . '%2C' . $location['lng'];
        $this->apiKey = $this->getApiKey();
    }

    // ---------------------------------- GETTERS ------------------------------------------ //
    public function getPathPattern(): string
    {
        return EndpointConstants::GET_GOOGLE_PLACES_NEARBY_SEARCH;
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
