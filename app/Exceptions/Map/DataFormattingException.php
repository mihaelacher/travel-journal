<?php

namespace App\Exceptions\Map;

use Exception;

class DataFormattingException extends Exception
{
    public function __construct(string $message = "Error formatting Google Places data.")
    {
        parent::__construct($message);
    }
}
