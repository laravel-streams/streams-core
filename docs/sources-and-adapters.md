---
title: Sources and adapters
nav_title: Sources and adapters
description: filebase, file, self, database, eloquent, collection, and filesystem adapters.
section: packages
package: core
order: 100
tags: [core, sources, adapters]
status: ready
---

Each stream's `config.source.type` selects a **repository adapter** that reads and writes entries. Core resolves the adapter in `Streams\Core\Repository\Repository`.

## Adapter types

| Type | Adapter | Typical config |
|------|---------|----------------|
| `filebase` | `FilebaseAdapter` | `path`, `format` (json, yaml, md, html) |
| `file` | `FileAdapter` | `path` (single file) |
| `self` | `SelfAdapter` | entries in stream JSON `data` array |
| `database` | `DatabaseAdapter` | `table`, `connection` |
| `eloquent` | `EloquentAdapter` | `model` (Eloquent class) |
| `collection` | `CollectionAdapter` | `data` (inline array) |
| `filesystem` | `FilesystemAdapter` | `disk` (Laravel Storage disk) |
| `elasticsearch` | `ElasticsearchAdapter` | `index` (default: stream ID), `search_fields`, `scout_prefix`. Requires `elasticsearch/elasticsearch`. |
| `opensearch` | `OpenSearchAdapter` | `index`, `search_fields`, `scout_prefix`; connections in `streams.core.opensearch`. Requires `opensearch-project/opensearch-php`. |

Default type comes from `config('streams.core.default_source')` (`filebase`).

## Filebase (most common)

```json
{
    "config": {
        "source": {
            "type": "filebase",
            "format": "md"
        }
    }
}
```

Entries live under `config('streams.core.data_path')` in a directory named for the stream handle unless `path` is set.

## Self source

Used when entries are embedded in the stream definition:

```json
{
    "config": { "source": { "type": "self" } },
    "data": [
        { "id": "one", "title": "First" }
    ]
}
```

## Eloquent

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

## Custom adapter

Set `config.adapter` to a fully qualified adapter class, or `config.criteria` for a custom criteria class. See [Extending Core](/docs/core/extending-core).

## Related

- [Streams](/docs/core/streams)
- [Configuration](/docs/core/configuration)
- [Hub: Databases](/docs/databases)
