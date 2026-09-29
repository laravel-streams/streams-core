---
title: 'Core: Fields'
nav_title: Fields
description: Field handles, rules, shorthands, and registered types from core.php.
section: packages
package: core
order: 50
tags: [core, fields]
status: ready
---

Fields define entry attributes on a stream. Each field has a **handle**, **type**, and optional validation, defaults, and UI input config.

## Definition formats

**Shorthand map:**

```json
{
    "fields": {
        "title": "string",
        "published": "boolean"
    }
}
```

**Full object** (list form):

```json
{
    "fields": [
        {
            "handle": "slug",
            "type": "slug",
            "required": true,
            "unique": true,
            "rules": ["alpha_dash"],
            "protected": false
        }
    ]
}
```

**Import:** the whole `fields` value, or any one field, can be `"@path/to/file.json"`. Core replaces it with the decoded JSON file (relative to the app root) when it builds the stream:

```json
{
    "fields": {
        "title": "string",
        "seo": "@streams/fields/seo.json"
    }
}
```

## Common field options

| Option | Purpose |
|--------|---------|
| `required` | Adds required validation rule |
| `unique` | Unique within stream (via StreamsPresenceVerifier) |
| `rules` | Additional Laravel validation rules |
| `protected` | Omit from `toArray()` / `toJson()` |
| `config.default` | Default value via factory |
| `input` | Admin UI hints (used by Streams UI) |

## Registered types

From `config/streams/core.php` `field_types`:

| Category | Types |
|----------|-------|
| Numbers | `number`, `integer`, `decimal` |
| Strings | `string`, `url`, `uuid`, `hash`, `slug`, `email`, `encrypted` |
| Boolean | `boolean` |
| Dates | `datetime`, `date`, `time` |
| Selection | `enum`, `select`, `multiselect` |
| Structured | `array`, `object` |
| Relations | `relationship`, `polymorphic` |
| Media | `file`, `image` |
| Other | `color` |

`enum` is an alias of `select`. There is no `text`, `textarea`, `markdown`, `html`, or `multiple` type. Use `string` with an `input` hint (for example `{"type": "textarea"}`) for long content, `multiselect` for several options, and `"multiple": true` in a relationship's `config` for several related entries.

## Type-specific config

These are the `config` keys Core reads. Put them inside `config`, never next to `type`.

| Type | Key | Meaning |
|------|-----|---------|
| `relationship` | `related` (required) | Related stream ID |
| `relationship` | `multiple`, `key_name`, `relation` | Store a list of keys; related key field (default `id`); relation name for eager loading (default: handle without `_id`) |
| `select`, `enum`, `multiselect` | `options` (required) | Object of value => label, or a list of values |
| `array` | `items` | List of allowed item types, each `{"type": "..."}`; `enforce_items: false` skips the check |
| `array` | `stream`, `related` | Cast items to entries of a stream (ID or inline definition) or look them up by key |
| `array`, `object` | `wrapper` | Class used to wrap the value |
| `object` | `allowed` | List of `{"stream": ...}`, `{"generic": ...}`, or `{"prototype": ...}` objects |
| `polymorphic` | `related` | Optional list of expected stream IDs (not enforced) |
| `uuid` | `default: true` | Generate a UUID when missing |
| `slug` | `separator` | Word separator (default `-`) |
| `decimal` | `precision` | Decimal places |
| `date`, `datetime`, `time` | `format`, `timezone` | Storage format; timezone (default `app.timezone`) |
| `color` | `format` | Default decorator output (`hex`) |

Examples of every type are in [Field types](/docs/fields#field-types). The [stream definition schema](/docs/sdk/stream-schema) checks these shapes.

## Accessing values

```php
$entry->title;
$entry->setAttribute('title', 'Hello');
$entry->decorate('body'); // formatted output
```

## Related

- [Field decorators](/docs/core/field-decorators)
- [Validation](/docs/core/validation)
- [Hub: Fields](/docs/fields)
