---
title: Criteria
nav_title: Criteria
description: 'Query API — where, orderBy, paginate, cache, chunk, and adapter forwarding.'
section: packages
package: core
order: 90
tags: [core, criteria]
status: ready
---

`Streams::entries()` returns a `Streams\Core\Criteria\Criteria` instance — a fluent query API executed by the stream's source adapter.

## Basic queries

```php
$posts = Streams::entries('posts')
    ->where('published', true)
    ->orderBy('created_at', 'desc')
    ->get();

$post = Streams::entries('posts')->find('my-slug');
$count = Streams::entries('posts')->where('published', true)->count();
```

## Pagination

```php
$paginator = Streams::entries('posts')->paginate(15);

// Or with options array
$paginator = Streams::entries('posts')->paginate([
    'per_page' => 20,
    'page' => 2,
]);
```

## Cache

When stream `config.cache.enabled` is true, `get()` and `count()` cache automatically. Override per query:

```php
Streams::entries('posts')->cache(600)->get();
Streams::entries('posts')->fresh()->get(); // bypass cache
```

Mutations (`create`, `save`, `delete`, `truncate`) flush the stream cache.

## Chunk

```php
Streams::entries('posts')->chunk(100, function ($entries, $page) {
    foreach ($entries as $entry) {
        // process
    }
});
```

## Upsert helpers

```php
Streams::entries('posts')->firstOrCreate(['slug' => 'hello'], ['title' => 'Hello']);
Streams::entries('posts')->updateOrCreate(['slug' => 'hello'], ['title' => 'Updated']);
```

## Adapter forwarding

Unknown method calls on Criteria forward to the underlying adapter when supported.

## Related

- [Repositories](/docs/core/repositories)
- [Caching](/docs/core/caching)
- [Sources and adapters](/docs/core/sources-and-adapters)
