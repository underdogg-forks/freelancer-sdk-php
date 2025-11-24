<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests;

use FreelancerSdk\Exceptions\Contests\ContestNotCreatedException;
use FreelancerSdk\Resources\Contests\Contests;
use FreelancerSdk\Session;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ContestsTest extends TestCase
{
    private function sessionWithResponses(Response ...$responses): Session
    {
        $mock    = new MockHandler($responses);
        $handler = HandlerStack::create($mock);
        return new Session('token_123', 'https://fake-fln.com', ['handler' => $handler]);
    }

    #[Test]
    public function it_creates_a_contest(): void
    {
        $responseBody = json_encode([
            'status' => 'success',
            'result' => [
                'id' => 201,
                'owner_id' => 101,
                'title' => 'Design a logo',
                'description' => 'I need a logo for my company',
                'type' => 'freemium',
                'duration' => 7,
                'jobs' => [
                    [
                        'id' => 1,
                        'name' => 'Graphic Design',
                    ],
                    [
                        'id' => 2,
                        'name' => 'Logo Design',
                    ],
                ],
                'currency' => [
                    'id' => 1,
                    'code' => 'USD',
                    'sign' => '$',
                    'name' => 'US Dollar',
                    'exchange_rate' => 1,
                    'country' => 'US',
                ],
                'prize' => 100,
            ],
        ]);

        $session = $this->sessionWithResponses(
            new Response(200, ['Content-Type' => 'application/json'], $responseBody)
        );

        $contests = new Contests($session);
        $contestData = [
            'title' => 'Design a logo',
            'description' => 'I need a logo for my company',
            'type' => 'freemium',
            'duration' => 7,
            'job_ids' => [1, 2],
            'currency_id' => 1,
            'prize' => 100,
        ];

        $contest = $contests->createContest($contestData);

        $this->assertSame(201, $contest->id);
        $this->assertSame('Design a logo', $contest->title);
        $this->assertSame('I need a logo for my company', $contest->description);
        $this->assertSame('freemium', $contest->type);
        $this->assertSame(7, $contest->duration);
        $this->assertSame(100.0, $contest->prize);
    }

    #[Test]
    public function it_throws_exception_when_contest_creation_fails(): void
    {
        $responseBody = json_encode([
            'status' => 'error',
            'message' => 'An error has occurred.',
            'error_code' => 'ExceptionCodes.UNKNOWN_ERROR',
            'request_id' => '3ab35843fb99cde325d819a4',
        ]);

        $session = $this->sessionWithResponses(
            new Response(500, ['Content-Type' => 'application/json'], $responseBody)
        );

        $contests = new Contests($session);
        $contestData = [
            'title' => 'Design a logo',
            'description' => 'I need a logo for my company',
            'type' => 'freemium',
            'duration' => 7,
            'job_ids' => [1, 2],
            'currency_id' => 1,
            'prize' => 100,
        ];

        $this->expectException(ContestNotCreatedException::class);
        $this->expectExceptionMessage('An error has occurred.');

        $contests->createContest($contestData);
    }
}
