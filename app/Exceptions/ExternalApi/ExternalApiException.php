<?php

namespace App\Exceptions\ExternalApi;

use Exception;

class ExternalApiException extends Exception
{
    public function __construct(string $message = null)
    {
        $message = $message ?? trans('map.api_not_available_error');
        parent::__construct($message);
    }
}
