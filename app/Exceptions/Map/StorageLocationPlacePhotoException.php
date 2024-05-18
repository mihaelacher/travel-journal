<?php

namespace App\Exceptions\Map;

use Exception;

class StorageLocationPlacePhotoException extends Exception
{
    public function __construct(string $message = 'Photos with no location are being requested!')
    {
        parent::__construct($message);
    }
}
