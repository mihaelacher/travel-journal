<?php

namespace App\Services\ExternalApi\Resources;

use App\Data\ExternalApi\GooglePlacesEndpointData;
use App\Exceptions\ExternalApi\ExternalApiException;
use App\Services\ExternalApi\BaseApiResponse;
use App\Services\ExternalApi\ExternalApiClient;
use App\Services\ExternalApi\Requests\RequestParamsHolder;

class GooglePlacesResourceService
{
    /////////////////// Service API calls /////////////////////////

    /**
     * @param RequestParamsHolder $paramsHolder
     * @return BaseApiResponse
     * @throws ExternalApiException
     * @throws \Exception
     */
    public static function getPlacesByNearbySearch(RequestParamsHolder $paramsHolder): BaseApiResponse
    {
        $endpointDto = new GooglePlacesEndpointData(...$paramsHolder->getSearchParams());
        $apiClient = new ExternalApiClient(method: 'GET', dataObject: $endpointDto);

        return $apiClient->send();
    }
}
