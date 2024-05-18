<?php

namespace App\Services\ExternalApi;

final class EndpointConstants
{
    const GET_GOOGLE_PLACES_NEARBY_SEARCH = '/nearbysearch/json?location={placeLocation}&radius={placeRadius}&type={placeType}&key={apiKey}';
    const GET_PLACE_PHOTO = '/getPlaceImage?user_id={userId}&location_id={locationId}&photo_reference={photoReference}&is_visited={isVisited}';
    const GET_GOOGLE_PLACE_PHOTO = '/photo?maxwidth=800&photoreference={photoReference}&key={apiKey}';
    const GET_STORAGE_PHOTO = 'user/{userId}/{locationId}/{photoReference}';
}
