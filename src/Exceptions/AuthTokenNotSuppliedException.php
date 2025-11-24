<?php

namespace FreelancerSdk\Exceptions;

use Exception;
use Throwable;

class AuthTokenNotSuppliedException extends Exception
{
    public function __construct(string $message = 'OAuth token not supplied', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
