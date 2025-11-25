<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

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
use FreelancerSdk\Exceptions\Messages\ThreadNotCreatedException;

    } catch (ThreadNotCreatedException $e) {
        echo "Error message: {$e->getMessage()}\n";
        return null;
    }
    }
}

$thread = sampleCreateMessageProjectThread();
if ($thread) {
    echo "Thread created: thread_id={$thread->id}\n";
}
