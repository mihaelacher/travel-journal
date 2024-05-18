<?php

namespace App\Exceptions\General;

use Exception;

class FileStorageException extends Exception
{
    public function __construct(string $message = 'File storage not available. Please, try again later.')
    {
        parent::__construct($message);
    }
}
