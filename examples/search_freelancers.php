<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use FreelancerSdk\Resources\Users;
use FreelancerSdk\Session;

/**
 * Searches freelancers with a sample set of parameters using a Session created from environment variables.
 *
 * Uses FLN_OAUTH_TOKEN and FLN_URL to initialize the session and returns the API response.
 *
 * @return array|null The search result as an associative array (includes a 'users' key on success), or `null` if an error occurred.
 */
function sampleSearchFreelancers(): ?array
{
    $oauthToken = getenv('FLN_OAUTH_TOKEN') ?: null;
    $url = getenv('FLN_URL') ?: 'https://www.freelancer.com';

    $session = new Session($oauthToken, $url);
    $users = new Users($session);

    $searchParams = [
        'query' => 'php developer',
        'limit' => 10,
        'offset' => 0,
        'compact' => true,
        'country' => true,
        'status' => true,
    ];

    try {
        $result = $users->searchFreelancers($searchParams);
        return $result;
    } catch (\Exception $e) {
        echo "Error message: {$e->getMessage()}\n";
        return null;
    }
}

$results = sampleSearchFreelancers();
if ($results && isset($results['users'])) {
    echo "Found freelancers!\n";
    echo json_encode($results, JSON_PRETTY_PRINT) . "\n";
}