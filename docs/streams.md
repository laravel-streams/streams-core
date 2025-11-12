---
title: Streams
sort: 2
stage: review
enabled: 1
---

# Streams

Streams are the foundation of Streams Core. A stream is a definition of a data structure — like a model or table — but configured entirely through JSON or YAML files.

## What is a Stream?

Think of a stream as a blueprint for your data. It defines:

- **Fields** - What properties your data has (name, email, price, etc.)
- **Data Source** - Where data is stored (files, database, memory, etc.)
- **Validation** - Rules for data integrity
- **Behavior** - Routes, abstract classes, and custom logic

Unlike traditional models, streams require no PHP classes, migrations, or boilerplate code.

## Creating a Stream

Create stream definition files in your `streams/` directory.

### Basic Example

**streams/posts.json:**

```json
{
    "name": "Posts",
    "description": "Blog posts for the website",
    "fields": {
        "title": "string",
        "slug": "slug",
        "content": "text",
        "published": "boolean",
        "published_at": "datetime"
    }
}
```

That's it! The stream is now available throughout your application.

### YAML Format

You can also use YAML:

**streams/posts.yaml:**

```yaml
name: Posts
description: Blog posts for the website
fields:
  title: string
  slug: slug
  content: text
  published: boolean
  published_at: datetime
```

## Stream Configuration

Streams support extensive configuration options.

### Complete Example

```json
{
    "name": "Posts",
    "handle": "posts",
    "description": "Blog posts for the website",
    
    "config": {
        "key_name": "id",
        "source": {
            "type": "filebase",
            "path": "streams/data/posts",
            "format": "json"
        },
        "abstract": "App\\Posts\\Post"
    },
    
    "fields": {
        "id": {
            "type": "uuid",
            "required": true
        },
        "title": {
            "type": "string",
            "required": true,
            "rules": ["max:200"]
        },
        "slug": {
            "type": "slug",
            "unique": true
        },
        "content": {
            "type": "text",
            "required": true
        },
        "author": {
            "type": "relationship",
            "related": "users"
        },
        "published": {
            "type": "boolean",
            "default": false
        },
        "published_at": {
            "type": "datetime"
        }
    },
    
    "routes": [
        {
            "uri": "posts/{id}",
            "view": "posts.show"
        }
    ]
}
```

## Configuration Options

### Basic Properties

| Property | Type | Description |
|----------|------|-------------|
| `name` | string | Human-readable name for the stream |
| `handle` | string | Unique identifier (defaults to filename) |
| `description` | string | Description of the stream's purpose |

### Config Object

The `config` object controls stream behavior:

```json
{
    "config": {
        "key_name": "id",
        "source": {
            "type": "filebase",
            "path": "streams/data/posts",
            "format": "json"
        },
        "abstract": "App\\Posts\\Post",
        "repository": "App\\Posts\\PostRepository"
    }
}
```

#### Config Properties

| Property | Type | Description |
|----------|------|-------------|
| `key_name` | string | Primary key field name (default: "id") |
| `source` | object | Data source configuration |
| `abstract` | string | Custom entry class to use |
| `repository` | string | Custom repository class to use |
| `factory` | string | Custom factory class to use |

## Data Sources

Streams can store data in multiple ways. Configure via the `source` property.

### Filebase (Default)

Store entries as JSON files:

```json
{
    "config": {
        "source": {
            "type": "filebase",
            "path": "streams/data/posts",
            "format": "json"
        }
    }
}
```

### File

Store all entries in a single JSON file:

```json
{
    "config": {
        "source": {
            "type": "file",
            "path": "streams/data/posts.json",
            "format": "json"
        }
    }
}
```

### Database

Use Laravel's database:

```json
{
    "config": {
        "source": {
            "type": "database",
            "table": "posts",
            "connection": "mysql"
        }
    }
}
```

### Eloquent

Integrate with existing Eloquent models:

```json
{
    "config": {
        "source": {
            "type": "eloquent",
            "model": "App\\Models\\Post"
        }
    }
}
```

### Collection

Store in-memory (useful for configuration):

```json
{
    "config": {
        "source": {
            "type": "collection",
            "data": [
                {"id": 1, "name": "Option 1"},
                {"id": 2, "name": "Option 2"}
            ]
        }
    }
}
```

## Fields

Fields define the structure of your entries. See the [Fields documentation](/docs/core/fields) for detailed information.

### Short Syntax

For simple fields, just specify the type:

