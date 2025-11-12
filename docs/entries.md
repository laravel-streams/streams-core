---
title: Entries
sort: 3
stage: review
enabled: 1
---

# Entries

Entries are instances of streams — the actual data records. If a stream is like a model class, an entry is like a model instance.

## What is an Entry?

An entry represents a single record in a stream. Each entry has:

- **Attributes** - Data values for each field
- **Methods** - Save, delete, validation, and custom methods
- **Relationships** - Connections to other entries
- **Events** - Lifecycle hooks (creating, saved, deleted, etc.)

Entries are smart objects that understand their stream's field types and automatically cast, validate, and process data.

## Creating Entries

### Using Repositories

The most common way to create entries:

```php
use Streams\Core\Support\Facades\Streams;

$post = Streams::repository('posts')->create([
    'title' => 'My First Post',
    'slug' => 'my-first-post',
    'content' => 'Hello, world!',
    'published' => true,
]);
```

### Using Factory

Get an entry instance without saving:

```php
$post = Streams::make('posts')->factory()->make([
    'title' => 'Draft Post',
    'published' => false,
]);

// Modify before saving
$post->slug = 'draft-post';
$post->save();
```

### Using Entry Constructor

Directly instantiate an entry:

```php
use Streams\Core\Entry\Entry;

$post = new Entry([
    'stream' => 'posts',
    'title' => 'New Post',
    'content' => 'Content here',
]);

$post->save();
```

### Using Helper Functions

Convenient shortcuts:

```php
// Create and save
$post = entries('posts')->create([
    'title' => 'New Post',
]);

// Make without saving
$post = stream('posts')->factory()->make([
    'title' => 'Draft',
]);
```

## Accessing Attributes

Entries provide multiple ways to access data:

### Property Access

```php
echo $post->title;          // "My First Post"
echo $post->published_at;   // Carbon instance
```

### Array Access

```php
echo $post['title'];        // "My First Post"
```

### Method Access

```php
echo $post->getAttribute('title');  // "My First Post"
```

### Magic Getters

Field types can provide custom getters:

```php
// Slug field automatically generates from title
$post->title = 'Hello World';
echo $post->slug;  // "hello-world"

// Image field returns image object
$photo = $post->image;
echo $photo->url();  // Full URL to image
```

## Setting Attributes

### Property Assignment

```php
$post->title = 'Updated Title';
$post->published = true;
```

### Mass Assignment

```php
$post->fill([
    'title' => 'New Title',
    'content' => 'New content',
    'published' => true,
]);
```

### Using setAttribute

```php
$post->setAttribute('title', 'Another Title');
```

## Saving Entries

### Save Method

```php
$post->title = 'Updated';
$post->save();
```

### Create (via Repository)

Creates and saves in one step:

```php
$post = Streams::repository('posts')->create([
    'title' => 'New Post',
]);
```

### Update (via Repository)

```php
$post = Streams::repository('posts')->find(1);
$post->title = 'Updated Title';
$post->save();
```

### Save with Options

```php
$post->save([
    'validate' => false,  // Skip validation
]);
```

## Deleting Entries

### Delete Method

```php
$post = Streams::repository('posts')->find(1);
$post->delete();
```

### Delete via Repository

```php
Streams::repository('posts')->delete($post);
```

### Bulk Delete

```php
entries('posts')
    ->where('published', false)
    ->where('created_at', '<', now()->subYear())
    ->delete();
```

## Validation

Entries automatically validate based on field rules.

### Automatic Validation

```php
try {
    $post = Streams::repository('posts')->create([
        'title' => '', // Required field
    ]);
} catch (\Illuminate\Validation\ValidationException $e) {
    $errors = $e->errors();
    // ['title' => ['The title field is required.']]
}
```

### Manual Validation

```php
$post = stream('posts')->factory()->make([
    'title' => '',
]);

$validator = $post->validator();

if ($validator->fails()) {
    dd($validator->errors());
}
```

### Skipping Validation

```php
$post->save(['validate' => false]);
```

## Type Casting

Fields automatically cast values to the correct type:

```php
$post->published = 'true';      // String
echo $post->published;          // true (boolean)

$post->price = '19.99';         // String
echo $post->price;              // 19.99 (float)

$post->published_at = '2024-01-01';
echo $post->published_at->format('Y-m-d');  // Carbon instance
```

## Relationships

Entries support relationships between streams:

### Defining Relationships

In your stream definition:

```json
{
    "fields": {
        "author": {
            "type": "relationship",
            "related": "users"
        },
        "categories": {
            "type": "relationship",
            "related": "categories",
            "multiple": true
        }
    }
}
```

### Accessing Related Entries

```php
$post = Streams::repository('posts')->find(1);

// Get related user
$author = $post->author;
echo $author->name;

// Get multiple relationships
$categories = $post->categories;
foreach ($categories as $category) {
    echo $category->name;
}
```

### Setting Relationships

```php
// Set single relationship
$post->author = $user;  // Pass entry
$post->author = 5;      // Pass ID
$post->save();

// Set multiple relationships
$post->categories = [$cat1, $cat2];
$post->categories = [1, 2, 3];  // IDs
$post->save();
```

