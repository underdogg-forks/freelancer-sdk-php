# Freelancer PHP SDK

Official PHP SDK for the Freelancer.com API, converted from the Python SDK.

## Installation

This package is designed to be used locally within a Laravel application via a Composer path repository.

### For Local Development (Path Repository)

Add the following to your project's `composer.json`:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "./packages/freelancer-sdk-php"
        }
    ],
    "require": {
        "freelancer/freelancer-sdk-php": "*"
    }
}
```

Then run:

```bash
composer install
```

### For Production (Packagist)

Once published to Packagist, you can install directly:

```bash
composer require freelancer/freelancer-sdk-php
```

## Usage

```php
use FreelancerSdk\Session;
use FreelancerSdk\Resources\Projects\Projects;

// Create a session with your OAuth token
$session = new Session('your-oauth-token');

// Use the SDK
$projects = new Projects($session);
$result = $projects->getProjects(['user_details' => true]);
```

## Authentication

Before using this SDK, you need to obtain an OAuth2 token from Freelancer.com.
See the [Freelancer.com Developer Portal](https://developers.freelancer.com/docs/authentication/creating-a-client) for more information.

## Features

- Projects management (create, read, update)
- Bids management
- Milestone payments
- User management
- Messaging
- Contests

## License

GNU LGPLv3
