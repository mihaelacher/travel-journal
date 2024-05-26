<?php

namespace App\Services\Map;

use App\Data\Map\VisitedLocationData;
use App\Exceptions\General\FileStorageException;
use App\Exceptions\General\UnSupportedMimeTypeExtension;
use App\Models\Location;
use App\Models\UserLocation;
use App\Services\Utils\ExternalApiUtil;
use App\Services\Utils\FileServiceUtil;
use App\Services\Utils\LogUtil;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class VisitedLocationsDataService
{
    /**
     * Fetches user's visited locations
     *
     * @param int $userId Requested user visited locations id
     * @param bool $isShared Determines if current user or shared locations are needed
     * @return array
     * @throws \Exception
     */
    public function fetchUsersVisitedLocations(int $userId, bool $isShared = false): array
    {
        $visitedLocations = $this->getUsersVisitedLocationsFromDb(userId: $userId, isShared: $isShared);
        $this->formatLocationData(locations: $visitedLocations);
        return $visitedLocations;
    }

    /**
     * Creates necessary entries for a visited location
     *
     * @param VisitedLocationData $data
     * @return void
     * @throws FileStorageException
     * @throws UnSupportedMimeTypeExtension
     * @throws \Throwable
     */
    public function markLocationAsVisited(VisitedLocationData $data): void
    {
        try {
            DB::beginTransaction();

            $this->fetchLocationId(data: $data);
            $fileReferences = FileServiceUtil::storeFiles(
                files: $data->photos ?? [],
                userId: $data->user_id,
                locationId: $data->location_id
            );
            $this->createUserLocation(data: $data, fileReferences: $fileReferences);

            DB::commit();
        } catch (\Throwable $t) {
            DB::rollBack();
            LogUtil::logError($t->getMessage());
            throw $t;
        }
    }

    /**
     * Checks if the user has visited given location
     *
     * @param int $locationId
     * @param int $userId
     * @return bool
     */
    public function isLocationVisitedByUser(int $locationId, int $userId): bool
    {
        return UserLocation::where('location_id', '=', $locationId)
            ->where('user_id', '=', $userId)
            ->exists();
    }

    /**
     * Deletes visited locations and related data
     *
     * @param int $locationId
     * @param int $userId
     * @return void
     * @throws FileStorageException
     * @throws \Throwable
     */
    public function deleteVisitedLocation(int $locationId, int $userId): void
    {
        try {
            DB::beginTransaction();
            $userLocation = UserLocation::where('location_id', '=', $locationId)
                ->where('user_id', '=', $userId)
                ->first();

            $photoReferences = json_decode($userLocation->photo_references ?? '') ?? [];

            FileServiceUtil::deleteUserLocationFile(
                locationId: $locationId,
                userId:  $userId,
                photoReferences:  $photoReferences
            );

            $userLocation->delete();
            DB::commit();
        } catch (\Throwable $t) {
            DB::rollBack();
            LogUtil::logError($t->getMessage());
            throw $t;
        }
    }

    /**
     * Fetches visited locations from DB
     *
     * @param int $userId
     * @param bool $isShared
     * @return array
     */
    private function getUsersVisitedLocationsFromDb(int $userId, bool $isShared = false): array
    {
        return UserLocation::join('locations as l', 'l.id', '=', 'user_locations.location_id')
            ->join('users as u', 'u.id', '=', 'user_locations.user_id')
            ->where('user_locations.user_id', '=', $userId)
            ->select([
                DB::raw('JSON_UNQUOTE(JSON_EXTRACT(user_locations.photo_references, "$[*]")) as photo_references'),
                'l.latitude',
                'l.longitude',
                'l.name',
                'l.id as location_id',
                'user_locations.visited_at',
                DB::raw((int)!$isShared . ' as is_visited'),
                !$isShared
                    ? DB::raw('"' . url('/') . '/images/visited-location-icon.png" as icon')
                    : DB::raw('COALESCE(u.pic, "' . url('/') . '/images/shared-location-icon.png") as icon'),
                DB::raw('CONCAT_WS("_", u.id, u.email) as user_key'),
                DB::raw((int)$isShared . ' as is_shared'),
                'u.id as user_id',
            ])
            ->get()
            ->toArray();
    }

    /**
     * Formats location data by building photo urls
     *
     * @param array $locations
     * @return void
     * @throws \Exception
     */
    private function formatLocationData(array &$locations): void
    {
        foreach ($locations as &$location) {
            $location['photo_urls'] = ExternalApiUtil::buildPlacePhotoUrls(locationData: $location);
        }
    }

    /**
     * Searches for existing location in db by latitude and longitude
     *
     * @param VisitedLocationData $data
     * @return void
     */
    private function fetchLocationId(VisitedLocationData $data): void
    {
        if (! isset($data->location_id)) {
            $location = new Location(
                [
                    'latitude'      => $data->latitude,
                    'longitude'     => $data->longitude,
                    'name'          => $data->name
                ]
            );
            $location->save();
            $data->location_id = $location->id;
        }
    }

    /**
     * Creates user location's entry
     *
     * @param VisitedLocationData $data
     * @param array $fileReferences
     * @return void
     */
    private function createUserLocation(VisitedLocationData $data, array $fileReferences): void
    {
        $userLocation = UserLocation::create(
            Arr::only($data->toArray(), ['user_id', 'location_id', 'visited_at'])
            + array('photo_references' => json_encode($fileReferences))
        );
        $userLocation->save();
    }
}
