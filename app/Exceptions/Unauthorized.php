<?php

namespace App\Exceptions;

use Exception;

class Unauthorized extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = 'Unauthorized', $code = 401)
    {
        parent::__construct($message, $code);
    }
}
