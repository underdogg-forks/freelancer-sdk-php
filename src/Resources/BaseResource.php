<?php

declare(strict_types=1);

namespace FreelancerSdk\Resources;

use FreelancerSdk\Session;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

/**
 * Base class for all API resources.
 *
 * Provides shared functionality for JSON response decoding and session management.
 */
abstract class BaseResource
{
    protected Session $session;

    /**
     * Initialize the resource with a Session for performing API requests.
     *
     * @param Session $session Session used to perform HTTP requests to the API.
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Decode a JSON response body and validate it.
     *
     * @param ResponseInterface $response The HTTP response to decode.
     * @return array The decoded JSON response as an associative array.
     * @throws RuntimeException If the response body is not valid JSON.
     */
    protected function decodeJsonResponse(ResponseInterface $response): array
    {
        $decoded = json_decode($response->getBody()->getContents(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Invalid JSON response: ' . json_last_error_msg());
        }

        return $decoded;
    }
}
