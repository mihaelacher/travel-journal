<?php

namespace App\Exceptions\General;

use Exception;

class UnassignableAttributeException extends Exception
{
    public function __construct(string $message = 'Unassignable attribute.')
    {
        parent::__construct($message);
    }
}
