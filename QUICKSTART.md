# Quick Start Guide

Get up and running with the Freelancer Laravel application in 5 minutes.

## Prerequisites

- PHP 8.2+
- Composer
- Node.js & NPM
- A Freelancer.com account with API access

## Step 1: Get Your OAuth Token

1. Go to https://developers.freelancer.com
2. Create a new application
3. Generate an OAuth token
4. Keep it handy for Step 3

## Step 2: Clone and Install

```bash
# Clone the repository
git clone <your-repo-url>
cd freelancer-sdk-php

# Navigate to Laravel app
cd laravel-app

# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

## Step 3: Configure Environment

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Edit .env and add your OAuth token
nano .env  # or use your preferred editor
```

Add this line to your `.env`:
```
FREELANCER_OAUTH_TOKEN=your_actual_token_here
```

## Step 4: Setup Database

```bash
# Create SQLite database
touch database/database.sqlite

# Run migrations
php artisan migrate
```

## Step 5: Build Assets

```bash
# Build frontend assets
npm run build
```

## Step 6: Start the Server

```bash
# Start Laravel development server
php artisan serve
```

Visit http://localhost:8000 - you should see the Freelancer Dashboard!

## Quick Test

Test that everything works:

```bash
# List routes
php artisan route:list --except-vendor

# Test the SDK classes load
php artisan tinker --execute="echo 'SDK loaded: ' . class_exists('FreelancerSdk\Session');"
```

## Your First API Call

Try listing projects via the API:

```bash
curl http://localhost:8000/freelancer/projects
```

Or create a test project:

```bash
curl -X POST http://localhost:8000/freelancer/projects \
  -H "Content-Type: application/json" \
  -d '{
    "title": "My Test Project",
    "description": "Testing the API",
    "currency": {"id": 1},
    "budget": {"minimum": 100},
    "jobs": [{"id": 7}]
  }'
```

## Using in Your Code

Create a new controller:

```php
php artisan make:controller MyFreelancerController
```

Then use the SDK:

```php
<?php

namespace App\Http\Controllers;

use FreelancerSdk\Session;
use FreelancerSdk\Resources\Projects\Projects;

class MyFreelancerController extends Controller
{
    public function index(Session $session)
    {
        $projects = new Projects($session);
        $list = $projects->getProjects();
        
        return view('my-projects', ['projects' => $list]);
    }
}
```

## Development Workflow

During development, run both the server and asset watcher:

```bash
# Terminal 1: Start Laravel
php artisan serve

# Terminal 2: Watch assets
npm run dev
```

## Troubleshooting

### "Class not found" errors
```bash
composer dump-autoload
```

### Asset compilation errors
```bash
npm install
npm run build
```

### OAuth errors
Make sure `FREELANCER_OAUTH_TOKEN` is set in `.env`

## Next Steps

- Check [EXAMPLES.md](EXAMPLES.md) for detailed usage examples
- Read [laravel-app/README.md](laravel-app/README.md) for full documentation
- Visit the [Freelancer API Docs](https://developers.freelancer.com)
- Customize the dashboard in `resources/views/freelancer/dashboard.blade.php`

## Common Tasks

### Add a new route
Edit `routes/web.php`

### Add a new controller method
Edit `app/Http/Controllers/FreelancerController.php`

### Customize the dashboard
Edit `resources/views/freelancer/dashboard.blade.php`

### Use different CSS
Edit `resources/css/app.css`

### Change API configuration
Edit `config/freelancer.php`

## Getting Help

- [Freelancer API Documentation](https://developers.freelancer.com)
- [Laravel Documentation](https://laravel.com/docs)
- [TailwindCSS Documentation](https://tailwindcss.com)

Happy coding! 🚀
