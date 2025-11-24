<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests;

use FreelancerSdk\Session;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    public function it_sets_headers_and_base_uri(): void
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode(['ok' => true]))
        ]);
        $handler = HandlerStack::create($mock);

        $session = new Session('token_123', 'https://example.com', ['handler' => $handler]);
        $response = $session->getClient()->get('ping');
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('https://example.com/', (string) $session->getClient()->getConfig('base_uri'));
    }

    public function it_throws_when_no_token_is_supplied(): void
    {
        $this->expectException(\FreelancerSdk\Exceptions\AuthTokenNotSuppliedException::class);
        new Session(null);
    }
}
