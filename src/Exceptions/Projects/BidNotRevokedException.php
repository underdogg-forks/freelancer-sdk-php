<?php

declare(strict_types=1);

namespace FreelancerSdk\Exceptions\Projects;

use FreelancerSdk\Exceptions\FreelancerException;

/**
 * Exception thrown when a bid cannot be revoked
 *
 * Reserved for public API compatibility. This exception is intentionally kept
 * for potential future use when bid revocation functionality is implemented.
 */
final class BidNotRevokedException extends FreelancerException
{
}
