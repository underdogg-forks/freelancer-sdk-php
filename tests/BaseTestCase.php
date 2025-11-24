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
    protected function createMockSession(Response ...$responses): Session
    {
        $mock    = new MockHandler($responses);
        $handler = HandlerStack::create($mock);
        return new Session('token_123', 'https://fake-fln.com', ['handler' => $handler]);
    }

    protected function loadFixture(string $name): string
    {
        $path = __DIR__ . '/Fixtures/' . $name;
        if (!file_exists($path)) {
            throw new \RuntimeException("Fixture not found: {$name}");
        }
        return file_get_contents($path);
    }

    protected function createJsonResponse(int $statusCode, array $data): Response
    {
        return new Response(
            $statusCode,
            ['Content-Type' => 'application/json'],
            json_encode($data)
        );
    }

    protected function createSuccessResponse(array $result): Response
    {
        return $this->createJsonResponse(200, [
            'status' => 'success',
            'result' => $result,
        ]);
    }

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
