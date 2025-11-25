<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests;

use FreelancerSdk\Session;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Base test class with shared utilities
 */
abstract class BaseTestCase extends TestCase
{
    /**
     * Create a Session instance backed by a Guzzle mock handler populated with the given responses.
     *
     * @param Response[] $responses Responses to be returned by the mock HTTP handler in the order provided.
     * @return Session A Session configured to use the mock handler for HTTP requests.
     */
    protected function createMockSession(Response ...$responses): Session
    {
        $mock    = new MockHandler($responses);
        $handler = HandlerStack::create($mock);
        return new Session('token_123', 'https://fake-fln.com', ['handler' => $handler]);
    }

    /**
     * Load a test fixture file from the Fixtures directory.
     *
     * @param string $name The fixture filename relative to the Fixtures directory.
     * @return string The contents of the fixture file.
     * @throws \RuntimeException If the fixture file does not exist.
     */
    protected function loadFixture(string $name): string
    {
        $path = __DIR__ . '/Fixtures/' . $name;
        if (!file_exists($path)) {
            throw new \RuntimeException("Fixture not found: {$name}");
        }
        return file_get_contents($path);
    }

    /**
     * Wraps a fixture file as an HTTP JSON response.
     *
     * @param string $name The fixture filename located under the Fixtures directory.
     * @param int $statusCode The HTTP status code to use for the response.
     * @return Response The HTTP response with `Content-Type: application/json` and body from the fixture.
     * @throws \RuntimeException If the fixture file cannot be found or read.
     */
    protected function loadFixtureAsResponse(string $name, int $statusCode = 200): Response
    {
        return new Response(
            $statusCode,
            ['Content-Type' => 'application/json'],
            $this->loadFixture($name)
        );
    }

    /**
     * Create an HTTP JSON response with the specified status code and JSON-encoded body.
     *
     * @param int $statusCode HTTP status code for the response.
     * @param array $data Data to encode as JSON for the response body.
     * @return Response HTTP response with `Content-Type: application/json` and the JSON-encoded body.
     */
    protected function createJsonResponse(int $statusCode, array $data): Response
    {
        return new Response(
            $statusCode,
            ['Content-Type' => 'application/json'],
            json_encode($data)
        );
    }

    /**
     * Create a standardized success JSON HTTP response containing the provided result payload.
     *
     * @param array $result The payload to include under the `result` key in the response body.
     * @return Response A Response with status code 200 and a JSON body `{"status":"success","result": ...}`.
     */
    protected function createSuccessResponse(array $result): Response
    {
        return $this->createJsonResponse(200, [
            'status' => 'success',
            'result' => $result,
        ]);
    }

    /**
     * Create a standardized HTTP error response with a JSON body.
     *
     * @param string $message Human-readable error message to include in the response.
     * @param string $errorCode Machine-readable error code to include under `error_code`.
     * @param string $requestId Identifier for the request to include under `request_id`.
     * @return Response A Response with status code 500 and a JSON body containing `status` ("error"), `message`, `error_code`, and `request_id`.
     */
    protected function createErrorResponse(
        string $message = 'An error has occurred.',
        string $errorCode = 'ExceptionCodes.UNKNOWN_ERROR',
        string $requestId = '3ab35843fb99cde325d819a4'
    ): Response {
        return $this->createJsonResponse(500, [
            'status'     => 'error',
            'message'    => $message,
            'error_code' => $errorCode,
            'request_id' => $requestId,
        ]);
    }
}