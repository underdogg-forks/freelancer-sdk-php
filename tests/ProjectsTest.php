<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests;

use FreelancerSdk\Exceptions\Projects\ProjectsNotFoundException;
use FreelancerSdk\Resources\Projects\Projects;
use FreelancerSdk\Types\Project;
use PHPUnit\Framework\Attributes\Test;

class ProjectsTest extends BaseTestCase
{
    #[Test]
    public function it_creates_a_project(): void
    {
        $session = $this->createMockSession(
            $this->createSuccessResponse([
                'title'   => 'My New Project',
                'seo_url' => 'java/foo',
            ])
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
        $session = $this->createMockSession(
            $this->createSuccessResponse([
                'total_count' => 3,
                'projects'    => [
                    ['id' => 201, 'title' => 'Phasellus blandit posuere enim'],
                    ['id' => 202, 'title' => 'Donec fringilla elit velit'],
                    ['id' => 203, 'title' => 'In hac habitasse platea dictumst'],
                ],
            ])
        );

        $projects = new Projects($session);
        $result   = $projects->getProjects(['projects[]' => [201, 202, 203]]);

        $this->assertIsArray($result);
        $this->assertCount(3, $result);
        $this->assertInstanceOf(Project::class, $result[0]);
        $this->assertSame('Phasellus blandit posuere enim', $result[0]->title);
    }

    #[Test]
    public function it_searches_projects(): void
    {
        $session = $this->createMockSession(
            $this->createSuccessResponse([
                'total_count' => 1000,
                'projects'    => [
                    ['id' => 201, 'title' => 'Phasellus blandit posuere enim'],
                    ['id' => 202, 'title' => 'Donec fringilla elit velit'],
                    ['id' => 203, 'title' => 'In hac habitasse platea dictumst'],
                ],
            ])
        );

        $projects = new Projects($session);
        $result   = $projects->searchProjects(['query' => 'logo design']);

        $this->assertIsArray($result);
        $this->assertCount(3, $result);
        $this->assertInstanceOf(Project::class, $result[0]);
    }

    #[Test]
    public function it_gets_a_project_by_id(): void
    {
        $session = $this->createMockSession(
            $this->createSuccessResponse([
                'id'     => 2,
                'title'  => 'Sample title',
                'tracks' => [1, 2],
            ])
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
        $session  = $this->createMockSession($this->createErrorResponse());
        $projects = new Projects($session);

        $this->expectException(ProjectsNotFoundException::class);
        $this->expectExceptionMessage('An error has occurred.');

        $projects->getProject(2);
    }

    #[Test]
    public function it_places_a_bid(): void
    {
        $session = $this->createMockSession(
            $this->createSuccessResponse([
                'id'          => 39343812,
                'bidder_id'   => 2,
                'description' => 'A bid',
                'amount'      => 10,
            ])
        );

        $projects = new Projects($session);
        $bid      = $projects->placeBid(1, [
            'bidder_id'            => 2,
            'amount'               => 10,
            'period'               => 2,
            'milestone_percentage' => 100,
            'description'          => 'A bid',
        ]);

        $this->assertSame(39343812, $bid->id);
        $this->assertSame(2, $bid->bidder_id);
        $this->assertSame('A bid', $bid->description);
        $this->assertEquals(10, $bid->amount);
    }

    #[Test]
    public function it_gets_bids(): void
    {
        $session = $this->createMockSession(
            $this->createSuccessResponse([
                'bids' => [
                    ['id' => 301, 'project_id' => 201, 'bidder_id' => 101],
                    ['id' => 302, 'project_id' => 201, 'bidder_id' => 102],
                    ['id' => 303, 'project_id' => 201, 'bidder_id' => 103],
                    ['id' => 304, 'project_id' => 202, 'bidder_id' => 104],
                    ['id' => 305, 'project_id' => 202, 'bidder_id' => 105],
                ],
            ])
        );

        $projects = new Projects($session);
        $result   = $projects->getBids(['projects[]' => [101, 102]]);

        $this->assertIsArray($result);
        $this->assertCount(5, $result);
        $this->assertInstanceOf(\FreelancerSdk\Types\Bid::class, $result[0]);
    }
}
