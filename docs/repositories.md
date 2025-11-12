---
title: Repositories
sort: 4
stage: review
enabled: 1
---

# Repositories

Repositories provide a clean, consistent interface for querying and manipulating stream entries. They abstract away data source details and provide a fluent API for building queries.

## What is a Repository?

A repository is the primary way to interact with stream data. It provides:

- **CRUD Operations** - Create, read, update, delete entries
- **Query Building** - Fluent interface for filtering and sorting
- **Data Source Abstraction** - Same API regardless of storage
- **Customization** - Extend with your own methods

Think of repositories as the "gateway" to your stream data.

## Getting a Repository

### Using Facades

```php
use Streams\Core\Support\Facades\Streams;

$repository = Streams::repository('posts');
```

### Using Helper Functions

```php
$repository = repository('posts');
```

### From Stream Instance

```php
$stream = stream('posts');
$repository = $stream->repository();
```

## Basic Operations

### Find by ID

```php
$post = repository('posts')->find(1);

if ($post) {
    echo $post->title;
}
```

### Find Multiple by IDs

```php
$posts = repository('posts')->findAll([1, 2, 3]);
```

### Find by Field

```php
$post = repository('posts')->findBy('slug', 'my-first-post');
```

### Get All Entries

```php
$posts = repository('posts')->all();
```

### Count Entries

```php
$count = repository('posts')->count();
```

## Creating Entries

### Create Method

Creates and saves an entry:

```php
$post = repository('posts')->create([
    'title' => 'New Post',
    'content' => 'Post content',
    'published' => true,
]);
```

### Save Method

Save an existing entry:

```php
$post = repository('posts')->find(1);
$post->title = 'Updated Title';
repository('posts')->save($post);
```

## Deleting Entries

### Delete Method

```php
$post = repository('posts')->find(1);
repository('posts')->delete($post);
```

### Bulk Delete

```php
repository('posts')
    ->newCriteria()
    ->where('published', false)
    ->delete();
```

## Query Building

Repositories use a Criteria API for building complex queries.

### Getting a Query Builder

```php
// Get criteria from repository
$criteria = repository('posts')->newCriteria();

// Or use the helper
$criteria = entries('posts');

// Or from stream
$criteria = stream('posts')->entries();
```

All three return the same Criteria instance for building queries.

## Filtering with Where

### Basic Where

```php
$posts = entries('posts')
    ->where('published', true)
    ->get();
```

### Where with Operators

```php
// Greater than
$posts = entries('posts')
    ->where('views', '>', 1000)
    ->get();

// Less than or equal
$posts = entries('posts')
    ->where('created_at', '<=', now())
    ->get();

// Not equal
$posts = entries('posts')
    ->where('status', '!=', 'draft')
    ->get();

// Like (contains)
$posts = entries('posts')
    ->where('title', 'LIKE', '%laravel%')
    ->get();

// In array
$posts = entries('posts')
    ->where('category', 'IN', ['php', 'laravel', 'javascript'])
    ->get();
```

### Multiple Where Conditions

```php
$posts = entries('posts')
    ->where('published', true)
    ->where('featured', true)
    ->where('views', '>', 100)
    ->get();
```

### Or Where

```php
$posts = entries('posts')
    ->where('author_id', 1)
    ->orWhere('author_id', 2)
    ->get();
```

### Conditional Queries

Use `when()` to conditionally apply filters:

```php
$posts = entries('posts')
    ->when($request->has('search'), function ($query) use ($request) {
        $query->where('title', 'LIKE', "%{$request->search}%");
    })
    ->when($request->input('published'), function ($query) {
        $query->where('published', true);
    })
    ->get();
```

## Sorting

### Order By

```php
// Ascending
$posts = entries('posts')
    ->orderBy('created_at', 'asc')
    ->get();

// Descending
$posts = entries('posts')
    ->orderBy('created_at', 'desc')
    ->get();

// Multiple sorts
$posts = entries('posts')
    ->orderBy('published', 'desc')
    ->orderBy('created_at', 'desc')
    ->get();
```

## Limiting Results

### Limit

