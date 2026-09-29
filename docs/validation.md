---
title: Validation
nav_title: Validation
description: Manual validator() usage, field rules, and StreamsPresenceVerifier.
section: packages
package: core
order: 120
tags: [core, validation]
status: ready
---

Core validation is **opt-in**. Saving an entry does not run validation automatically — call `validate()` when your application requires it.

## Entry validation

```php
$post = Streams::repository('posts')->newInstance([
    'title' => '',
]);

$post->validator()->validate(); // throws ValidationException on failure
$post->save();
```

## Stream validator

Build a validator from raw data:

```php
$validator = Streams::make('posts')->validator([
    'title' => 'Hello',
], $existingId);

$validator->validate();
```

Rules come from field definitions (`required`, `unique`, custom `rules` arrays) and stream-level `rules`.

## Unique rules

`Streams\Core\Validation\StreamsPresenceVerifier` routes `unique` and `exists` rules through the stream's criteria adapter so uniqueness is checked against stream entries, not arbitrary database tables.

## Field rules

Fields map JSON flags to Laravel rule strings during stream build:

```json
{ "handle": "slug", "type": "slug", "required": true, "unique": true }
```

Add explicit rules:

```json
{ "handle": "title", "type": "string", "rules": ["max:255"] }
```

## Related

- [Entries](/docs/core/entries)
- [Fields](/docs/core/fields)
