<?php

namespace App\Data\ExternalApi;

use App\Services\ExternalApi\EndpointConstants;
use Spatie\LaravelData\Attributes\MapInputName;

class StoragePhotoEndpointData extends BaseEndpointData
{
    public function __construct(
        #[MapInputName('photo_reference')]
        public string $photoReference,
        #[MapInputName('location_id')]
        public ?int $locationId,
        #[MapInputName('user_id')]
        public ?string $userId = null,
    ) {
    }

    // ---------------------------------- GETTERS ------------------------------------------ //
    public function getPathPattern(): string
    {
        return EndpointConstants::GET_STORAGE_PHOTO;
    }

    public function getBaseUrl(): string
    {
        return '';
    }
}
