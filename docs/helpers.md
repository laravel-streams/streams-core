---
title: Helpers
sort: 7
stage: review
enabled: 1
---

# Helper Functions

Streams Core provides convenient global helper functions for common tasks. These shortcuts make your code cleaner and more readable.

## Stream Helpers

### stream()

Get a stream instance by handle.

**Signature:**
```php
function stream(string $handle): Stream
```

**Usage:**
```php
$stream = stream('posts');

echo $stream->name;        // "Posts"
echo $stream->description; // Stream description

// Access fields
$fields = $stream->fields;

// Get repository
$repository = $stream->repository();

// Query entries
$entries = $stream->entries()->where('published', true)->get();
```

**Example:**
```php
// Instead of:
use Streams\Core\Support\Facades\Streams;
$stream = Streams::make('posts');

// Use:
$stream = stream('posts');
```

### entries()

Get a criteria builder for querying stream entries.

**Signature:**
```php
function entries(string $stream): Criteria
```

**Usage:**
```php
// Query entries
$posts = entries('posts')
    ->where('published', true)
    ->orderBy('created_at', 'desc')
    ->limit(10)
    ->get();

// Count entries
$count = entries('posts')
    ->where('published', true)
    ->count();

// Pagination
$posts = entries('posts')
    ->where('category', 'tutorials')
    ->paginate(15);

// Find by ID
$post = entries('posts')
    ->find(1);
```

**Example:**
```php
// Instead of:
use Streams\Core\Support\Facades\Streams;
$posts = Streams::entries('posts')
    ->where('published', true)
    ->get();

// Use:
$posts = entries('posts')
    ->where('published', true)
    ->get();
```

### repository()

Get a repository instance for a stream.

**Signature:**
```php
function repository(string $stream): Repository
```

**Usage:**
```php
$repository = repository('posts');

// Create entry
$post = $repository->create([
    'title' => 'New Post',
    'content' => 'Content here',
]);

// Find by ID
$post = $repository->find(1);

// Find by field
$post = $repository->findBy('slug', 'hello-world');

// Get all
$posts = $repository->all();

// Count
$count = $repository->count();

// Delete
$repository->delete($post);
```

**Example:**
```php
// Instead of:
use Streams\Core\Support\Facades\Streams;
$repository = Streams::repository('posts');

// Use:
$repository = repository('posts');
```

## Performance Helpers

### response_time()

Get the current request's response time in seconds.

**Signature:**
```php
function response_time(int $precision = 2): float
```

**Usage:**
```php
// Get response time
$time = response_time();  // 0.45

// More precision
$time = response_time(4); // 0.4532

// Display in views
echo "Page loaded in " . response_time() . " seconds";
```

**Example:**
```php
// In a Blade template
<footer>
    <small>
        Page generated in {{ response_time() }}s
        using {{ memory_usage() }}
    </small>
</footer>
```

### memory_usage()

Get the current memory usage in human-readable format.

**Signature:**
```php
function memory_usage(int $precision = 2): string
```

**Usage:**
```php
// Get memory usage
$memory = memory_usage();  // "4.5 mb"

// More precision
$memory = memory_usage(3); // "4.523 mb"

// Display in views
echo "Memory: " . memory_usage();
```

**Example:**
```php
// In a debug blade component
<div class="debug-info">
    <p>Response Time: {{ response_time() }}s</p>
    <p>Memory Usage: {{ memory_usage() }}</p>
</div>
```

## HTML Helper

### html_attributes()

Convert an array of attributes to an HTML attribute string.

**Signature:**
```php
function html_attributes(array $attributes): string
```

**Usage:**
```php
$attrs = [
    'class' => 'btn btn-primary',
    'id' => 'submit-button',
    'data-action' => 'submit',
];

echo '<button' . html_attributes($attrs) . '>Submit</button>';
// <button class="btn btn-primary" id="submit-button" data-action="submit">Submit</button>
```

**Example in Blade:**
```blade
@php
$buttonAttrs = [
    'type' => 'submit',
    'class' => 'btn btn-primary',
    'data-confirm' => 'Are you sure?',
];
@endphp

<button{!! html_attributes($buttonAttrs) !!}>
    Delete Post
</button>
```

## Usage Patterns

### In Controllers

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = entries('posts')
            ->where('published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(15);
        
        return view('posts.index', compact('posts'));
    }
    
    public function show($id)
    {
        $post = repository('posts')->find($id);
        
        abort_if(!$post, 404);
        
        return view('posts.show', compact('post'));
    }
    
    public function store(Request $request)
    {
        $post = repository('posts')->create(
            $request->all()
        );
        
        return redirect()
            ->route('posts.show', $post->id)
            ->with('success', 'Post created!');
    }
}
```

### In Blade Views

```blade
{{-- List posts --}}
@foreach(entries('posts')->where('published', true)->get() as $post)
    <article>
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->excerpt }}</p>
        <a href="{{ route('posts.show', $post->slug) }}">Read more</a>
    </article>
@endforeach

{{-- Show featured post --}}
@php
$featured = entries('posts')
    ->where('featured', true)
    ->first();
