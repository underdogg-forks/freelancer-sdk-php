<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests;

use FreelancerSdk\Resources\Projects\Projects;
use FreelancerSdk\Session;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
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

    public function testCreateProject(): void
    {
        $session = $this->sessionWithResponses(
            new Response(200, ['Content-Type' => 'application/json'], $this->fixture('projects_create_success.json'))
        );

        $projects = new Projects($session);
        $project = $projects->createProject([
            'title' => 'Test Project',
        ]);

        $this->assertSame(123, $project->id);
        $this->assertSame('https://example.com/projects/test-project-123', $project->url);
    }

    public function testGetProjects(): void
    {
        $session = $this->sessionWithResponses(
            new Response(200, ['Content-Type' => 'application/json'], $this->fixture('projects_list_success.json'))
        );

        $projectsApi = new Projects($session);
        $projects = $projectsApi->getProjects();
        $this->assertCount(2, $projects);
        $this->assertSame('Test Project A', $projects[0]->title);
    }

    public function testSearchProjects(): void
    {
        $session = $this->sessionWithResponses(
            new Response(200, ['Content-Type' => 'application/json'], $this->fixture('projects_active_success.json'))
        );
        $projectsApi = new Projects($session);
        $projects = $projectsApi->searchProjects();
        $this->assertCount(1, $projects);
        $this->assertSame(125, $projects[0]->id);
    }

    public function testGetProject(): void
    {
        $session = $this->sessionWithResponses(
            new Response(200, ['Content-Type' => 'application/json'], $this->fixture('project_get_success.json'))
        );
        $projectsApi = new Projects($session);
        $project = $projectsApi->getProject(123);
        $this->assertSame(123, $project->id);
        $this->assertSame('Test Project', $project->title);
    }
}
