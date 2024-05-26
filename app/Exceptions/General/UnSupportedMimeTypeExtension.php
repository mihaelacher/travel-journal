<?php

namespace App\Exceptions\General;

use Exception;

class UnSupportedMimeTypeExtension extends Exception
{
    public function __construct(string $message = null)
    {
        $message = $message ?? trans('logging.unsupported_file_format_error');
        parent::__construct($message);
    }
}
