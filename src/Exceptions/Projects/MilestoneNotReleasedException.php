<?php

declare(strict_types=1);

namespace FreelancerSdk\Exceptions\Projects;

use FreelancerSdk\Exceptions\FreelancerException;

/**
 * Exception thrown when a milestone cannot be released.
 *
 * This exception is typically thrown when attempting to release a milestone
 * that does not meet the required conditions or state for release.
 */
class MilestoneNotReleasedException extends FreelancerException
{
}
