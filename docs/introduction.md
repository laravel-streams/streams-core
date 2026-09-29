---
title: 'Core: Introduction'
nav_title: Introduction
description: JSON-defined streams, repositories, criteria, and Laravel integration.
section: packages
package: core
order: 10
tags: [core, introduction]
status: ready
---

Streams Core (`streams/core`) is the foundation package for the Streams ecosystem. It provides JSON-defined domain models, repository access, criteria-based queries, stream routing, assets, and images — all integrated with Laravel.

## When to read this page

Start here if you are adding `streams/core` to a Laravel project or need an overview before diving into streams, entries, and repositories.

## Core concepts

| Concept | Class / API | Purpose |
|---------|-------------|---------|
| Stream | `Streams\Core\Stream\Stream` | Domain model defined in JSON |
| Entry | `Streams\Core\Entry\Entry` | Single record in a stream |
| Repository | `Streams::repository()` | CRUD access to entries |
| Criteria | `Streams::entries()` | Query builder for entries |

Streams live in `streams/*.json`. Entry data lives in the configured source (filebase, database, self, etc.).

## Minimal example

```json
{
    "id": "posts",
    "fields": [
        { "handle": "title", "type": "string", "required": true },
        { "handle": "body", "type": "string" }
    ]
}
```

```php
$post = Streams::repository('posts')->create(['title' => 'Hello']);
$post->save();

$posts = Streams::entries('posts')->where('title', 'Hello')->get();
```

## Package boundaries

Core does not include admin UI (see [UI](/docs/ui/introduction)) or REST endpoints (see [API](/docs/api/introduction)). Validation is opt-in — call `$entry->validator()->validate()` before persisting when you need it.

## Related

- [Installation](/docs/core/installation)
- [Streams](/docs/core/streams)
- [Repositories](/docs/core/repositories)
- [Criteria](/docs/core/criteria)
