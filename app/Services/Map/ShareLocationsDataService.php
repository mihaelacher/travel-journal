<?php

namespace App\Services\Map;

use App\Models\ShareLocationsUser;

class ShareLocationsDataService
{
    /**
     * Fetches all users that have shared location with the current user
     *
     * @param int $userId
     * @return array
     */
    public function fetchUserSharedLocationsUsers(int $userId): array
    {
        return ShareLocationsUser::join('users as share_locations_user', 'share_locations_user.id', '=', 'user_id')
            ->where('share_locations_user_id', '=', $userId)
            ->select('share_locations_user.*')
            ->get()
            ->keyBy('id')
            ?->toArray();
    }

    /**
     * Fetches all users that the current user shares locations with
     *
     * @param int $userId
     * @return array
     */
    public function fetchUserShareLocationsWithUsers(int $userId): array
    {
        return ShareLocationsUser::join('users as share_locations_user', 'share_locations_user.id', '=', 'share_locations_user_id')
            ->where('user_id', '=', $userId)
            ->select('share_locations_user.*')
            ->get()
            ->keyBy('id')
            ?->toArray();
    }

    /**
     * Inserts share_location_users entry
     *
     * @param int $userId
     * @param int $shareLocationsUserId
     * @return void
     */
    public function shareLocationsWithUser(int $userId, int $shareLocationsUserId): void
    {
        ShareLocationsUser::insert(
            [
                'user_id'                 => $userId,
                'share_locations_user_id' => $shareLocationsUserId
            ]
        );
    }

    /**
     * Checks if the user has shared location for the given location id or user id
     *
     * @param int|null $locationId
     * @param int|null $userId
     * @param int|null $locationShareUserId
     * @return bool
     */
    public function isLocationSharedWithUser(int $userId = null, int $locationId = null, int $locationShareUserId = null): bool
    {
        if (!isset($locationId) && !isset($locationShareUserId)) {
            return false;
        }

        $query = ShareLocationsUser::join('user_locations', 'user_locations.user_id', '=', 'share_locations_users.user_id')
            ->where('share_locations_users.share_locations_user_id', '=', $userId);

        if (isset($locationId)) {
            $query->where('user_locations.location_id', '=', $locationId);
        }

        if (isset($locationShareUserId)) {
            $query->where('share_locations_users.user_id', '=', $locationShareUserId);
        }

        return $query->exists();
    }
}
