<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use FreelancerSdk\Resources\Projects\Projects;
use FreelancerSdk\Session;

/**
 * Place a bid on a project
 */
function samplePlaceProjectBid(): ?object
{
    $oauthToken = getenv('FLN_OAUTH_TOKEN') ?: null;
    $url = getenv('FLN_URL') ?: 'https://www.freelancer.com';

    $session = new Session($oauthToken, $url);
    $projects = new Projects($session);

    $projectId = 12345; // Replace with actual project ID
    $bidData = [
        'bidder_id' => 2,
        'amount' => 100,
        'period' => 7, // Days
        'milestone_percentage' => 50,
        'description' => 'I am confident I can complete this project',
    ];

    try {
        $bid = $projects->placeBid($projectId, $bidData);
        return $bid;
    } catch (\Exception $e) {
        echo "Error message: {$e->getMessage()}\n";
        return null;
    }
}

$bid = samplePlaceProjectBid();
if ($bid) {
    echo "Bid placed successfully: bid_id={$bid->id}\n";
}
