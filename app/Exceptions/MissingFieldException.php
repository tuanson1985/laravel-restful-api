<?php

namespace App\Exceptions;

use Exception;

class MissingFieldException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }
}
