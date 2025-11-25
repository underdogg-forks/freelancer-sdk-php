<?php

declare(strict_types=1);

namespace FreelancerSdk\Exceptions\Projects;

use FreelancerSdk\Exceptions\FreelancerException;

/**
 * Exception thrown when a bid fails to be placed on a project.
 *
 * @see \FreelancerSdk\Resources\Projects\Projects::placeBid()
 */
class BidNotPlacedException extends FreelancerException
{
}