@endphp

@if($featured)
    <div class="featured-post">
        <h3>{{ $featured->title }}</h3>
        <p>{{ $featured->excerpt }}</p>
    </div>
@endif

{{-- Performance footer --}}
<footer>
    <small>
        Generated in {{ response_time() }}s 
        ({{ memory_usage() }})
    </small>
</footer>
```

### In API Routes

```php
use Illuminate\Support\Facades\Route;

// List posts
Route::get('/api/posts', function () {
    return entries('posts')
        ->where('published', true)
        ->orderBy('published_at', 'desc')
        ->paginate(20);
});

// Get post
Route::get('/api/posts/{id}', function ($id) {
    $post = repository('posts')->find($id);
    
    return $post ?: response()->json([
        'error' => 'Post not found'
    ], 404);
});

// Create post
Route::post('/api/posts', function (Request $request) {
    $post = repository('posts')->create(
        $request->all()
    );
    
    return response()->json($post, 201);
});
```

### In Artisan Commands

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PublishScheduledPosts extends Command
{
    protected $signature = 'posts:publish';
    
    protected $description = 'Publish scheduled posts';
    
    public function handle()
    {
        $posts = entries('posts')
            ->where('status', 'scheduled')
            ->where('publish_at', '<=', now())
            ->get();
        
        foreach ($posts as $post) {
            $post->status = 'published';
            $post->save();
            
            $this->info("Published: {$post->title}");
        }
        
        $this->info("Published {$posts->count()} posts");
    }
}
```

### In Livewire Components

```php
<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class PostsList extends Component
{
    use WithPagination;
    
    public $search = '';
    public $category = '';
    
    public function render()
    {
        $posts = entries('posts')
            ->where('published', true)
            ->when($this->search, function ($query) {
                $query->where('title', 'LIKE', "%{$this->search}%");
            })
            ->when($this->category, function ($query) {
                $query->where('category', $this->category);
            })
            ->orderBy('published_at', 'desc')
            ->paginate(10);
        
        return view('livewire.posts-list', [
            'posts' => $posts,
        ]);
    }
}
```

## Combining Helpers

Helper functions work great together:

```php
// Get stream and query
$stream = stream('posts');
$posts = $stream->entries()
    ->where('published', true)
    ->get();

// Or directly
$posts = entries('posts')
    ->where('published', true)
    ->get();

// Create via repository
$post = repository('posts')->create([
    'title' => 'New Post',
]);

// Update
$post = repository('posts')->find(1);
$post->title = 'Updated';
repository('posts')->save($post);
```

## Performance Monitoring

Use performance helpers to monitor application health:

```php
// In a middleware
public function terminate($request, $response)
{
    if (response_time() > 1.0) {
        \Log::warning('Slow request', [
            'url' => $request->url(),
            'time' => response_time(4),
            'memory' => memory_usage(),
        ]);
    }
}
```

## Best Practices

### Use Helpers for Cleaner Code

```php
// ❌ Verbose
use Streams\Core\Support\Facades\Streams;
$posts = Streams::entries('posts')->where('published', true)->get();

// ✅ Clean
$posts = entries('posts')->where('published', true)->get();
```

### Type Hints for IDE Support

```php
use Streams\Core\Stream\Stream;
use Streams\Core\Repository\Repository;
use Streams\Core\Criteria\Criteria;

/** @var Stream $stream */
$stream = stream('posts');

/** @var Repository $repository */
$repository = repository('posts');

/** @var Criteria $criteria */
$criteria = entries('posts');
```

### Consistent Usage

Stick to helpers throughout your codebase for consistency:

```php
// Consistent helper usage
class PostService
{
    public function getPublished()
    {
        return entries('posts')
            ->where('published', true)
            ->get();
    }
    
    public function create(array $data)
    {
        return repository('posts')->create($data);
    }
    
    public function findBySlug(string $slug)
    {
        return repository('posts')->findBy('slug', $slug);
    }
}
```

### Use in Tests

Helpers work great in tests:

```php
public function test_can_create_post()
{
    $post = repository('posts')->create([
        'title' => 'Test Post',
        'content' => 'Test content',
    ]);
    
    $this->assertNotNull($post->id);
    $this->assertEquals('Test Post', $post->title);
}

public function test_can_query_published_posts()
{
    $count = entries('posts')
        ->where('published', true)
        ->count();
    
    $this->assertGreaterThan(0, $count);
}
```

## Quick Reference

| Helper | Returns | Purpose |
|--------|---------|---------|
| `stream($handle)` | `Stream` | Get stream instance |
| `entries($handle)` | `Criteria` | Query stream entries |
| `repository($handle)` | `Repository` | Get repository instance |
| `response_time($precision)` | `float` | Request response time in seconds |
| `memory_usage($precision)` | `string` | Current memory usage |
| `html_attributes($array)` | `string` | Convert array to HTML attributes |

## Next Steps

- **[Streams](/docs/core/streams)** - Learn about stream configuration
- **[Entries](/docs/core/entries)** - Working with entry data
- **[Repositories](/docs/core/repositories)** - Query and data manipulation
