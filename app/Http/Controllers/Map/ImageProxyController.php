<?php

namespace App\Http\Controllers\Map;

use App\Exceptions\Map\StorageLocationPlacePhotoException;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Requests\Map\ImageProxyRequest;
use App\Services\Utils\ExternalApiUtil;
use Illuminate\Contracts\Foundation\Application;

class ImageProxyController extends AuthController
{
    /**
     * Fetches images
     *
     * GET /ajax/place/image
     * @param ImageProxyRequest $request
     * @return Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     * @throws StorageLocationPlacePhotoException
     */
    public function getPlaceImage(ImageProxyRequest $request): \Illuminate\Foundation\Application|\Illuminate\Http\Response|Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $requestData = $request->only(['photo_reference', 'location_id', 'user_id']);
        $extension = pathinfo($requestData['photo_reference'], PATHINFO_EXTENSION);

        $imageData = ExternalApiUtil::buildExternalPlacePhoto(requestData: $requestData);

        return response($imageData, 200)->header('Content-Type', 'image/' . $extension);
    }
}