## Working with Dates

Date fields return Carbon instances:

```php
// Access as Carbon
echo $post->published_at->format('F j, Y');
echo $post->published_at->diffForHumans();

// Check dates
if ($post->published_at->isPast()) {
    // Post is published
}

// Set dates
$post->published_at = now();
$post->published_at = '2024-12-25';
$post->published_at = Carbon::parse('tomorrow');
```

## Converting Entries

### To Array

```php
$array = $post->toArray();

// With hidden fields excluded
$array = $post->toArray();
```

### To JSON

```php
$json = $post->toJson();

// Pretty print
$json = $post->toJson(JSON_PRETTY_PRINT);

// Direct echo (implements JsonSerializable)
echo $post;  // Outputs JSON
```

### Returning in Responses

```php
// Automatically converts to JSON
return $post;

// Collection of entries
return entries('posts')->get();
```

## Custom Entry Methods

Extend entries with custom methods using abstract classes:

**app/Posts/Post.php:**

```php
<?php

namespace App\Posts;

use Illuminate\Support\Str;
use Streams\Core\Entry\Entry;

class Post extends Entry
{
    public function excerpt(int $length = 100): string
    {
        return Str::limit(strip_tags($this->content), $length);
    }
    
    public function url(): string
    {
        return route('posts.show', $this->slug);
    }
    
    public function isPublished(): bool
    {
        return $this->published && 
               $this->published_at?->isPast();
    }
    
    public function scopePublished($query)
    {
        return $query
            ->where('published', true)
            ->where('published_at', '<=', now());
    }
}
```

Configure in stream:

```json
{
    "config": {
        "abstract": "App\\Posts\\Post"
    }
}
```

Use custom methods:

```php
$post = Streams::repository('posts')->first();

echo $post->excerpt(50);
echo $post->url();

if ($post->isPublished()) {
    // Show post
}

// Use custom scopes
$posts = entries('posts')->published()->get();
```

## Entry Events

Entries fire events throughout their lifecycle:

### Available Events

- `initializing` - Before entry is constructed
- `initialized` - After entry is constructed
- `saving` - Before saving
- `saved` - After saving
- `creating` - Before creating new entry
- `created` - After creating new entry
- `updating` - Before updating existing entry
- `updated` - After updating existing entry
- `deleting` - Before deleting
- `deleted` - After deleting

### Listening to Events

In a custom entry class:

```php
<?php

namespace App\Posts;

use Streams\Core\Entry\Entry;

class Post extends Entry
{
    protected function onSaving(): void
    {
        // Auto-generate slug if empty
        if (empty($this->slug)) {
            $this->slug = Str::slug($this->title);
        }
        
        // Set published date
        if ($this->published && !$this->published_at) {
            $this->published_at = now();
        }
    }
    
    protected function onDeleting(): void
    {
        // Clean up related data
        $this->comments()->delete();
    }
}
```

### Using Event Listeners

```php
use Streams\Core\Support\Facades\Streams;

Streams::make('posts')->on('saving', function ($entry) {
    // Do something before saving
});
```

## Searching Entries

Streams integrates with Laravel Scout:

### Configure Scout

```json
{
    "config": {
        "searchable": true
    }
}
```

### Search

```php
use Streams\Core\Entry\Entry;

// Search entries
$results = Entry::search('laravel')->get();

// Search specific stream
$posts = entries('posts')->search('tutorial')->get();
```

## Entry Collections

Query results return collections of entries:

```php
$posts = entries('posts')->get();

// Collection methods
$posts->count();
$posts->first();
$posts->pluck('title');
$posts->filter(fn($post) => $post->published);

// Map over entries
$titles = $posts->map(fn($post) => $post->title);

// Group by field
$byAuthor = $posts->groupBy('author_id');
```

## Performance Tips

### Eager Loading

Load relationships efficiently:

```php
$posts = entries('posts')
    ->with('author', 'categories')
    ->get();

foreach ($posts as $post) {
    echo $post->author->name;  // No additional query
}
```

### Selecting Fields

Load only needed fields:

```php
$posts = entries('posts')
    ->select(['id', 'title', 'slug'])
    ->get();
```

### Chunking Large Results

```php
entries('posts')->chunk(100, function ($posts) {
    foreach ($posts as $post) {
        // Process entry
    }
});
```

## Best Practices

### Always Validate

Let validation rules do their work:

```json
{
    "fields": {
        "email": {
            "type": "email",
            "required": true,
            "unique": true
        }
    }
}
```

### Use Custom Classes

Add domain logic to entry classes:

```php
class Product extends Entry
{
    public function finalPrice()
    {
        return $this->on_sale 
            ? $this->sale_price 
            : $this->price;
    }
}
```

### Type Hints

Use type hints for better IDE support:

```php
/** @var \App\Posts\Post $post */
$post = repository('posts')->find(1);
```

## Next Steps

- **[Repositories](/docs/core/repositories)** - Query and filter entries
- **[Fields](/docs/core/fields)** - Learn about field types
- **[Validation](/docs/core/validation)** - Advanced validation techniques
