<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use FreelancerSdk\Exceptions\Messages\ThreadNotCreatedException;
use FreelancerSdk\Resources\Messages\Messages;
use FreelancerSdk\Session;

/**
 * Create a project thread
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
