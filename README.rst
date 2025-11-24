# Freelancer SDK - Laravel Filament Implementation

This repository contains both the original Python Freelancer SDK and a complete Laravel 12 application with a PHP conversion of the SDK.

## What's Included

### 1. Original Python SDK
The original Freelancer.com Python SDK (files in root directory)

### 2. Laravel 12 Application (`laravel-app/`)
A complete Laravel application with:
- **Laravel 12** - Latest PHP framework
- **Filament v4** - Admin panel framework (structure ready)
- **TailwindCSS v4** - Modern CSS framework
- **Freelancer PHP SDK** - Converted from Python

### 3. Freelancer PHP SDK (`packages/freelancer-sdk-php/`)
A PHP conversion of the Python SDK with:
- Session management
- Projects resource (create, read, search)
- Bids resource (place, retrieve)
- Exception handling
- Helper functions

## Quick Start

### For Laravel Application

```bash
cd laravel-app
composer install
npm install
cp .env.example .env
php artisan key:generate

# Add your Freelancer OAuth token to .env
# FREELANCER_OAUTH_TOKEN=your_token_here

npm run build
php artisan serve
```

Visit http://localhost:8000

### For Python SDK

```bash
pip install freelancersdk
# or
pip install -e .
```

## Project Structure

```
.
├── README.rst                 # Original Python SDK README
├── freelancersdk/            # Python SDK source
├── examples/                 # Python examples
├── laravel-app/              # Laravel 12 application
│   ├── app/
│   ├── config/
│   ├── resources/
│   └── routes/
└── packages/
    └── freelancer-sdk-php/   # PHP SDK (symlinked into Laravel)
        ├── src/
        │   ├── Session.php
        │   ├── Exceptions/
        │   └── Resources/
        └── composer.json
```

## Documentation

