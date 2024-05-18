<?php

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Requests\Map\FetchModalGetRequest;
use App\Http\Requests\Map\FetchShareLocationsButtonGetRequest;
use App\Http\Requests\Map\FetchUserVisitedSharedLocationsGetRequest;
use App\Services\Map\ShareLocationsDataService;
use App\Services\Map\VisitedLocationsDataService;
use App\Services\Utils\LogUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ShareLocationsAjaxController extends AuthController
{
    /**
     * @param ShareLocationsDataService $shareLocationsDataService
     * @param VisitedLocationsDataService $visitedLocationsDataService
     */
    public function __construct(
        public ShareLocationsDataService   $shareLocationsDataService,
        public VisitedLocationsDataService $visitedLocationsDataService
    )
    {
        parent::__construct();
    }

    /**
     * Fetches share locations's modal
     *
     * GET /ajax/fetchShareLocationsModal
     * @param FetchModalGetRequest $request
     * @return View
     */
    public function fetchShareLocationsModal(FetchModalGetRequest $request): View
    {
        $currentUserId = $request->currentUser->id;

        $params = [
            'userSharedLocationsUsers'    => $this->shareLocationsDataService->fetchUserSharedLocationsUsers(userId: $currentUserId),
            'userShareLocationsWithUsers' => $this->shareLocationsDataService->fetchUserShareLocationsWithUsers(userId: $currentUserId)
        ];

        return view('map.share-locations-modal', $params);
    }

    /**
     * Fetches location's modal
     *
     * GET /ajax/fetchShareLocationsButton
     * @param FetchShareLocationsButtonGetRequest $request
     * @return View
     */
    public function fetchShareLocationsButton(FetchShareLocationsButtonGetRequest $request): View
    {
        $params = [
            'type'      => 'button',
            'value'     => 'Share locations',
            'classType' => 'btn-floating btn-large green pulse shareLocationsBtn',
            'icon'      => 'share',
        ];
        return view('components.forms.button', $params);
    }

    /**
     * Fetches shared locations modal
     *
     * GET /ajax/fetchUserVisitedSharedLocations
     * @param FetchUserVisitedSharedLocationsGetRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function fetchUserVisitedSharedLocations(FetchUserVisitedSharedLocationsGetRequest $request): JsonResponse
    {
        try {
            $userSharedLocations = $this->visitedLocationsDataService->fetchUsersVisitedLocations(
                userId: $request->query('user_id'),
                isShared: true
            );

            return response()->api(['data' => $userSharedLocations], 200);
        } catch (\Exception $e) {
            LogUtil::logError(message: $e->getMessage());
            return response()->api(['error' => 'Something went wrong. Please, try again later.'], 500);
        }
    }

    /**
     * Share location with user
     *
     * GET /ajax/shareLocationsWithUser
     * @param FetchUserVisitedSharedLocationsGetRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function shareLocationsWithUser(FetchUserVisitedSharedLocationsGetRequest $request): JsonResponse
    {
        try {
            $shareLocationsUserId = $request->input('user_id');
            $currentUserId = $request->currentUser->id;
            $this->shareLocationsDataService->shareLocationsWithUser(
                userId: $currentUserId,
                shareLocationsUserId: $shareLocationsUserId
            );

            return response()->api(['message' => 'Location successfully shared.'], 200);
        } catch (\Exception $e) {
            LogUtil::logError($e->getMessage());
            return response()->api(['error' => 'Something went wrong. Please, try again later.'], 500);
        }
    }
}
