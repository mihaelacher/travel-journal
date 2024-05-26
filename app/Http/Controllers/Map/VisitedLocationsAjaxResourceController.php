<?php

namespace App\Http\Controllers\Map;

use App\Data\Map\VisitedLocationData;
use App\Exceptions\General\FileStorageException;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Requests\Map\DeleteVisitedLocationRequest;
use App\Http\Requests\Map\FetchVisitedLocationsGetRequest;
use App\Http\Requests\Map\MarkLocationAsVisitedPostRequest;
use App\Services\Map\VisitedLocationsDataService;
use App\Services\Utils\LogUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\Exceptions\CannotCreateData;

class VisitedLocationsAjaxResourceController extends AuthController
{
    /**
     * @param VisitedLocationsDataService $locationDataService
     */
    public function __construct(public VisitedLocationsDataService $locationDataService)
    {
        parent::__construct();
    }

    /**
     * Fetches current user's visited locations
     *
     * GET /ajax//visited-locations
     * @param FetchVisitedLocationsGetRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function fetchVisitedLocations(FetchVisitedLocationsGetRequest $request): JsonResponse
    {
        try {
            $visitedLocations = $this->locationDataService->fetchUsersVisitedLocations(userId: $request->currentUser->id);

            return response()->api(['data' => $visitedLocations], 200);
        } catch (CannotCreateData $exception) {
            return response()->api(['error' => trans('map.data_not_complete')], 400);
        } catch (\Exception $e) {
            LogUtil::logError(message: $e->getMessage());
            return response()->api(['error' => trans('map.general_error')], 500);
        }
    }

    /**
     * Marks placed as visited by providing date and location's photos
     *
     * POST /ajax/location/{latitude}/{longitude}/mark-as-visited
     * @param MarkLocationAsVisitedPostRequest $request
     * @param string $latitude
     * @param string $longitude
     * @return JsonResponse
     * @throws \Throwable
     */
    public function markLocationAsVisited(MarkLocationAsVisitedPostRequest $request, string $latitude, string $longitude): JsonResponse
    {
        try {
            $markLocationAsVisitedData = VisitedLocationData::from(
                $request->only(['location_id', 'name', 'visited_at'])
                + [
                    'latitude'      => $latitude,
                    'longitude'     => $longitude,
                    'user_id'       => $request->currentUser->id,
                    'uploaded_files'=> $request->files->get('uploaded_files'),
                ]
            );

            $this->locationDataService->markLocationAsVisited(data: $markLocationAsVisitedData);

            return response()->api(['message' => trans('map.mark_as_visited_success')], 200);
        } catch (CannotCreateData $exception) {
            return response()->api(['error' => trans('map.data_not_complete')], 400);
        } catch (FileStorageException $e) {
            return response()->api(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            LogUtil::logError(message: $e->getMessage());
            return response()->api(['error' => trans('map.general_error')], 500);
        }
    }

    /**
     * Delete visited location
     *
     * POST /ajax/visited-locations/{locationId}
     * @param DeleteVisitedLocationRequest $request
     * @param int $locationId
     * @return JsonResponse
     * @throws \Throwable
     */
    public function deleteVisitedLocation(DeleteVisitedLocationRequest $request, int $locationId): JsonResponse
    {
        try {
            $this->locationDataService->deleteVisitedLocation(
                locationId: $locationId,
                userId: $request->currentUser->id
            );

            return response()->api(['message' => trans('map.delete_location_success')], 200);
        } catch (FileStorageException $e) {
            return response()->api(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            LogUtil::logError(message: $e->getMessage());
            return response()->api(['error' => trans('map.general_error')], 500);
        }
    }
}
