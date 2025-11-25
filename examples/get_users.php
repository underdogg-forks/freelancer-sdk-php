<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use FreelancerSdk\Resources\Users;
use FreelancerSdk\Session;

/**
 * Get multiple users
 */
/**
 * Create and return a configured Users client using environment configuration.
 *
 * @return Users The configured Users client.
 */
function createUsersClient(): Users
{
    $oauthToken = getenv('FLN_OAUTH_TOKEN') ?: null;
    $url = getenv('FLN_URL') ?: 'https://www.freelancer.com';
    $session = new Session($oauthToken, $url);
    return new Users($session);
}

/**
 * Retrieve multiple users by ID including basic profile, profile description, and reputation.
 *
 * @return array|null An associative array of users as returned by the SDK, or `null` if an error occurred.
 */
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
 * Retrieve the user with ID 110013 and return their data.
 *
 * @return array|null The user's data as an associative array, or null if the request failed.
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