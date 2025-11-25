<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use FreelancerSdk\Exceptions\Messages\ThreadNotCreatedException;
use FreelancerSdk\Resources\Messages\Messages;
use FreelancerSdk\Session;

/**
 * Creates a project messaging thread that includes specified project members.
 *
 * The function reads FLN_OAUTH_TOKEN for the OAuth token and FLN_URL for the API base URL
 * (defaults to https://www.freelancer.com), initializes a Session and Messages client,
 * and attempts to create a project thread with predefined member IDs, project ID, and message.
 *
 * @return object|null The created thread object on success, `null` on error.
 */
function sampleCreateMessageProjectThread(): ?object
{
    $oauthToken = getenv('FLN_OAUTH_TOKEN') ?: null;
    $url = getenv('FLN_URL') ?: 'https://www.freelancer.com';

    $session = new Session($oauthToken, $url);
    $messages = new Messages($session);

    $memberIds = [102]; // User IDs to include in thread
    $projectId = 201; // Project ID
    $message = "Let's discuss the project details";

    try {
        $thread = $messages->createProjectThread($memberIds, $projectId, $message);
        return $thread;
    } catch (ThreadNotCreatedException $e) {
        echo "Error creating thread: {$e->getMessage()}\n";
        return null;
    } catch (\Exception $e) {
        echo "Unexpected error: {$e->getMessage()}\n";
        return null;
    }
}

$thread = sampleCreateMessageProjectThread();
if ($thread && isset($thread->id)) {
    echo "Thread created: thread_id={$thread->id}\n";
} elseif ($thread) {
    echo "Thread created but no ID returned\n";
}