<?php

namespace App\Exceptions;

use Exception;

class ImageNotUploadedException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = 'Image file not found', $code = 422)
    {
        parent::__construct($message, $code);
    }
}
