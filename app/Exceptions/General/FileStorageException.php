<?php

namespace App\Exceptions\General;

use Exception;

class FileStorageException extends Exception
{
    public function __construct(string $message = null)
    {
        $message = $message ?? trans('logging.storage_not_available_error');
        parent::__construct($message);
    }
}
