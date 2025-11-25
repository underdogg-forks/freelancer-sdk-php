<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use FreelancerSdk\Exceptions\Projects\ProjectNotCreatedException;
use FreelancerSdk\Resources\Projects\Projects;
use FreelancerSdk\Session;

/**
 * Creates a new Freelancer project using an OAuth session and returns the created project.
 *
 * @see https://www.freelancer.com/api/docs/cases/creating_a_project
 * @return object|null The created project object on success, `null` if project creation failed.
 */
function sampleCreateProject(): ?object
{
    $oauthToken = getenv('FLN_OAUTH_TOKEN') ?: null;
    $url = getenv('FLN_URL') ?: 'https://www.freelancer.com';

    $session = new Session($oauthToken, $url);
    $projects = new Projects($session);

    $projectData = [
        'title' => 'My new project',
        'description' => 'This is a test project description',
        'currency' => ['id' => 1], // USD
        'budget' => ['minimum' => 10, 'maximum' => 50],
        'jobs' => [['id' => 7]], // PHP job
    ];

    try {
        $project = $projects->createProject($projectData);
        return $project;
    } catch (ProjectNotCreatedException $e) {
        echo "Error message: {$e->getMessage()}\n";
        echo "Error code: {$e->getCode()}\n";
        return null;
    }
}

$project = sampleCreateProject();
if ($project) {
    echo "Project created: {$project->url}\n";
}