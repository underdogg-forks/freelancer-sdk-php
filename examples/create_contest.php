<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use FreelancerSdk\Exceptions\Contests\ContestNotCreatedException;
use FreelancerSdk\Resources\Contests\Contests;
use FreelancerSdk\Session;

/**
 * Create a new contest
 */
function sampleCreateContest(): ?object
{
    $oauthToken = getenv('FLN_OAUTH_TOKEN') ?: null;
    $url = getenv('FLN_URL') ?: 'https://www.freelancer.com';

    $session = new Session($oauthToken, $url);
    $contests = new Contests($session);

    $contestData = [
        'title' => 'Design a logo',
        'description' => 'I need a logo for my company',
        'type' => 'freemium',
        'duration' => 7, // Days
        'job_ids' => [1, 2], // Graphic Design, Logo Design
        'currency_id' => 1, // USD
        'prize' => 100,
    ];

    try {
        $contest = $contests->createContest($contestData);
        return $contest;
    } catch (ContestNotCreatedException $e) {
        echo "Error message: {$e->getMessage()}\n";
        echo "Error code: {$e->getCode()}\n";
        return null;
    }
}

$contest = sampleCreateContest();
if ($contest) {
    if ($contest) {
        echo "Contest created: contest_id=" . ($contest->id ?? 'unknown') . "\n";
    }
}
