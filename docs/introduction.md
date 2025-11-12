---
title: Introduction
sort: 0
stage: review
enabled: 1
---

# Streams Core

Streams Core is a powerful, domain-driven application platform for Laravel that lets you build data-centric applications using simple configuration files instead of writing repetitive boilerplate code.

## What is Streams?

Streams provides a cohesive system for defining, managing, and interacting with your application's data structures. Think of it as a layer on top of Laravel that eliminates the need to manually create models, migrations, controllers, and repositories for every data type in your application.

Instead of writing code, you **configure streams** — simple JSON or YAML files that describe your data structures. Streams handles the rest automatically.

## Key Concepts

### Streams
A **Stream** is a definition of a data structure. It's similar to a database table or an Eloquent model, but defined entirely through configuration. Each stream defines fields, data sources, validation rules, and behavior.

### Entries
An **Entry** is an instance of a stream — a single record. If a stream is like a model, an entry is like a model instance. Entries are the actual data you create, read, update, and delete.

### Repositories
**Repositories** provide a clean interface for querying and manipulating entries. They abstract away data source details, whether you're using files, databases, or custom sources.

### Fields
**Fields** define the properties of your entries with built-in types like string, integer, email, image, relationship, and more. Each field type provides validation, casting, and processing logic.

## Why Use Streams?

### Fast Development
Define your data structures in minutes with simple JSON/YAML files instead of writing models, migrations, and repositories.

### Flexibility
Easily switch between data sources (files, database, collections) without changing your application code.

### Consistency
All your data follows the same patterns and conventions, making your codebase more maintainable.

### Power
Built on Laravel's foundation with support for validation, events, relationships, Scout search integration, and more.

## Quick Example

Define a stream in `streams/posts.json`:

```json
{
    "name": "Posts",
    "fields": {
        "title": "string",
        "slug": "slug",
        "content": "text",
        "published": "boolean",
        "author": {
            "type": "relationship",
            "related": "users"
        }
    }
}
```

Then use it immediately in your code:

```php
use Streams\Core\Support\Facades\Streams;

// Create a new post
$post = Streams::repository('posts')->create([
    'title' => 'My First Post',
    'content' => 'Hello, world!',
    'published' => true,
]);

// Query posts
$posts = Streams::entries('posts')
    ->where('published', true)
    ->orderBy('created_at', 'desc')
    ->get();

// Access entry data
echo $post->title; // "My First Post"
$post->author; // Related user entry
```

No models. No migrations. No repositories to write. Just configuration and clean code.

## What's Next?

- **[Installation](/docs/core/installation)** - Get Streams Core set up in your Laravel application
- **[Streams](/docs/core/streams)** - Learn how to define and configure streams
- **[Entries](/docs/core/entries)** - Working with entry data
- **[Repositories](/docs/core/repositories)** - Querying and data manipulation
- **[Fields](/docs/core/fields)** - Available field types and configuration

## Requirements

- PHP 8.0 or higher
- Laravel 10, 11, or 12

## Support

- GitHub: [laravel-streams/streams-core](https://github.com/laravel-streams/streams-core)
- Issues: [Report bugs or request features](https://github.com/laravel-streams/streams-core/issues)
