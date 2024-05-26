<?php

namespace App\Exceptions\Map;

use Exception;

class DataFormattingException extends Exception
{
    public function __construct(string $message = null)
    {
        $message = $message ?? trans('logging.google_place_format_error');
        parent::__construct($message);
    }
}
