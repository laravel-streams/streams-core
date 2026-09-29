---
title: Field decorators
nav_title: Field decorators
description: 'Decorate entry field values for display — markdown, HTML, and type decorators.'
section: packages
package: core
order: 60
tags: [core, field, decorators]
status: ready
---

Field decorators transform raw stored values into display-ready output. Call `$entry->decorate()` to apply type-specific decorators registered on field types.

## When to use decorators

Use decorators in views when you need formatted output (rendered markdown, humanized dates) without mutating the stored value.

## Basic usage

```php
$html = $entry->decorate('body');
```

Each field type may register a decorator that knows how to format its value. String fields with markdown configuration return parsed HTML through the decorator pipeline.

## Protected fields

Fields marked `protected: true` are omitted from `toArray()` and `toJson()` but remain accessible on the entry object and through `decorate()` when authorized.

```json
{ "handle": "internal_notes", "type": "string", "protected": true }
```

## Related

- [Fields](/docs/core/fields)
- [Entries](/docs/core/entries)
- [Views and includes](/docs/core/views-and-includes)
