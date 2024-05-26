<?php

namespace App\Exceptions\General;

use Exception;

class UnassignableAttributeException extends Exception
{
    public function __construct(string $message = null)
    {
        $message = $message ?? trans('logging.unassignable_attribute_error');
        parent::__construct($message);
    }
}
