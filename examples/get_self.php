<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use FreelancerSdk\Resources\Users;
use FreelancerSdk\Session;

/**
 * Get self user details
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
