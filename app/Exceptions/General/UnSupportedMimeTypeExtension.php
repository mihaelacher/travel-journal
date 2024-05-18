<?php

namespace App\Exceptions\General;

use Exception;

class UnSupportedMimeTypeExtension extends Exception
{
    public function __construct(string $message = 'Unsupported file format.')
    {
        parent::__construct($message);
    }
}
