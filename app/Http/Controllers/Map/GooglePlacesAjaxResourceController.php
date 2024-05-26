<?php

namespace App\Http\Controllers\Map;

use App\Exceptions\ExternalApi\ExternalApiException;
use App\Exceptions\Map\DataFormattingException;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Requests\Map\FetchNearbyLocationsGetRequest;
use App\Services\ExternalApi\GooglePlacesGatewayService;
use App\Services\ExternalApi\Requests\RequestParamsHolder;
use App\Services\Map\GooglePlacesDataService;
use App\Services\Utils\LogUtil;

class GooglePlacesAjaxResourceController extends AuthController
{
    /**
     * @param GooglePlacesDataService $googlePlacesDataFormatter
     */
    public function __construct(public GooglePlacesDataService $googlePlacesDataFormatter)
    {
        parent::__construct();
    }

    /**
     * Fetches nearby locations based on user clicked locations using Google Places API
     *
     * GET /ajax/nearby-locations
     *
     * @param FetchNearbyLocationsGetRequest $request
     * @return mixed
     */
    public function fetchNearbyLocations(FetchNearbyLocationsGetRequest $request): mixed
    {
        $clickedLocation = $request->query('clickedLocation');

        try {
            $apiResponse = GooglePlacesGatewayService::getPlacesByNearbySearch(
                paramsHolder: new RequestParamsHolder([
                    'location' => $clickedLocation
                ])
            );

            $statusCode = $apiResponse->getStatusCode();
            $content = $this->googlePlacesDataFormatter->getGooglePlacesFormattedData(apiData: $apiResponse->getContent());
        } catch (ExternalApiException $e) {
            $statusCode = 500; // External api error
            $content = ['error' => $e->getMessage()];
        } catch (DataFormattingException $e) {
            $statusCode = 400;  // Bad Request
            $content = ['error' => $e->getMessage()];
        } catch (\Exception $e) {
            LogUtil::error(msg: $e->getMessage());
            $statusCode = 500;  // Internal Server Error
            $content = ['error' => $e->getMessage()];
        }

        return response()->api($content, $statusCode);
    }
}
