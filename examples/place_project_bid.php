<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use FreelancerSdk\Exceptions\Projects\BidNotPlacedException;
use FreelancerSdk\Resources\Projects\Projects;
use FreelancerSdk\Session;

/**
 * Attempt to place a bid on a project using credentials from the environment.
 *
 * Reads FLN_OAUTH_TOKEN and FLN_URL from the environment, creates a session, and attempts
 * to place a bid for a placeholder project ID. Returns the created bid object on success
 * or `null` if the bid could not be placed.
 *
 * @return object|null The placed bid object on success, `null` if placement failed.
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
    } catch (BidNotPlacedException $e) {
        echo "Error placing bid: {$e->getMessage()}\n";
        return null;
    } catch (\Exception $e) {
        echo "Unexpected error: {$e->getMessage()}\n";
        return null;
    }
}

$bid = samplePlaceProjectBid();
if ($bid && isset($bid->id)) {
    echo "Bid placed successfully: bid_id={$bid->id}\n";
} elseif ($bid) {
    echo "Bid placed but no ID returned\n";
}