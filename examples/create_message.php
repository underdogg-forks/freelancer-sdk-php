<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use FreelancerSdk\Resources\Messages\Messages;
use FreelancerSdk\Session;

/**
 * Create and post a message to a predefined thread using environment-configured session.
 *
 * @return object|null The created message object if successful, `null` if the message could not be created.
 */
function sampleCreateMessage(): ?object
{
    $oauthToken = getenv('FLN_OAUTH_TOKEN') ?: null;
    $url = getenv('FLN_URL') ?: 'https://www.freelancer.com';

    $session = new Session($oauthToken, $url);
    $messages = new Messages($session);

    $threadId = 301; // Thread ID
    $messageText = "Hello, how is the project progressing?";

    try {
        $message = $messages->postMessage($threadId, $messageText);
        return $message;
    } catch (\FreelancerSdk\Exceptions\Messages\MessageNotCreatedException $e) {
        echo "Error message: {$e->getMessage()}\n";
        return null;
    }
}

$message = sampleCreateMessage();
if ($message) {
 if ($message) {
    echo "Message posted: message_id=" . ($message->id ?? 'unknown') . "\n";
 }
}