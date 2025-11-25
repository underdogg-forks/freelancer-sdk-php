# Freelancer PHP SDK Examples

This directory contains practical examples of using the Freelancer PHP SDK.

## Setup

1. Install dependencies:
```bash
composer install
```

2. Set your API credentials:
```bash
export FLN_OAUTH_TOKEN="your_oauth_token"
export FLN_URL="https://www.freelancer.com"  # Optional, defaults to production
```

## Running Examples

Each example file can be run independently:

```bash
php examples/create_project.php
php examples/get_users.php
php examples/search_projects.php
```

## Available Examples

### Projects
- `create_project.php` - Create a new fixed-price project
- `search_projects.php` - Search for projects
- `place_project_bid.php` - Place a bid on a project

### Users
- `get_users.php` - Get multiple users or a single user by ID
- `get_self.php` - Get authenticated user details
- `search_freelancers.php` - Search for freelancers

### Contests
- `create_contest.php` - Create a new contest

### Messages
- `create_message_project_thread.php` - Create a project thread
- `create_message.php` - Post a message to a thread

## Getting API Credentials

To use these examples, you need to obtain an OAuth2 token from Freelancer.com:

1. Create an application at https://developers.freelancer.com/
2. Follow the OAuth2 authentication flow
3. Use the obtained token in your environment variable

See the [Freelancer API Documentation](https://developers.freelancer.com/docs/authentication/creating-a-client) for more details.
