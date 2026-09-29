---
title: 'Core: Streams'
nav_title: Streams
description: 'Stream JSON schema — fields, extends, imports, routes, and config.'
section: packages
package: core
order: 40
tags: [core, streams]
status: ready
---

A **stream** is a domain model defined in JSON under `streams/`. Core loads definitions at boot and exposes them through the `Streams` facade.

## Stream file structure

```json
{
    "id": "posts",
    "name": "Posts",
    "description": "Blog posts",
    "extends": "base_content",
    "config": {
        "source": {
            "type": "filebase",
            "format": "json"
        },
        "cache": { "enabled": false }
    },
    "fields": [
        { "handle": "title", "type": "string", "required": true },
        { "handle": "body", "type": "string" }
    ],
    "routes": [
        {
            "uri": "blog/{id}",
            "view": "posts.show",
            "defer": true
        }
    ]
}
```

| Key | Purpose |
|-----|---------|
| `id` | Stream handle (used in `Streams::make('posts')`) |
| `extends` | Merge fields and config from a parent stream |
| `config` | Source, repository, cache, abstract entry class |
| `fields` | Field definitions (array or shorthand map) |
| `routes` | Stream-managed Laravel routes |

## Field shorthand

Fields can be a map of handle → type string:

```json
{
    "fields": {
        "title": "string",
        "published": "boolean"
    }
}
```

Or full objects with `handle`, `type`, `required`, `unique`, `protected`, and `rules`.

## `@` imports

Values starting with `@` load JSON from a project path:

```json
{
    "fields": "@streams/fields/common.json"
}
```

Imports resolve with `base_path()` — only JSON files are supported for `@` imports.

## Abstract streams

Set `config.abstract: true` for streams that define shared fields but are not instantiated directly. Child streams use `extends`.

## Meta-stream

Stream definitions themselves are entries in the stream identified by `config('streams.core.streams_id')` (default `streams`). The `streams` stream uses a self or file source depending on your project layout.

## Accessing streams

```php
$stream = Streams::make('posts');
$stream->fields();
$stream->repository();
$stream->entries(); // returns Criteria
```

## Related

- [Fields](/docs/core/fields)
- [Routes](/docs/core/routes)
- [Sources and adapters](/docs/core/sources-and-adapters)
- [Hub: Streams concept](/docs/streams)