- [Laravel Application README](laravel-app/README.md) - Complete Laravel setup guide
- [PHP SDK README](packages/freelancer-sdk-php/README.md) - PHP SDK usage
- [Python SDK README](README.rst) - Original Python SDK documentation
- [Freelancer API Docs](https://developers.freelancer.com) - Official API documentation

## Features

### Laravel Application Features
- Dashboard with Freelancer API integration
- RESTful API endpoints for projects and bids
- TailwindCSS v4 styled interface
- Configuration management
- Service provider for dependency injection

### PHP SDK Features
- OAuth 2.0 authentication
- Projects management (create, list, search)
- Bids management (place, retrieve)
- Exception handling
- Helper functions for data objects
- PSR-4 autoloading
- Guzzle HTTP client

## API Endpoints

The Laravel application provides these endpoints:

- `GET /freelancer/projects` - List projects
- `GET /freelancer/projects/search` - Search projects
- `POST /freelancer/projects` - Create project
- `GET /freelancer/bids` - List bids
- `POST /freelancer/projects/{id}/bids` - Place bid

## Authentication

You need a Freelancer.com OAuth token:

1. Visit https://developers.freelancer.com/docs/authentication/creating-a-client
2. Create an application
3. Generate an OAuth token
4. Add to `.env` file:
   ```
   FREELANCER_OAUTH_TOKEN=your_token_here
   ```

## Development

### Adding Features

The architecture supports easy extension:
- Add new resources in `packages/freelancer-sdk-php/src/Resources/`
- Add controllers in `laravel-app/app/Http/Controllers/`
- Add routes in `laravel-app/routes/web.php`
- Add views in `laravel-app/resources/views/`

### Testing

```bash
# Laravel tests
cd laravel-app
php artisan test

# PHP SDK tests (when implemented)
cd packages/freelancer-sdk-php
vendor/bin/phpunit

# Python SDK tests
pytest
```

## License

GNU LGPLv3

## Contributing

Contributions welcome! Areas for improvement:
- Complete remaining SDK resources (Users, Messages, Contests)
- Add comprehensive tests
- Enhance Filament admin interface
- Add more API endpoints
- Improve error handling
- Add caching layer

## Support

- [Freelancer API Support](api-support@freelancer.com)
- [Freelancer Developer Portal](https://developers.freelancer.com)


Install
~~~~~~~

Install it using ``pip install freelancersdk``. It may be a good idea to
use `virtualenv <https://virtualenv.readthedocs.org/en/latest/>`__ as
part of your workflow.

Versioning
----------

The current version `series` of the library is ``0.1.x`` which corresponds to the
``0.1`` version of the API. The revision number ``x`` corresponds to the
revision of the SDK. The ``0.1`` series of the library will continue to
support (in a backward compatible way) the ``0.1`` version of the
Freelancer.com API.

Usage
~~~~~

The first step to using any SDK function is to create a `Session` object:

::

    >>> from freelancersdk.session import Session
    >>> session = Session(oauth_token=token)

You must have a valid OAuth2 token before you can use the SDK or the
API. See the `Freelancer.com Developer
portal <https://developers.freelancer.com>`__ for more information on
how you can do so.

Once we have a session object, we can start using the SDK functions.

Examples
~~~~~~~~

All the examples below recognizes two environment variables:

-  ``FLN_OAUTH_TOKEN``: The OAuth2 token to create the session with and
   must be specified
-  ``FLN_URL``: If you want to use the library to make requests against
   the `Freelancer.com
   Sandbox <https://developers.freelaner.com/docs/api-overview/sandbox-environment>`__,
   you can specifiy ``FLN_URL=https://www.freelancer-sandbox.com``. If
   not specified, it defaults to ``https://www.freelancer.com``.

**Projects**

-  `Create a Fixed Project <examples/create_project.py>`__
-  `Create a Hourly Project <examples/create_hourly_project.py>`__
-  `Create a Local Project <examples/create_local_project.py>`__
-  `Create a Hireme Project <examples/create_hireme_project.py>`__
-  `Create a Freelancer Review <examples/create_freelancer_review.py>`__
-  `Create a Employer Review <examples/create_employer_review.py>`__
-  `Search for Projects <examples/search_projects.py>`__
-  `Retrieve Project details <examples/get_projects.py>`__
-  `Get a list of jobs (skills) <examples/get_jobs.py>`__
-  `Track a freelancer's location for a project <examples/create_track.py>`__
-  `Update a track's location <examples/update_track.py>`__
-  `Retrieve a track by ID <examples/get_specific_track.py>`__
-  `Retrieve a single project's details <examples/get_projects.py>`__

**Bids**

-  `Create a Bid <examples/place_project_bid.py>`__
-  `Award a Bid <examples/award_project_bid.py>`__
-  `Accept a bid <examples/accept_project_bid.py>`__
-  `Revoke a Bid <examples/revoke_project_bid.py>`__
-  `Retract a Bid <examples/retract_project_bid.py>`__
-  `Highlight a Bid <examples/highlight_project_bid.py>`__
-  `Retrieve project bids <examples/get_bids.py>`__

**Milestone Payments**

-  `Create a Milestone payment <examples/create_milestone_payment.py>`__
-  `Create a Milestone payment
   request <examples/create_milestone_request.py>`__
-  `Accept a Milestone payment
   request <examples/accept_milestone_request.py>`__
-  `Reject a Milestone payment
   request <examples/reject_milestone_request.py>`__
-  `Delete a Milestone payment
   request <examples/delete_milestone_request.py>`__
-  `Release Milestone payment
   request <examples/release_milestone_payment.py>`__
-  `Cancel Milestone payment
   request <examples/cancel_milestone_payment.py>`__
-  `Request a Milestone payment
   release <examples/request_release_milestone_payment.py>`__
-  `Retrieve project milestones <examples/get_milestones.py>`__
-  `Retrieve a milestone by ID <examples/get_specific_milestone.py>`__

**Messaging**

-  `Create a new thread in the context of a
   project <examples/create_message_project_thread.py>`__
-  `Create a new message in an existing
   thread <examples/create_message.py>`__
-  `Upload an attachment in an exising
   thread <examples/create_message_with_attachment.py>`__
-  `Retrieve messages <examples/get_messages.py>`__
-  `Retrieve threads <examples/get_threads.py>`__
-  `Search for messages <examples/search_messages.py>`__

**Contests**

-  `Create a contest <examples/create_contest.py>`__

**Users**

-  `Add a job to a user's list of jobs <examples/add_user_jobs.py>`__
-  `Delete a job from a user's jobs <examples/delete_user_jobs.py>`__
-  `Set a user's list of jobs <examples/set_user_jobs.py>`__
-  `Retrieve user details <examples/get_users.py>`__
-  `Retrieve a single user's details <examples/get_users.py>`__
-  `Search for freelancers <examples/search_freelancers.py>`__
-  `Retrieve the current user's details <examples/get_self.py>`__
-  `Retrieve user reputations <examples/get_reputations.py>`__
-  `Retrieve user portfolios <examples/get_portfolios.py>`__
License
~~~~~~~

GNU LGPLv3. Please see `LICENSE <LICENSE>`__ and
`COPYING.LESSER <COPYING.LESSER>`__.

Please note that 0.1.3 release changed the LICENSE from BSD to GNU
LGPLv3. If you were using the library prior to this release, please file
a issue to let us know if the change affects you in any way.
