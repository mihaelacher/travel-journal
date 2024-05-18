<?php

namespace App\Services\Utils;

use App\Data\ExternalApi\GooglePlacePhotoEndpointData;
use App\Data\ExternalApi\PlacePhotoEndpointData;
use App\Data\ExternalApi\StoragePhotoEndpointData;
use App\Exceptions\Map\StorageLocationPlacePhotoException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class ExternalApiUtil
{
    /**
     * Builds external place photo url for safer access through proxy (not direct S3 storage/Google Places API access)
     *
     * @param array $locationData
     * @return array
     * @throws \Exception
     */
    public static function buildPlacePhotoUrls(array $locationData): array
    {
        $photoUrls = [];
        $placePhotoReferences = json_decode($locationData['photo_references'], true) ?? [];

        foreach ($placePhotoReferences as $photoReference) {

            if (isset($photoReference)) {
                $endpointDto = PlacePhotoEndpointData::from($locationData + ['photo_reference' => $photoReference]);
                $photoUrls[] = $endpointDto->buildEndpoint();
            }
        }

        return $photoUrls;
    }

    /**
     * Navigates to requested photo, method not accessible through request, but only internal
     *
     * @param array $requestData
     * @return string|void|null
     * @throws StorageLocationPlacePhotoException
     * @throws \Exception
     */
    public static function buildExternalPlacePhoto(array $requestData)
    {
        if (isset($requestData['user_id'])) {
            if (!isset($requestData['location_id'])) {
                throw new StorageLocationPlacePhotoException();
            }
            return self::buildStoragePlacePhoto(requestData: $requestData);
        } else {
            self::buildGooglePlacesPhoto(requestData: $requestData);
        }
    }

    /**
     *  Builds place photo url Google Places API access
     *
     * @param array $requestData
     * @return void
     * @throws \Exception
     */
    private static function buildGooglePlacesPhoto(array $requestData): void
    {
        $endpointDto = GooglePlacePhotoEndpointData::from($requestData);
        $photoUrl = $endpointDto->buildEndpoint();

        readfile(urldecode($photoUrl));
    }

    /**
     * Builds place photo url for S3 storage access
     *
     * @param array $requestData
     * @return string|null
     * @throws \Exception
     */
    private static function buildStoragePlacePhoto(array $requestData): ?string
    {
        $endpointDto = StoragePhotoEndpointData::from($requestData);
        $photoUrl = $endpointDto->buildEndpoint();

        return Storage::disk(Config::get('filesystems.default'))->get($photoUrl);
    }
}
