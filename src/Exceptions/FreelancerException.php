<?php

namespace FreelancerSdk\Exceptions;

use Exception;
use Throwable;

class FreelancerException extends Exception
{
    protected ?string $requestId = null;

    protected ?string $errorCode = null;

    /**
     * Create a FreelancerException with an optional provider error code and request identifier.
     *
     * @param string $message The exception message.
     * @param string|null $errorCode Optional provider-specific error code.
     * @param string|null $requestId Optional request identifier associated with the error.
     * @param int $code The exception code.
     * @param Throwable|null $previous The previous throwable for exception chaining.
     */
    public function __construct(
        string $message = '',
        ?string $errorCode = null,
        ?string $requestId = null,
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->errorCode = $errorCode;
        $this->requestId = $requestId;
    }

    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    public function getRequestId(): ?string
    {
        return $this->requestId;
    }
}