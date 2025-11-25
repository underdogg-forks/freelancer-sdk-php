<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use FreelancerSdk\Resources\Projects\Projects;
use FreelancerSdk\Session;

/**
 * Searches Freelancer projects using a session configured from environment variables.
 *
 * Performs a search for "php development" (limit 10, offset 0, jobs only) using a Session
 * constructed from FLN_OAUTH_TOKEN (nullable) and FLN_URL (defaults to https://www.freelancer.com).
 * On error, prints the exception message and returns null.
 *
 * @return array|null Array of project result data when successful, `null` if an exception occurred.
 */
function sampleSearchProjects(): ?array
{
    $oauthToken = getenv('FLN_OAUTH_TOKEN') ?: null;
    $url = getenv('FLN_URL') ?: 'https://www.freelancer.com';

    $session = new Session($oauthToken, $url);
    $projects = new Projects($session);

    $searchParams = [
        'query' => 'php development',
        'limit' => 10,
        'offset' => 0,
        'jobs' => true,
    ];

    try {
        $results = $projects->searchProjects($searchParams);
        return $results;
    } catch (\Exception $e) {
        echo "Error message: {$e->getMessage()}\n";
        return null;
    }
}

$results = sampleSearchProjects();
if ($results) {
    echo "Found " . count($results) . " projects\n";
    foreach ($results as $project) {
        echo "- {$project->title} (ID: {$project->id})\n";
    }
}