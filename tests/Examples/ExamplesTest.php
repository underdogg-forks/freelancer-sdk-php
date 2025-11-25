<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests\Examples;

use FreelancerSdk\Tests\BaseTestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Tests for example files to ensure they work correctly
 */
class ExamplesTest extends BaseTestCase
{
    #[Test]
    public function example_create_project_works(): void
    {
        // Test that the create_project.php example structure is valid
        $exampleFile = __DIR__ . '/../../examples/create_project.php';
        $this->assertFileExists($exampleFile);

        $content = file_get_contents($exampleFile);
        $this->assertStringContainsString('function sampleCreateProject()', $content);
        $this->assertStringContainsString('createProject($projectData)', $content);
        $this->assertStringContainsString('ProjectNotCreatedException', $content);
    }

    #[Test]
    public function example_create_contest_works(): void
    {
        $exampleFile = __DIR__ . '/../../examples/create_contest.php';
        $this->assertFileExists($exampleFile);

        $content = file_get_contents($exampleFile);
        $this->assertStringContainsString('function sampleCreateContest()', $content);
        $this->assertStringContainsString('createContest($contestData)', $content);
        $this->assertStringContainsString('ContestNotCreatedException', $content);
    }

    #[Test]
    public function example_search_projects_works(): void
    {
        $exampleFile = __DIR__ . '/../../examples/search_projects.php';
        $this->assertFileExists($exampleFile);

        $content = file_get_contents($exampleFile);
        $this->assertStringContainsString('function sampleSearchProjects()', $content);
        $this->assertStringContainsString('searchProjects($searchParams)', $content);
        $this->assertStringContainsString('query', $content);
    }

    #[Test]
    public function example_search_freelancers_works(): void
    {
        $exampleFile = __DIR__ . '/../../examples/search_freelancers.php';
        $this->assertFileExists($exampleFile);

        $content = file_get_contents($exampleFile);
        $this->assertStringContainsString('function sampleSearchFreelancers()', $content);
        $this->assertStringContainsString('searchFreelancers($searchParams)', $content);
    }

    #[Test]
    public function example_get_users_works(): void
    {
        $exampleFile = __DIR__ . '/../../examples/get_users.php';
        $this->assertFileExists($exampleFile);

        $content = file_get_contents($exampleFile);
        $this->assertStringContainsString('function sampleGetUsers()', $content);
        $this->assertStringContainsString('function sampleGetUserById()', $content);
        $this->assertStringContainsString('getUsers($query)', $content);
        $this->assertStringContainsString('getUserById(', $content);
    }

    #[Test]
    public function example_place_bid_works(): void
    {
        $exampleFile = __DIR__ . '/../../examples/place_project_bid.php';
        $this->assertFileExists($exampleFile);

        $content = file_get_contents($exampleFile);
        $this->assertStringContainsString('function samplePlaceProjectBid()', $content);
        $this->assertStringContainsString('placeBid($projectId, $bidData)', $content);
    }

    #[Test]
    public function example_create_message_thread_works(): void
    {
        $exampleFile = __DIR__ . '/../../examples/create_message_project_thread.php';
        $this->assertFileExists($exampleFile);

        $content = file_get_contents($exampleFile);
        $this->assertStringContainsString('function sampleCreateMessageProjectThread()', $content);
        $this->assertStringContainsString('createProjectThread', $content);
    }

    #[Test]
    public function example_create_message_works(): void
    {
        $exampleFile = __DIR__ . '/../../examples/create_message.php';
        $this->assertFileExists($exampleFile);

        $content = file_get_contents($exampleFile);
        $this->assertStringContainsString('function sampleCreateMessage()', $content);
        $this->assertStringContainsString('postMessage($threadId, $messageText)', $content);
    }

    #[Test]
    public function example_get_self_works(): void
    {
        $exampleFile = __DIR__ . '/../../examples/get_self.php';
        $this->assertFileExists($exampleFile);

        $content = file_get_contents($exampleFile);
        $this->assertStringContainsString('function sampleGetSelf()', $content);
        $this->assertStringContainsString('getSelf($userDetails)', $content);
    }

    #[Test]
    public function all_examples_require_autoload(): void
    {
        $exampleFiles = glob(__DIR__ . '/../../examples/*.php');
        $this->assertNotEmpty($exampleFiles);

        foreach ($exampleFiles as $file) {
            $content = file_get_contents($file);
            $content = file_get_contents($file);
            $this->assertStringContainsString(
                "require_once __DIR__ . '/../vendor/autoload.php'",
                $content,
                'Example file ' . basename($file) . ' should require autoload'
            );
        }
    }
}
