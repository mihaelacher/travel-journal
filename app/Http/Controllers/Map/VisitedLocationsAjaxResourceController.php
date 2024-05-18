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
     * GET /ajax/fetchVisitedLocations
     * @param FetchVisitedLocationsGetRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function fetchVisitedLocations(FetchVisitedLocationsGetRequest $request): JsonResponse
    {
        try {
            $visitedLocations = $this->locationDataService->fetchUsersVisitedLocations(userId: $request->currentUser->id);

            return response()->api(['data' => $visitedLocations], 200);
        } catch (\Exception $e) {
            LogUtil::logError(message: $e->getMessage());
            return response()->api(['error' => 'Something went wrong. Please, try again later.'], 500);
        }
    }

    /**
     * Marks placed as visited by providing date and location's photos
     *
     * POST /ajax/markLocationAsVisited
     * @param MarkLocationAsVisitedPostRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function markLocationAsVisited(MarkLocationAsVisitedPostRequest $request): JsonResponse
    {
        try {
            $markLocationAsVisitedData = VisitedLocationData::from(
                $request->input()
                + array('user_id' => $request->currentUser->id)
                + array('uploaded_files' => $request->files->get('uploaded_files'))
            );

            $this->locationDataService->markLocationAsVisited(data: $markLocationAsVisitedData);

            return response()->api(['message' => 'You\'ve successfully marked the place as visited.'], 200);
        } catch (FileStorageException $e) {
            return response()->api(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            LogUtil::logError(message: $e->getMessage());
            return response()->api(['error' => 'Something went wrong. Please, try again later.'], 500);
        }
    }

    /**
     * Delete visited location
     *
     * POST /ajax/deleteVisitedLocation
     * @param DeleteVisitedLocationRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function deleteVisitedLocation(DeleteVisitedLocationRequest $request): JsonResponse
    {
        try {
            $this->locationDataService->deleteVisitedLocation(
                locationId: $request->input('location_id'),
                userId: Auth::id()
            );

            return response()->api(['message' => 'You\'ve successfully deleted the visited place.'], 200);
        } catch (FileStorageException $e) {
            return response()->api(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            LogUtil::logError(message: $e->getMessage());
            return response()->api(['error' => 'Something went wrong. Please, try again later.'], 500);
        }
    }
}
