# Freelancer SDK PHP - Examples

This document provides usage examples for the Freelancer PHP SDK in the Laravel application.

## Basic Setup

The SDK is automatically configured via the `FreelancerServiceProvider`. You can inject the `Session` class into your controllers or use it directly.

### Using Dependency Injection

```php
use FreelancerSdk\Session;
use FreelancerSdk\Resources\Projects\Projects;

class MyController extends Controller
{
    protected Projects $projects;

    public function __construct(Session $session)
    {
        $this->projects = new Projects($session);
    }

    public function index()
    {
        $projects = $this->projects->getProjects();
        return view('projects.index', compact('projects'));
    }
}
```

### Direct Usage

```php
use FreelancerSdk\Session;
use FreelancerSdk\Resources\Projects\Projects;
use FreelancerSdk\Resources\Projects\Helpers;

// Create session manually
$session = new Session(
    config('freelancer.oauth_token'),
    config('freelancer.api_url')
);

// Use projects resource
$projects = new Projects($session);
```

## Projects

### List Projects

```php
use FreelancerSdk\Resources\Projects\Projects;

$projects = new Projects($session);

// Get specific projects by ID
$result = $projects->getProjects([
    'projects[]' => [123456, 789012],
]);

// Get projects by owner
$result = $projects->getProjects([
    'owners[]' => [123, 456],
]);
```

### Search Projects

```php
$projects = new Projects($session);

// Search active projects
$result = $projects->searchProjects([
    'jobs[]' => [7, 8],  // PHP, JavaScript
    'min_avg_price' => 100,
    'max_avg_price' => 500,
]);
```

### Create a Project

```php
use FreelancerSdk\Resources\Projects\Helpers;

$projects = new Projects($session);

// Using helpers
$projectData = [
    'title' => 'Build a Laravel Application',
    'description' => 'I need a Laravel developer to build a web application',
    'currency' => Helpers::createCurrencyObject(1, 'USD'),
    'budget' => Helpers::createBudgetObject(500, 1000),
    'jobs' => [
        Helpers::createJobObject(7),   // PHP
        Helpers::createJobObject(3),   // Website Design
    ],
];

$project = $projects->createProject($projectData);

echo "Project created: {$project->url}\n";
echo "Project ID: {$project->id}\n";
```

### Create with Raw Arrays

```php
$projectData = [
    'title' => 'Mobile App Development',
    'description' => 'Need an iOS and Android developer',
    'currency' => ['id' => 1],
    'budget' => ['minimum' => 1000, 'maximum' => 5000],
    'jobs' => [
        ['id' => 44],  // iPhone
        ['id' => 45],  // Android
    ],
];

$project = $projects->createProject($projectData);
```

## Bids

### List Bids

```php
$projects = new Projects($session);

// Get bids for specific projects
$bids = $projects->getBids([
    'projects[]' => [123456, 789012],
]);

foreach ($bids as $bid) {
    echo "Bid #{$bid->id}: {$bid->amount}\n";
}
```

### Place a Bid

```php
$projects = new Projects($session);

$projectId = 123456;
$bidData = [
    'amount' => 250,
    'period' => 7,  // days
    'description' => 'I have 5 years of experience with Laravel...',
];

$bid = $projects->placeBid($projectId, $bidData);

echo "Bid placed successfully: {$bid->id}\n";
```

## Using in Artisan Commands

```php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use FreelancerSdk\Session;
use FreelancerSdk\Resources\Projects\Projects;

class ListFreelancerProjects extends Command
{
    protected $signature = 'freelancer:list-projects {user_id?}';
    protected $description = 'List Freelancer projects';

    public function handle(Session $session)
    {
        $projects = new Projects($session);
        
        $filters = [];
        if ($userId = $this->argument('user_id')) {
            $filters['owners[]'] = [$userId];
        }

        $result = $projects->getProjects($filters);

        $this->table(
            ['ID', 'Title', 'Status'],
            collect($result)->map(fn($p) => [
                $p->id,
                $p->title,
                $p->status ?? 'unknown'
            ])
        );
    }
}
```

## API Routes Examples

### Using cURL

#### List Projects
```bash
curl http://localhost:8000/freelancer/projects
```

#### Search Projects
```bash
curl "http://localhost:8000/freelancer/projects/search?jobs[]=7&jobs[]=8"
```

#### Create Project
```bash
curl -X POST http://localhost:8000/freelancer/projects \
  -H "Content-Type: application/json" \
  -d '{
    "title": "My New Project",
    "description": "Project description here",
    "currency": {"id": 1},
    "budget": {"minimum": 100, "maximum": 500},
    "jobs": [{"id": 7}]
  }'
```

#### Place a Bid
```bash
curl -X POST http://localhost:8000/freelancer/projects/123456/bids \
  -H "Content-Type: application/json" \
  -d '{
    "amount": 250,
    "period": 7,
    "description": "I can complete this project"
  }'
```

### Using JavaScript/Axios

```javascript
// List projects
axios.get('/freelancer/projects')
  .then(response => console.log(response.data));

// Search projects
axios.get('/freelancer/projects/search', {
  params: {
    'jobs[]': [7, 8],
    min_avg_price: 100
  }
})
.then(response => console.log(response.data));

// Create project
axios.post('/freelancer/projects', {
  title: 'My Project',
  description: 'Description',
  currency: { id: 1 },
  budget: { minimum: 100, maximum: 500 },
  jobs: [{ id: 7 }]
})
.then(response => console.log(response.data));

// Place bid
axios.post(`/freelancer/projects/123456/bids`, {
  amount: 250,
  period: 7,
  description: 'I can help with this'
})
.then(response => console.log(response.data));
```

## Error Handling

```php
use FreelancerSdk\Resources\Projects\Projects;
use FreelancerSdk\Exceptions\Projects\ProjectNotCreatedException;

$projects = new Projects($session);

try {
    $project = $projects->createProject($data);
    echo "Success: {$project->id}\n";
} catch (ProjectNotCreatedException $e) {
    echo "Error: {$e->getMessage()}\n";
    echo "Error Code: {$e->getErrorCode()}\n";
    echo "Request ID: {$e->getRequestId()}\n";
}
```

## Testing Without Real API Calls

If you don't have a real OAuth token yet, you can mock the responses:

```php
use FreelancerSdk\Session;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

// Create mock responses
$mock = new MockHandler([
    new Response(200, [], json_encode([
        'status' => 'success',
        'result' => [
            'projects' => [
                ['id' => 123, 'title' => 'Test Project']
            ]
        ]
    ])),
]);

$handlerStack = HandlerStack::create($mock);
$client = new Client(['handler' => $handlerStack]);

// You would need to modify Session to accept a custom client
// This is just a conceptual example
```

## Common Job IDs

Here are some common job IDs for reference:

- 3: Website Design
- 7: PHP
- 8: JavaScript
- 17: HTML
- 18: MySQL
- 44: iPhone
- 45: Android
- 58: Mobile App Development
- 59: Graphic Design
- 94: Python

## Currency IDs

Common currency IDs:

- 1: USD (US Dollar)
- 2: GBP (British Pound)
- 3: AUD (Australian Dollar)
- 4: CAD (Canadian Dollar)
- 5: EUR (Euro)

For a complete list, you can call the Jobs endpoint (to be implemented).

## Next Steps

- Implement additional resources (Users, Messages, Milestones, Contests)
- Add unit tests
- Create a Filament resource for visual management
- Add caching layer for frequently accessed data
- Implement webhooks for real-time updates
