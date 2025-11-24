# Freelancer Laravel Filament Application

A complete Laravel 12 application with Filament v4 and TailwindCSS v4 that integrates with the Freelancer.com API.

## Overview

This project consists of:
1. **Laravel 12 Application** - Modern PHP framework
2. **Freelancer PHP SDK** - A PHP conversion of the Python Freelancer SDK
3. **Filament v4** - Admin panel framework
4. **TailwindCSS v4** - Modern CSS framework

## Directory Structure

```
freelancer-sdk-php/
├── laravel-app/              # Main Laravel application
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   └── FreelancerController.php
│   │   └── Providers/
│   │       └── FreelancerServiceProvider.php
│   ├── config/
│   │   └── freelancer.php    # Freelancer API configuration
│   ├── resources/
│   │   └── views/
│   │       └── freelancer/
│   │           └── dashboard.blade.php
│   └── routes/
│       └── web.php
├── packages/
│   └── freelancer-sdk-php/   # Local PHP SDK package
│       ├── src/
│       │   ├── Session.php
│       │   ├── Exceptions/
│       │   └── Resources/
│       │       └── Projects/
│       └── composer.json
└── (Python SDK files)        # Original Python SDK
```

## Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and NPM
- Freelancer.com OAuth Token (get from https://developers.freelancer.com)

### Setup Steps

1. **Install PHP Dependencies**
   ```bash
   cd laravel-app
   composer install
   ```

2. **Install Node Dependencies**
   ```bash
   npm install
   ```

3. **Configure Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Freelancer API**
   
   Edit `.env` and add your Freelancer OAuth token:
   ```
   FREELANCER_OAUTH_TOKEN=your_oauth_token_here
   FREELANCER_API_URL=https://www.freelancer.com
   FREELANCER_USE_SANDBOX=false
   ```

5. **Setup Database**
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

6. **Build Assets**
   ```bash
   npm run build
   ```

7. **Start Development Server**
   ```bash
   php artisan serve
   ```

   Visit http://localhost:8000

## Freelancer PHP SDK

The PHP SDK is located in `packages/freelancer-sdk-php` and is symlinked into the Laravel application via Composer's `path` repository type.

### SDK Usage

#### Basic Usage

```php
use FreelancerSdk\Session;
use FreelancerSdk\Resources\Projects\Projects;

// Create session
$session = new Session('your-oauth-token');

// Use Projects resource
$projects = new Projects($session);

// Get projects
$projectList = $projects->getProjects([
    'projects[]' => [123, 456],
]);

// Create a project
$newProject = $projects->createProject([
    'title' => 'My Project',
    'description' => 'Project description',
    'currency' => ['id' => 1],
    'budget' => ['minimum' => 100, 'maximum' => 500],
    'jobs' => [['id' => 7]],
]);

// Place a bid
$bid = $projects->placeBid(123, [
    'amount' => 100,
    'period' => 7,
    'description' => 'I can do this project',
]);
```

#### Using Helpers

```php
use FreelancerSdk\Resources\Projects\Helpers;

$currency = Helpers::createCurrencyObject(1, 'USD', '$', 'US Dollar');
$budget = Helpers::createBudgetObject(100, 500);
$job = Helpers::createJobObject(7, 'PHP');
```

### Available Resources

- **Projects** - Create, read, search projects
- **Bids** - Place and manage bids
- **Milestones** - Payment milestones (structure ready)
- **Users** - User management (structure ready)
- **Messages** - Messaging (structure ready)
- **Contests** - Contest management (structure ready)

## API Endpoints

The Laravel application exposes the following endpoints:

### Projects

- `GET /freelancer/projects` - List all projects
  ```bash
  curl http://localhost:8000/freelancer/projects
  ```

- `GET /freelancer/projects/search` - Search for projects
  ```bash
  curl http://localhost:8000/freelancer/projects/search?query=php
  ```

- `POST /freelancer/projects` - Create a new project
  ```bash
  curl -X POST http://localhost:8000/freelancer/projects \
    -H "Content-Type: application/json" \
    -d '{
      "title": "My Project",
      "description": "Description",
      "currency": {"id": 1},
      "budget": {"minimum": 100},
      "jobs": [{"id": 7}]
    }'
  ```

### Bids

- `GET /freelancer/bids` - List all bids
  ```bash
  curl http://localhost:8000/freelancer/bids?project_ids[]=123
  ```

- `POST /freelancer/projects/{id}/bids` - Place a bid
  ```bash
  curl -X POST http://localhost:8000/freelancer/projects/123/bids \
    -H "Content-Type: application/json" \
    -d '{
      "amount": 100,
      "period": 7,
      "description": "I can help"
    }'
  ```

## Architecture

### Package Structure

The Freelancer PHP SDK follows PSR-4 autoloading standards:

```
src/
├── Session.php                      # HTTP session management
├── Exceptions/
│   ├── AuthTokenNotSuppliedException.php
│   ├── FreelancerException.php
│   └── Projects/
│       └── ProjectExceptions.php    # All project-related exceptions
└── Resources/
    └── Projects/
        ├── ProjectsBase.php         # Base class with HTTP methods
        ├── Projects.php             # Main Projects resource
        ├── Types.php                # Model classes and enums
        └── Helpers.php              # Helper functions
```

### Laravel Integration

The SDK is integrated into Laravel through:

1. **Service Provider** (`FreelancerServiceProvider`) - Registers the Session singleton
2. **Configuration** (`config/freelancer.php`) - API credentials and settings
3. **Controller** (`FreelancerController`) - HTTP endpoints for API operations
4. **Routes** (`routes/web.php`) - URL routing

## Authentication

This SDK uses OAuth 2.0 authentication. To get an OAuth token:

1. Visit https://developers.freelancer.com/docs/authentication/creating-a-client
2. Create an application
3. Generate an OAuth token
4. Add the token to your `.env` file

## Development

### Adding New Resources

To add a new resource (e.g., Users):

1. Create the resource class in `packages/freelancer-sdk-php/src/Resources/Users/`
2. Create exception classes in `packages/freelancer-sdk-php/src/Exceptions/Users/`
3. Create model classes in the resource directory
4. Add controller methods in `app/Http/Controllers/FreelancerController.php`
5. Add routes in `routes/web.php`

### Testing the SDK

```bash
cd packages/freelancer-sdk-php
composer install
vendor/bin/phpunit
```

## TailwindCSS v4

This application uses TailwindCSS v4 which is configured via Vite. The configuration is in:
- `vite.config.js` - Vite configuration with TailwindCSS plugin
- `resources/css/app.css` - Main CSS file

Build for production:
```bash
npm run build
```

Development mode with hot reload:
```bash
npm run dev
```

## Troubleshooting

### OAuth Token Not Set
If you see authentication errors, ensure `FREELANCER_OAUTH_TOKEN` is set in `.env`

### Package Not Found
If the SDK package isn't found, run:
```bash
composer dump-autoload
```

### Frontend Not Compiling
Ensure Node modules are installed:
```bash
npm install
npm run build
```

## Documentation References

- [Freelancer API Documentation](https://developers.freelancer.com)
- [Freelancer Authentication Guide](https://developers.freelancer.com/docs/authentication/creating-a-client)
- [Laravel 12 Documentation](https://laravel.com/docs/12.x)
- [TailwindCSS v4 Documentation](https://tailwindcss.com)

## License

GNU LGPLv3 (matching the original Python SDK)

## Contributing

This is a conversion of the official Freelancer Python SDK to PHP. Contributions are welcome to:
- Add missing resources (Users, Messages, Contests, etc.)
- Improve error handling
- Add comprehensive tests
- Enhance the Filament admin interface
