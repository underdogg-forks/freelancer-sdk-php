<?php

declare(strict_types=1);

namespace FreelancerSdk\Exceptions\Projects;

use FreelancerSdk\Exceptions\FreelancerException;

/**
 * Exception thrown when a review has not been posted.
 *
 * This exception indicates that an attempt to access or process a review
 * failed because the review was not successfully posted to the system.
 */
class ReviewNotPostedException extends FreelancerException
{
}
