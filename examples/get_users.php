<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use FreelancerSdk\Resources\Users;
use FreelancerSdk\Session;

/**
 * Get multiple users
 */
/**
 * Create and return a configured Users client
 */
function createUsersClient(): Users
{
    $oauthToken = getenv('FLN_OAUTH_TOKEN') ?: null;
    $url = getenv('FLN_URL') ?: 'https://www.freelancer.com';
    $session = new Session($oauthToken, $url);
    return new Users($session);
}

function sampleGetUsers(): ?array
{
    $users = createUsersClient();

    $query = [
        'users[]' => [110013, 221202, 231203],
        'basic' => true,
        'profile_description' => true,
        'reputation' => true,
    ];

    try {
        $result = $users->getUsers($query);
        return $result;
    } catch (\RuntimeException $e) {
        echo "Error message: {$e->getMessage()}\n";
        return null;
    }
}

/**
 * Get a single user by ID
 */
function sampleGetUserById(): ?array
{
    $users = createUsersClient();

    try {
        $result = $users->getUserById(110013);
        return $result;
    } catch (\RuntimeException $e) {
        echo "Error message: {$e->getMessage()}\n";
        return null;
    }
}

echo "Getting a list of users...\n";
$usersResult = sampleGetUsers();
if ($usersResult) {
    echo "Users found!\n" . json_encode($usersResult, JSON_PRETTY_PRINT) . "\n";
}

echo "\nGetting just a single user...\n";
$userResult = sampleGetUserById();
if ($userResult) {
    echo "User found!\n" . json_encode($userResult, JSON_PRETTY_PRINT) . "\n";
}
