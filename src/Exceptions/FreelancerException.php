<?php

namespace FreelancerSdk\Exceptions;

use Exception;
use Throwable;

class FreelancerException extends Exception
{
    protected ?string $requestId = null;

    protected ?string $errorCode = null;

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
