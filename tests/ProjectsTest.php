<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests;

use FreelancerSdk\Exceptions\Projects\ProjectsNotFoundException;
use FreelancerSdk\Resources\Projects\Projects;
use FreelancerSdk\Session;
use FreelancerSdk\Types\Project;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ProjectsTest extends TestCase
{
    private function sessionWithResponses(Response ...$responses): Session
    {
        $mock    = new MockHandler($responses);
        $handler = HandlerStack::create($mock);
        return new Session('token_123', 'https://fake-fln.com', ['handler' => $handler]);
    }

    private function fixture(string $name): string
    {
        return file_get_contents(__DIR__ . '/Fixtures/' . $name);
    }

    #[Test]
    public function it_creates_a_project(): void
    {
        $responseBody = json_encode([
            'status' => 'success',
            'result' => [
                'title'   => 'My New Project',
                'seo_url' => 'java/foo',
            ],
        ]);

        $session = $this->sessionWithResponses(
            new Response(200, ['Content-Type' => 'application/json'], $responseBody)
        );

        $projects    = new Projects($session);
        $projectData = [
            'title'       => 'My new project',
            'description' => 'description',
            'currency'    => ['id' => 1],
            'budget'      => ['minimum' => 10],
            'jobs'        => [['id' => 7]],
        ];

        $project = $projects->createProject($projectData);

        $this->assertInstanceOf(Project::class, $project);
        $this->assertSame('My New Project', $project->title);
        $this->assertSame('https://fake-fln.com/projects/java/foo', $project->url);
    }

    #[Test]
    public function it_gets_projects(): void
    {
        $responseBody = json_encode([
            'status' => 'success',
            'result' => [
                'total_count'   => 3,
                'selected_bids' => null,
                'users'         => [
                    '101' => ['id' => '101', 'username' => 'user1'],
                    '102' => ['id' => '102', 'username' => 'user2'],
                    '103' => ['id' => '103', 'username' => 'user3'],
                ],
                'projects' => [
                    [
                        'id'          => 201,
                        'title'       => 'Phasellus blandit posuere enim',
                        'description' => 'Morbi libero elit, posuere eu suscipit et dignissim non urna.',
                    ],
                    [
                        'id'          => 202,
                        'title'       => 'Donec fringilla elit velit',
                        'description' => 'Vestibulum mauris risus, molestie vel velit a, semper ultricies odio.',
                    ],
                    [
                        'id'          => 203,
                        'title'       => 'In hac habitasse platea dictumst',
                        'description' => 'Duis sed tristique urna. Nullam vestibulum elit at quam dapibus venenatis.',
                    ],
                ],
            ],
        ]);

        $session = $this->sessionWithResponses(
            new Response(200, ['Content-Type' => 'application/json'], $responseBody)
        );

        $projects = new Projects($session);
        $query    = [
            'projects[]'       => [201, 202, 203],
            'full_description' => true,
            'user_details'     => true,
        ];

        $result = $projects->getProjects($query);

        $this->assertIsArray($result);
        $this->assertCount(3, $result);
        $this->assertInstanceOf(Project::class, $result[0]);
        $this->assertSame('Phasellus blandit posuere enim', $result[0]->title);
    }

    #[Test]
    public function it_searches_projects(): void
    {
        $responseBody = json_encode([
            'status' => 'success',
            'result' => [
                'total_count'   => 1000,
                'selected_bids' => [],
                'users'         => [],
                'projects'      => [
                    [
                        'id'          => 201,
                        'title'       => 'Phasellus blandit posuere enim',
                        'description' => 'Morbi libero elit, posuere eu suscipit logo et dignissim non urna.',
                    ],
                    [
                        'id'          => 202,
                        'title'       => 'Donec fringilla elit velit',
                        'description' => 'Vestibulum mauris risus, molestie logo vel velit a, semper ultricies odio.',
                    ],
                    [
                        'id'          => 203,
                        'title'       => 'In hac habitasse platea dictumst',
                        'description' => 'Duis sed tristique urna. Nullam vestibulum elit at quam dapibus logo venenatis.',
                    ],
                ],
            ],
        ]);

        $session = $this->sessionWithResponses(
            new Response(200, ['Content-Type' => 'application/json'], $responseBody)
        );

        $projects = new Projects($session);
        $result   = $projects->searchProjects([
            'query'  => 'logo design',
            'limit'  => 3,
            'offset' => 0,
        ]);

        $this->assertIsArray($result);
        $this->assertCount(3, $result);
        $this->assertInstanceOf(Project::class, $result[0]);
    }

    #[Test]
    public function it_gets_a_project_by_id(): void
    {
        $responseBody = json_encode([
            'status' => 'success',
            'result' => [
                'id'     => 2,
                'title'  => 'Sample title',
                'tracks' => [1, 2],
            ],
        ]);

        $session = $this->sessionWithResponses(
            new Response(200, ['Content-Type' => 'application/json'], $responseBody)
        );

        $projects = new Projects($session);
        $result   = $projects->getProject(2);

        $this->assertInstanceOf(Project::class, $result);
        $this->assertSame(2, $result->id);
        $this->assertSame('Sample title', $result->title);
        $this->assertIsArray($result->tracks);
        $this->assertCount(2, $result->tracks);
    }

    #[Test]
    public function it_throws_exception_when_project_not_found(): void
    {
        $responseBody = json_encode([
            'status'     => 'error',
            'message'    => 'An error has occurred.',
            'error_code' => 'ExceptionCodes.UNKNOWN_ERROR',
            'request_id' => '3ab35843fb99cde325d819a4',
        ]);

        $session = $this->sessionWithResponses(
            new Response(500, ['Content-Type' => 'application/json'], $responseBody)
        );

        $projects = new Projects($session);

        $this->expectException(ProjectsNotFoundException::class);
        $this->expectExceptionMessage('An error has occurred.');

        $projects->getProject(2);
    }

    #[Test]
    public function it_places_a_bid(): void
    {
        $responseBody = json_encode([
            'status' => 'success',
            'result' => [
                'milestone_percentage' => 100,
                'period'               => 2,
                'id'                   => 39343812,
                'retracted'            => false,
                'project_owner_id'     => 12,
                'submitdate'           => 1424142980,
                'project_id'           => 1,
                'bidder_id'            => 2,
                'description'          => 'A bid',
                'time_submitted'       => 1424142980,
                'amount'               => 10,
            ],
        ]);

        $session = $this->sessionWithResponses(
            new Response(200, ['Content-Type' => 'application/json'], $responseBody)
        );

        $projects = new Projects($session);
        $bidData  = [
            'bidder_id'            => 2,
            'amount'               => 10,
            'period'               => 2,
            'milestone_percentage' => 100,
            'description'          => 'A bid',
        ];

        $bid = $projects->placeBid(1, $bidData);

        $this->assertSame(39343812, $bid->id);
        $this->assertSame(2, $bid->bidder_id);
        $this->assertSame('A bid', $bid->description);
        $this->assertEquals(10, $bid->amount); // Use assertEquals instead of assertSame for numeric comparison
    }

    #[Test]
    public function it_gets_bids(): void
    {
        $responseBody = json_encode([
            'status' => 'success',
            'result' => [
                'bids' => [
                    ['id' => 301, 'project_id' => 201, 'bidder_id' => 101],
                    ['id' => 302, 'project_id' => 201, 'bidder_id' => 102],
                    ['id' => 303, 'project_id' => 201, 'bidder_id' => 103],
                    ['id' => 304, 'project_id' => 202, 'bidder_id' => 104],
                    ['id' => 305, 'project_id' => 202, 'bidder_id' => 105],
                ],
                'users'    => null,
                'projects' => null,
            ],
        ]);

        $session = $this->sessionWithResponses(
            new Response(200, ['Content-Type' => 'application/json'], $responseBody)
        );

        $projects = new Projects($session);
        $result   = $projects->getBids([
            'projects[]' => [101, 102],
            'limit'      => 20,
            'offset'     => 10,
        ]);

        $this->assertIsArray($result);
        $this->assertCount(5, $result);
        $this->assertInstanceOf(\FreelancerSdk\Types\Bid::class, $result[0]);
    }
}