```php
// Get 10 posts
$posts = entries('posts')->limit(10)->get();

// Get 10 posts, skip first 20
$posts = entries('posts')->limit(10, 20)->get();
```

### First

Get the first result:

```php
$post = entries('posts')
    ->where('published', true)
    ->orderBy('created_at', 'desc')
    ->first();
```

## Pagination

### Length Aware Pagination

```php
$posts = entries('posts')
    ->where('published', true)
    ->paginate(15); // 15 per page

// In Blade
@foreach ($posts as $post)
    <h2>{{ $post->title }}</h2>
@endforeach

{{ $posts->links() }}
```

### Simple Pagination

For better performance when you don't need total count:

```php
$posts = entries('posts')
    ->where('published', true)
    ->simplePaginate(15);
```

### Custom Pagination

```php
$posts = entries('posts')
    ->where('published', true)
    ->paginate(
        perPage: 20,
        pageName: 'page',
        page: $request->input('page', 1)
    );
```

## Caching Results

### Cache Queries

```php
// Cache for 1 hour (default)
$posts = entries('posts')
    ->cache()
    ->get();

// Cache for 10 minutes
$posts = entries('posts')
    ->cache(600)
    ->get();

// Cache with custom key
$posts = entries('posts')
    ->cache(3600, 'featured_posts')
    ->get();
```

### Fresh (Skip Cache)

```php
$posts = entries('posts')
    ->fresh()
    ->get();
```

## Eager Loading

Load relationships efficiently to avoid N+1 queries:

```php
$posts = entries('posts')
    ->with('author', 'categories')
    ->get();

foreach ($posts as $post) {
    echo $post->author->name;      // No additional query
    echo $post->categories->first()->name; // No additional query
}
```

## Aggregates

### Count

```php
$count = entries('posts')
    ->where('published', true)
    ->count();
```

### Other Aggregates

```php
// Sum
$total = entries('orders')->sum('total');

// Average
$avgPrice = entries('products')->avg('price');

// Min/Max
$min = entries('products')->min('price');
$max = entries('products')->max('price');
```

## Advanced Queries

### First or Create

Get first matching entry or create it:

```php
$post = entries('posts')
    ->where('slug', 'welcome')
    ->firstOrCreate([
        'title' => 'Welcome',
        'slug' => 'welcome',
        'content' => 'Welcome to our site!',
    ]);
```

### Update or Create

Update first matching entry or create it:

```php
$post = entries('posts')
    ->where('slug', 'welcome')
    ->updateOrCreate([
        'title' => 'Welcome (Updated)',
        'content' => 'Updated content',
    ]);
```

### Chunking

Process large datasets efficiently:

```php
entries('posts')->chunk(100, function ($posts) {
    foreach ($posts as $post) {
        // Process each post
        $post->process();
        $post->save();
    }
});
```

## Search Integration

Streams integrates with Laravel Scout:

```php
use Streams\Core\Entry\Entry;

// Search all streams
$results = Entry::search('laravel')->get();

// Search specific stream
$posts = entries('posts')
    ->search('tutorial')
    ->get();
```

## Custom Repository Classes

Extend repositories with domain-specific methods:

**app/Posts/PostRepository.php:**

```php
<?php

namespace App\Posts;

use Streams\Core\Repository\Repository;
use Illuminate\Support\Collection;

class PostRepository extends Repository
{
    public function published(): Collection
    {
        return $this->newCriteria()
            ->where('published', true)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->get();
    }
    
    public function byAuthor(string $authorId): Collection
    {
        return $this->newCriteria()
            ->where('author_id', $authorId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    public function featured(int $limit = 5): Collection
    {
        return $this->newCriteria()
            ->where('featured', true)
            ->where('published', true)
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }
    
    public function archive(int $year, ?int $month = null): Collection
    {
        $query = $this->newCriteria()
            ->where('published', true)
            ->where('published_at', '>=', "{$year}-01-01")
            ->where('published_at', '<', ($year + 1) . "-01-01");
            
        if ($month) {
            $query->where('published_at', '>=', "{$year}-{$month}-01")
                  ->where('published_at', '<', date('Y-m-d', strtotime("{$year}-{$month}-01 +1 month")));
        }
        
        return $query->orderBy('published_at', 'desc')->get();
    }
}
```

