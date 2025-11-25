<?php

declare(strict_types=1);

namespace FreelancerSdk\Exceptions\Projects;

use FreelancerSdk\Exceptions\FreelancerException;

/**
 * Exception thrown when bids are not found for a project.
 */
class BidsNotFoundException extends FreelancerException
{
    protected $message = 'Bids not found for the specified project';
}