```json
{
    "fields": {
        "title": "string",
        "published": "boolean",
        "count": "integer"
    }
}
```

### Long Syntax

For advanced configuration:

```json
{
    "fields": {
        "title": {
            "type": "string",
            "required": true,
            "rules": ["max:200"],
            "default": "Untitled"
        }
    }
}
```

## Routes

Streams can automatically register Laravel routes:

```json
{
    "routes": [
        {
            "uri": "posts",
            "view": "posts.index"
        },
        {
            "uri": "posts/{id}",
            "view": "posts.show"
        }
    ]
}
```

### Route Options

| Option | Type | Description |
|--------|------|-------------|
| `uri` | string | Route URI pattern |
| `view` | string | View to render |
| `handle` | string | Route name |
| `defer` | boolean | Whether to defer loading |

## Using Streams

### Getting a Stream Instance

```php
use Streams\Core\Support\Facades\Streams;

$stream = Streams::make('posts');

// Get stream properties
echo $stream->name;        // "Posts"
echo $stream->description; // "Blog posts for the website"
```

### Accessing Fields

```php
$fields = $stream->fields;

foreach ($fields as $field) {
    echo $field->handle;  // Field name
    echo $field->type;    // Field type
}
```

### Getting a Repository

```php
$repository = $stream->repository();

$posts = $repository->all();
$post = $repository->find(1);
```

### Querying Entries

```php
$entries = $stream->entries()
    ->where('published', true)
    ->orderBy('published_at', 'desc')
    ->limit(10)
    ->get();
```

## Custom Entry Classes

Extend entry functionality by creating a custom class:

**app/Posts/Post.php:**

```php
<?php

namespace App\Posts;

use Streams\Core\Entry\Entry;

class Post extends Entry
{
    public function excerpt(int $length = 100): string
    {
        return Str::limit(strip_tags($this->content), $length);
    }
    
    public function isPublished(): bool
    {
        return $this->published && 
               $this->published_at?->isPast();
    }
}
```

Reference it in your stream:

```json
{
    "config": {
        "abstract": "App\\Posts\\Post"
    }
}
```

Now all entries use your custom class:

```php
$post = Streams::repository('posts')->first();
echo $post->excerpt(50);  // Custom method
```

## Custom Repository Classes

Create custom repository methods:

**app/Posts/PostRepository.php:**

```php
<?php

namespace App\Posts;

use Streams\Core\Repository\Repository;

class PostRepository extends Repository
{
    public function published()
    {
        return $this->newCriteria()
            ->where('published', true)
            ->where('published_at', '<=', now());
    }
    
    public function byAuthor(string $authorId)
    {
        return $this->newCriteria()
            ->where('author_id', $authorId);
    }
}
```

Reference in stream:

```json
{
    "config": {
        "repository": "App\\Posts\\PostRepository"
    }
}
```

Use custom methods:

```php
$posts = Streams::repository('posts')->published()->get();
$authorPosts = Streams::repository('posts')->byAuthor($authorId)->get();
```

## Registering Streams Programmatically

You can also register streams in PHP:

```php
use Streams\Core\Support\Facades\Streams;

Streams::register([
    'handle' => 'pages',
    'name' => 'Pages',
    'fields' => [
        'title' => 'string',
        'content' => 'text',
    ],
]);
```

## Helper Functions

Convenient helpers for working with streams:

```php
// Get stream instance
$stream = stream('posts');

// Query entries
$posts = entries('posts')->where('published', true)->get();

// Get repository
$repository = repository('posts');
```

## Best Practices

### Naming Conventions

- Use **lowercase, plural** handles: `posts`, `pages`, `products`
- Keep file names matching handles: `posts.json` for handle "posts"
- Use descriptive names: "Blog Posts" not just "Posts"

### Organization

```
streams/
├── content/
│   ├── posts.json
│   └── pages.json
├── users/
│   └── profiles.json
└── shop/
    ├── products.json
    └── orders.json
```

### Data Sources

- **Filebase**: Great for content, configuration, small datasets
- **Database**: Large datasets, relational data, high-performance needs
- **Eloquent**: Integrating with existing Laravel models
- **Collection**: Static data, options, constants

### Performance

- Cache stream instances when possible
- Use appropriate data sources for your data size
- Index fields for better query performance (database sources)

## Next Steps

- **[Entries](/docs/core/entries)** - Learn how to create and work with entry data
- **[Repositories](/docs/core/repositories)** - Query and manipulate entries
- **[Fields](/docs/core/fields)** - Explore available field types
