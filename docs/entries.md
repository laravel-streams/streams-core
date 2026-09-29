---
title: Entries
nav_title: Entries
description: Entry lifecycle, attributes, factory, save/delete, and protected fields.
section: packages
package: core
order: 70
tags: [core, entries]
status: ready
---

An **entry** is a single record in a stream. Entries are instances of `Streams\Core\Entry\Entry` or a custom class set in stream `config.abstract`.

## Creating entries

**Persist immediately** via repository or criteria:

```php
$post = Streams::repository('posts')->create([
    'title' => 'Hello',
]);
// create() calls save() internally
```

**In-memory only** via factory (defaults applied, not saved):

```php
$post = Streams::make('posts')->factory()->create(['title' => 'Draft']);
$post->save();
```

Factory batch helpers: `collect($count)`, `state($callback)`.

## Reading and updating

```php
$post = Streams::entries('posts')->find('my-post');
$post->title = 'Updated';
$post->save();
```

## Deleting

```php
$post->delete();
```

## Validation

Validation is **opt-in**. Core does not validate automatically on save:

```php
$post->validator()->validate();
$post->save();
```

See [Validation](/docs/core/validation).

## Protected fields

Fields with `"protected": true` are excluded from serialization:

```php
$post->toArray(); // omits protected fields
```

## Callbacks

Entry lifecycle hooks use Core callbacks (not Laravel events): `creating`, `created`, `saving`, `saved`, `deleting`. See [Callbacks](/docs/core/callbacks).

## Related

- [Repositories](/docs/core/repositories)
- [Validation](/docs/core/validation)
- [Field decorators](/docs/core/field-decorators)
