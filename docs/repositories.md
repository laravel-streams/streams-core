---
title: Repositories
nav_title: Repositories
description: 'Repository CRUD API — repository() vs entries() and available methods.'
section: packages
package: core
order: 80
tags: [core, repositories]
status: ready
---

Repositories provide direct CRUD access to stream entries through `Streams\Core\Repository\Repository`.

## repository() vs entries()

| API | Returns | Use for |
|-----|---------|---------|
| `Streams::repository('posts')` | `Repository` | find, create, save, delete by id |
| `Streams::entries('posts')` | `Criteria` | Query chains (where, orderBy, paginate) |

Both operate on the same underlying adapter. Prefer `entries()` when filtering; prefer `repository()` for single-record CRUD.

```php
$repo = Streams::repository('posts');
$post = $repo->find('hello-world');

Streams::entries('posts')->where('published', true)->get();
```

## Repository methods

| Method | Purpose |
|--------|---------|
| `all()` | All entries |
| `find($id)` | Entry by key or null |
| `findBy($field, $value)` | First match |
| `findAllWhere($field, $value)` | Collection of matches |
| `count()` | Entry count |
| `create($attributes)` | Create and persist |
| `save($entry)` | Persist changes |
| `delete($entry)` | Remove entry |
| `truncate()` | Remove all entries |
| `newInstance($attributes)` | Unsaved entry |
| `newCriteria()` | Fresh criteria instance |

## Not available

These methods do **not** exist on Repository:

- `createMany()` — create entries in a loop or use criteria
- `paginate()` — use `Streams::entries('posts')->paginate()`
- `update()` — mutate the entry object and call `save()`

## Custom repositories

Bind a custom class in stream config:

```json
{
    "config": {
        "repository": "App\\Streams\\PostRepository"
    }
}
```

See [Extending Core](/docs/core/extending-core).

## Related

- [Criteria](/docs/core/criteria)
- [Entries](/docs/core/entries)
