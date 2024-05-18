<?php

namespace App\Services\ExternalApi;

use App\Exceptions\ExternalApi\ExternalApiException;
use App\Services\ExternalApi\Resources\GooglePlacesResourceService;
use App\Services\ExternalApi\Requests\RequestParamsHolder;

class GooglePlacesGatewayService
{
    /**
     * @param RequestParamsHolder $paramsHolder
     * @return BaseApiResponse
     * @throws ExternalApiException
     */
    public static function getPlacesByNearbySearch(RequestParamsHolder $paramsHolder): BaseApiResponse
    {
        return GooglePlacesResourceService::getPlacesByNearbySearch(paramsHolder: $paramsHolder);
    }
}
