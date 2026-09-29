---
title: 'Core: Caching'
nav_title: Caching
description: Per-stream cache config, criteria cache(), fresh(), and flush on writes.
section: packages
package: core
order: 110
tags: [core, caching]
status: ready
---

Core caches criteria results per stream when enabled. Cache keys are prefixed with `streams.{handle}.` via `Streams\Core\Stream\StreamCache`.

## Stream config

```json
{
    "config": {
        "cache": {
            "enabled": true,
            "ttl": 3600,
            "store": "redis"
        }
    }
}
```

| Key | Purpose |
|-----|---------|
| `enabled` | Auto-cache `get()` and `count()` on criteria |
| `ttl` | Default seconds for query cache |
| `store` | Laravel cache store name |

## Query cache

```php
// Explicit TTL and optional key
Streams::entries('posts')->cache(600, 'posts.published')->get();

// Bypass cache for one query
Streams::entries('posts')->fresh()->get();
```

## Stream-level remember

```php
Streams::make('posts')->cache()->remember('meta', 3600, fn () => ...);
```

## Flush behavior

These operations flush the stream cache:

- `Criteria::create()`
- `$entry->save()` through criteria/repository
- `$entry->delete()`
- `truncate()`

## Related

- [Criteria](/docs/core/criteria)
- [Hub: Caching](/docs/caching)
