<?php

namespace App\Exceptions\Map;

use Exception;

class StorageLocationPlacePhotoException extends Exception
{
    public function __construct(string $message = null)
    {
        $message = $message ?? trans('logging.no_location_photo_request_error');
        parent::__construct($message);
    }
}
