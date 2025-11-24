<?php

declare(strict_types=1);

namespace FreelancerSdk\Exceptions\Messages;

use FreelancerSdk\Exceptions\FreelancerException;

class ThreadNotCreatedException extends FreelancerException
{
}

class MessageNotCreatedException extends FreelancerException
{
}

class MessagesNotFoundException extends FreelancerException
{
}

class ThreadsNotFoundException extends FreelancerException
{
}
