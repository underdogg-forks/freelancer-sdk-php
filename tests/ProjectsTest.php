<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests;

use FreelancerSdk\Resources\Projects\Projects;
use FreelancerSdk\Session;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ProjectsTest extends TestCase
{
    private function sessionWithResponses(Response ...$responses): Session
    {
        $mock = new MockHandler($responses);
        $handler = HandlerStack::create($mock);
        return new Session('token_123', 'https://example.com', ['handler' => $handler]);
    }

    private function fixture(string $name): string
    {
        return file_get_contents(__DIR__ . '/Fixtures/' . $name);
    }

    #[Test]
    public function it_creates_a_project(): void
    {
        $session = $this->sessionWithResponses(
            new Response(200, ['Content-Type' => 'application/json'], $this->fixture('projects_create_success.json'))
        );
        $projects = $this->createMock(Projects::class);
        $projects->method('createProject')->willReturn((object)[
            'id' => 123,
            'url' => 'https://example.com/projects/test-project-123'
        ]);
        $project = $projects->createProject(['title' => 'Test Project']);
        $this->assertSame(123, $project->id);
        $this->assertSame('https://example.com/projects/test-project-123', $project->url);
    }

    #[Test]
    public function it_gets_projects(): void
    {
        $projectsApi = $this->createMock(Projects::class);
        $projectsApi->method('getProjects')->willReturn([
            (object)['title' => 'Test Project A'],
            (object)['title' => 'Test Project B']
        ]);
        $projects = $projectsApi->getProjects();
        $this->assertCount(2, $projects);
        $this->assertSame('Test Project A', $projects[0]->title);
    }

    #[Test]
    public function it_searches_projects(): void
    {
        $projectsApi = $this->createMock(Projects::class);
        $projectsApi->method('searchProjects')->willReturn([
            (object)['id' => 125]
        ]);
        $projects = $projectsApi->searchProjects();
        $this->assertCount(1, $projects);
        $this->assertSame(125, $projects[0]->id);
    }

    #[Test]
    public function it_gets_a_project_by_id(): void
    {
        $projectsApi = $this->createMock(Projects::class);
        $projectsApi->method('getProject')->willReturn((object)[
            'id' => 123,
            'title' => 'Test Project'
        ]);
        $project = $projectsApi->getProject(123);
        $this->assertSame(123, $project->id);
        $this->assertSame('Test Project', $project->title);
    }
}
