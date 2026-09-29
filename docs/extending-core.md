---
title: Extending Core
nav_title: Extending Core
description: Custom adapters, repositories, entries, and field types via config bindings.
section: packages
package: core
order: 230
tags: [core, extending]
status: ready
---

Extend Core by binding custom classes in stream JSON or Laravel service providers.

## Custom field types

Register in `config/streams/core.php`:

```php
'field_types' => [
    'rating' => \App\Streams\Fields\RatingFieldType::class,
],
```

Implement a field type class extending Core's field type base with assignment, validation, and optional decorators.

## Custom repository

```json
{
    "config": {
        "repository": "App\\Streams\\PostRepository"
    }
}
```

Implement `Streams\Core\Repository\Contract\RepositoryInterface` or extend `Repository`.

## Custom entry class

```json
{
    "config": {
        "abstract": "App\\Streams\\PostEntry"
    }
}
```

Subclass `Streams\Core\Entry\Entry` for domain methods on entries.

## Custom adapter

```json
{
    "config": {
        "adapter": "App\\Streams\\Adapters\\ApiAdapter"
    }
}
```

Adapters implement criteria execution for your storage backend.

## Custom criteria class

```json
{
    "config": {
        "criteria": "App\\Streams\\PostCriteria"
    }
}
```

## Service provider bindings

Use Laravel's container in `AppServiceProvider` for cross-cutting bindings:

```php
$this->app->bind(CustomInterface::class, CustomImplementation::class);
```

## Related

- [Configuration](/docs/core/configuration)
- [Sources and adapters](/docs/core/sources-and-adapters)
- [Fields](/docs/core/fields)