**Configure in stream:**

```json
{
    "config": {
        "repository": "App\\Posts\\PostRepository"
    }
}
```

**Use custom methods:**

```php
$posts = repository('posts')->published();
$authorPosts = repository('posts')->byAuthor($authorId);
$featured = repository('posts')->featured(3);
$archive = repository('posts')->archive(2024, 3);
```

## Repository Events

Repositories fire events during operations:

```php
use Streams\Core\Support\Facades\Streams;

$stream = Streams::make('posts');

// Listen to repository events
$stream->repository()->on('saving', function ($entry) {
    // Before saving
    logger("Saving: {$entry->title}");
});

$stream->repository()->on('saved', function ($entry) {
    // After saved
    Cache::forget('posts_list');
});
```

## Working with Different Sources

Repositories work the same regardless of data source:

### Filebase Source

```php
// streams/posts.json configured with filebase
$posts = repository('posts')->all();
```

### Database Source

```php
// streams/posts.json configured with database
$posts = repository('posts')->all();  // Same API!
```

### Eloquent Source

```php
// streams/posts.json configured with eloquent
$posts = repository('posts')->all();  // Still same API!
```

The beauty is **your code doesn't change** when you switch sources.

## Performance Optimization

### Select Specific Fields

```php
$posts = entries('posts')
    ->select(['id', 'title', 'slug'])
    ->get();
```

### Index Your Data

For database sources, ensure proper indexes:

```php
// In migration
$table->index(['published', 'published_at']);
```

### Use Caching

```php
$featured = entries('posts')
    ->where('featured', true)
    ->cache(3600, 'featured_posts')
    ->limit(5)
    ->get();
```

### Eager Load Relationships

```php
// Bad: N+1 queries
$posts = entries('posts')->get();
foreach ($posts as $post) {
    echo $post->author->name; // Query per post
}

// Good: 2 queries
$posts = entries('posts')->with('author')->get();
foreach ($posts as $post) {
    echo $post->author->name; // No additional queries
}
```

## Query Scopes

Add reusable query logic to custom repository:

```php
class PostRepository extends Repository
{
    public function scopePublished($query)
    {
        return $query
            ->where('published', true)
            ->where('published_at', '<=', now());
    }
    
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}

// Use scopes
$posts = repository('posts')
    ->newCriteria()
    ->published()
    ->byCategory('tutorials')
    ->get();
```

## Best Practices

### Use Repositories for Business Logic

```php
class PostRepository extends Repository
{
    public function publish($postId)
    {
        $post = $this->find($postId);
        $post->published = true;
        $post->published_at = now();
        $this->save($post);
        
        event(new PostPublished($post));
        
        return $post;
    }
}
```

### Type Hint Return Values

```php
use Illuminate\Support\Collection;

class PostRepository extends Repository
{
    public function featured(): Collection
    {
        return $this->newCriteria()
            ->where('featured', true)
            ->get();
    }
}
```

### Cache Expensive Queries

```php
public function siteStats(): array
{
    return Cache::remember('site_stats', 3600, function () {
        return [
            'total_posts' => $this->count(),
            'published' => $this->newCriteria()->where('published', true)->count(),
            'drafts' => $this->newCriteria()->where('published', false)->count(),
        ];
    });
}
```

### Keep Controllers Thin

```php
// Bad
public function index()
{
    $posts = entries('posts')
        ->where('published', true)
        ->where('published_at', '<=', now())
        ->orderBy('published_at', 'desc')
        ->paginate(15);
        
    return view('posts.index', compact('posts'));
}

// Good
public function index()
{
    $posts = repository('posts')->published()->paginate(15);
    
    return view('posts.index', compact('posts'));
}
```

## Next Steps

- **[Fields](/docs/core/fields)** - Learn about available field types
- **[Validation](/docs/core/validation)** - Validate entry data
- **[Entries](/docs/core/entries)** - Deep dive into entry objects
