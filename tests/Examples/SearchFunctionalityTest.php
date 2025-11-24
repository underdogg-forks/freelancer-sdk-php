<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests\Examples;

use FreelancerSdk\Resources\Projects\Projects;
use FreelancerSdk\Resources\Users;
use FreelancerSdk\Tests\BaseTestCase;
use FreelancerSdk\Types\Project;
use PHPUnit\Framework\Attributes\Test;

/**
 * Comprehensive tests for search functionality
 */
class SearchFunctionalityTest extends BaseTestCase
{
    #[Test]
    public function it_searches_projects_with_query(): void
    {
        $session = $this->createMockSession(
            $this->loadFixtureAsResponse('projects_search_success.json')
        );

        $projects = new Projects($session);
        $result   = $projects->searchProjects([
            'query'  => 'php development',
            'limit'  => 10,
            'offset' => 0,
        ]);

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertInstanceOf(Project::class, $result[0]);
        $this->assertStringContainsString('PHP', $result[0]->title);
    }

    #[Test]
    public function it_searches_projects_with_multiple_results(): void
    {
        $session = $this->createMockSession(
            $this->loadFixtureAsResponse('projects_search_success.json')
        );

        $projects = new Projects($session);
        $result   = $projects->searchProjects([
            'query' => 'development',
        ]);

        $this->assertIsArray($result);
        $this->assertGreaterThan(1, count($result), 'Should return multiple projects');

        foreach ($result as $project) {
            $this->assertInstanceOf(Project::class, $project);
            $this->assertNotEmpty($project->title);
            $this->assertNotEmpty($project->id);
        }
    }

    #[Test]
    public function it_searches_projects_validates_project_fields(): void
    {
        $session = $this->createMockSession(
            $this->loadFixtureAsResponse('projects_search_success.json')
        );

        $projects = new Projects($session);
        $result   = $projects->searchProjects(['query' => 'logo']);

        $this->assertIsArray($result);
        $firstProject = $result[0];

        // Validate required fields exist
        $this->assertNotNull($firstProject->id);
        $this->assertNotNull($firstProject->title);
        $this->assertNotNull($firstProject->description);
    }

    #[Test]
    public function it_searches_freelancers_with_query(): void
    {
        $session = $this->createMockSession(
            $this->createSuccessResponse([
                'users' => [
                    '100' => [
                        'id'       => 100,
                        'username' => 'php_expert',
                        'status'   => 'active',
                    ],
                    '101' => [
                        'id'       => 101,
                        'username' => 'developer_pro',
                        'status'   => 'active',
                    ],
                ],
            ])
        );

        $users  = new Users($session);
        $result = $users->searchFreelancers([
            'query'   => 'php developer',
            'limit'   => 10,
            'offset'  => 0,
            'compact' => true,
        ]);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('users', $result);
        $this->assertNotEmpty($result['users']);
    }

    #[Test]
    public function it_searches_freelancers_validates_user_fields(): void
    {
        $session = $this->createMockSession(
            $this->createSuccessResponse([
                'users' => [
                    '100' => [
                        'id'       => 100,
                        'username' => 'freelancer1',
                        'status'   => 'active',
                    ],
                ],
            ])
        );

        $users  = new Users($session);
        $result = $users->searchFreelancers(['query' => 'designer']);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('users', $result);

        foreach ($result['users'] as $user) {
            $this->assertArrayHasKey('id', $user);
            $this->assertArrayHasKey('username', $user);
        }
    }

    #[Test]
    public function it_searches_projects_with_pagination(): void
    {
        $session = $this->createMockSession(
            $this->loadFixtureAsResponse('projects_search_success.json')
        );

        $projects = new Projects($session);
        $result   = $projects->searchProjects([
            'query'  => 'php',
            'limit'  => 5,
            'offset' => 10,
        ]);

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }
}
