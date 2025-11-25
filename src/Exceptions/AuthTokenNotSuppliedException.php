<?php

namespace FreelancerSdk\Exceptions;

use Exception;
use Throwable;

class AuthTokenNotSuppliedException extends Exception
{
    /**
     * Create an exception indicating an OAuth token was not supplied.
     *
     * @param string $message Error message; defaults to 'OAuth token not supplied'.
     * @param int $code Error code.
     * @param Throwable|null $previous Previous exception for chaining.
     */
    public function __construct(string $message = 'OAuth token not supplied', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
