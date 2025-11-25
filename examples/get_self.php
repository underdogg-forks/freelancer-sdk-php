<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use FreelancerSdk\Resources\Users;
use FreelancerSdk\Session;

/**
 * Retrieve details for the currently authenticated user.
 *
 * Reads the OAuth token from the `FLN_OAUTH_TOKEN` environment variable and the base URL
 * from `FLN_URL` (defaults to `https://www.freelancer.com`) before requesting the user's details.
 *
 * @return array|null The user details array on success, `null` if an error occurred.
 */
function sampleGetSelf(): ?array
{
    $oauthToken = getenv('FLN_OAUTH_TOKEN') ?: null;
    $url = getenv('FLN_URL') ?: 'https://www.freelancer.com';

    $session = new Session($oauthToken, $url);
    $users = new Users($session);

    $userDetails = [
        'country' => true,
        'status' => true,
        'profile_description' => true,
    ];

    try {
        $result = $users->getSelf($userDetails);
        return $result;
    } catch (\RuntimeException $e) {
        echo "Error message: {$e->getMessage()}\n";
        return null;
    }
}

$self = sampleGetSelf();
if ($self) {
    echo "Self user retrieved!\n";
    echo json_encode($self, JSON_PRETTY_PRINT) . "\n";
}