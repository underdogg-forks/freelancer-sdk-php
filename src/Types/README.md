# Type Classes

The Type classes in this SDK represent data models returned from the Freelancer API. They follow PHP best practices with explicit properties and getter methods while maintaining backward compatibility.

## Features

- **Explicit typed properties** - Each model has clearly defined properties with type hints
- **Getter methods** - Access data through typed getter methods (e.g., `getId()`, `getTitle()`)
- **JsonSerializable** - Models can be directly encoded to JSON
- **ArrayAccess** - Models can be accessed like arrays for backward compatibility
- **Flexible attributes** - Unknown fields are stored in an `attributes` array
- **Framework-agnostic** - No dependencies on any framework

## Usage

### Using Getter Methods (Recommended)

```php
$project = new Project([
    'id' => 123,
    'title' => 'My Project',
    'description' => 'Project description'
]);

// Access via getters
echo $project->getId();          // 123
echo $project->getTitle();       // "My Project"
echo $project->getDescription(); // "Project description"
```

### Using Magic Properties (Backward Compatible)

```php
// Also works with magic getters
echo $project->id;          // 123
echo $project->title;       // "My Project"
echo $project->description; // "Project description"
```

### Using Array Access (Backward Compatible)

```php
// Array-like access also supported
echo $project['id'];          // 123
echo $project['title'];       // "My Project"
echo $project['description']; // "Project description"
```

### JSON Serialization

```php
$json = json_encode($project);
// Returns: {"id":123,"title":"My Project","description":"Project description"}
```

### Converting to Array

```php
$array = $project->toArray();
// Returns: ['id' => 123, 'title' => 'My Project', 'description' => 'Project description']
```

### Custom Attributes

Unknown fields are automatically stored in the `attributes` array:

```php
$project = new Project([
    'id' => 123,
    'custom_field' => 'custom value'
]);

echo $project->getId();                              // 123
echo $project->getAttribute('custom_field');         // "custom value"
echo $project->custom_field;                         // "custom value" (via magic getter)
```

## Available Models

- **Project** - Represents a Freelancer project
- **Bid** - Represents a bid on a project
- **Contest** - Represents a contest
- **Message** - Represents a message in a thread
- **Thread** - Represents a message thread
- **User** - Represents a user
- **Milestone** - Represents a milestone payment
- **MilestoneRequest** - Represents a milestone request
- **Service** - Represents a service

## Model Properties

### Project

- `id` (int) - Project ID
- `title` (string) - Project title
- `description` (string) - Project description
- `seo_url` (string) - SEO-friendly URL slug
- `url` (string) - Full project URL
- `currency` (array) - Currency information
- `budget` (array) - Budget information
- `jobs` (array) - Job categories
- `owner_id` (int) - Owner user ID
- `status` (string) - Project status
- `tracks` (array) - Project tracks

### Bid

- `id` (int) - Bid ID
- `project_id` (int) - Associated project ID
- `bidder_id` (int) - Bidder user ID
- `amount` (float) - Bid amount
- `period` (int) - Delivery period in days
- `description` (string) - Bid description
- `milestone_percentage` (int) - Milestone percentage
- `retracted` (bool) - Whether bid is retracted
- `time_submitted` (int) - Submission timestamp

### Contest

- `id` (int) - Contest ID
- `owner_id` (int) - Owner user ID
- `title` (string) - Contest title
- `description` (string) - Contest description
- `type` (string) - Contest type (e.g., 'freemium')
- `duration` (int) - Contest duration in days
- `jobs` (array) - Job categories
- `currency` (array) - Currency information
- `prize` (float) - Prize amount

### Message

- `id` (int) - Message ID
- `thread_id` (int) - Associated thread ID
- `from_user_id` (int) - Sender user ID
- `message` (string) - Message content
- `time_created` (int) - Creation timestamp
- `attachments` (array) - File attachments

### Thread

- `id` (int) - Thread ID
- `thread` (array) - Thread metadata
- `context` (array) - Context information
- `members` (array) - Thread member IDs
- `owner` (int) - Thread owner ID
- `thread_type` (string) - Type of thread
- `time_created` (int) - Creation timestamp

## Design Philosophy

These models follow a hybrid approach:

1. **Modern PHP** - Explicit typed properties and getter methods
2. **Backward Compatible** - Magic methods and ArrayAccess for existing code
3. **Framework-Agnostic** - No Laravel, Symfony, or other framework dependencies
4. **Flexible** - Handles unknown API fields gracefully via attributes
5. **Type-Safe** - Proper type hints throughout

This design allows the SDK to be used in any PHP project while providing a modern, IDE-friendly API.
