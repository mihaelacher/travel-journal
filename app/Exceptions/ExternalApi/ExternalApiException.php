<?php

namespace App\Exceptions\ExternalApi;

use Exception;

class ExternalApiException extends Exception
{
    public function __construct(string $message = 'API is not available')
    {
        parent::__construct($message);
    }
}
