---
title: Fields
category: core_concepts
intro:
enabled: true
sort: 10
---

## Introduction

Fields represent the type and characteristics of your stream data. For example a "name" field would likely be a **string** field **type**.

Fields are strictly concerned with data. Please see the [UI package](../ui/introduction) for configuring field [inputs](../ui/inputs).

## Defining Fields

Fields can be defined within the JSON [configuration for your streams](streams#defining-streams). You can get started by simply defining fields by `handle` and their `type` respectively.

```json
// streams/contacts.json
{
    "fields": {
        "title": "string"
    }
}
```

To define more information about the field use an array:

```json
// streams/contacts.json
{
    "fields": {
        "title": {
            "type": "string",
            "rules": ["min:3"]
        }
    }
}
```

### Field Validation

Define [Laravel validation rules](https://laravel.com/docs/validation#available-validation-rules) for fields and they will be merged the [stream validation rules](streams#stream-validation).

```json
// streams/contacts.json
{
    "fields": {
        "name": {
            "rules": ["required", "max:100"]
        },
        "email": {
            "rules": ["required", "email:rfc,dns"]
        },
        "company": {
            "rules": ["required", "unique"]
        }
    }
}
```

Is the same as:

```json
// streams/contacts.json
{
    "rules": {
        "name": ["required", "max:100"],
        "email": ["required", "email:rfc,dns"],
        "company": "required|unique"
    }
}
```

## Field Types

The field **type** is responsible for validating, casting, and more for its specific data type.

### String

The `string` field type stores a string value.

```json
{
    "type": "string"
}
```

### URL

The `url` field type stores a URL or named route.

```json
{
    "type": "url"
}
```

### Hash

The `hash` field type stores a one-way hashed string.

```json
{
    "type": "hash"
}
```

### Encrypted

The `encrypted` field type stores a two-way encrypted string.

```json
{
    "type": "encrypted"
}
```

### Markdown

The `markdown` field type stores markdown formatted text.

```json
{
    "type": "markdown"
}
```

### Select

The `select` field type stores a selection from a list of options.

```json
{
    "type": "select",
    "config": {
        "options": {
            "first": "First Option",
            "second": "Second Option"
        }
    }
}
```

#### Callable Options

Besides basic array and associated arrays, you may specify a callable:

```json
{
    "type": "select",
    "config": {
        "options": "\\App\\CustomOptions@handle"
    }
}
```

The `$fieldType` can then be injected in order to set the `config.options` manually:

```php
// app/CustomOptions.php
class CustomOptions
{
    public function handle($fieldType)
    {
        return [
            // ...
        ];
    }
}
```

### Multiselect

The `multiselect` field type stores an array of selections from a list of options. The multiselect field type also supports [callable options](#callable-options).

```json
{
    "type": "multiselect",
    "config": {
        "options": {
            "first": "First Option",
            "second": "Second Option",
            "third": "Third Option"
        }
    }
}
```

### Array

The `array` field type stores array values.

```json
{
    "type": "array"
}
```

### Boolean

The `boolean` field type stores true/false values.

```json
{
    "type": "boolean"
}
```

### Integer

The `integer` field type stores whole number values.

```json
{
    "type": "integer"
}
```

### Decimal

The `decimal` field type stores decimal number values.

```json
{
    "type": "decimal"
}
```

### Datetime

The `datetime` field type stores both date and time.

```json
{
    "type": "datetime"
}
```

### Date

The `datetime` field type stores only date.

```json
{
    "type": "date"
}
```

### Time

The `datetime` field type stores only time.

```json
{
    "type": "time"
}
```

### Entry

```json
{
    "type": "entry",
    "config": {
        "stream": "handle"
    }
}
```

### Entries

```json
{
    "type": "entries",
    "config": {
        "stream": "handle"
    }
}
```

### Object

## Prototype

Single prototype object.

```json
{
    "type": "prototype",
    "config": {
        "abstract": "App\\ExampleClass"
    }
}
```

### Grid

Multiple entries of mixed types.

### Polymorphic

Single entry of mixed type.

```json
{
    "type": "polymorphic"
}
```

### Matrix

Multiple objects of mixed type.

```json
{
    "type": "matrix"
}
```

### Relationship

```json
{
    "type": "relationship",
    "config": {
        "related": "stream",
        "type": "belongsTo|hasOne"
    }
}
```

### Multiple

```json
{
    "type": "multiple",
    "config": {
        "related": "stream"
    }
}
```

### File

```json
{
    "type": "file",
    "config": {
        "path": "storage::uploads"
    }
}
```

### Image

```json
{
    "type": "image",
    "config": {
        "path": "storage::uploads/img"
    }
}
```

### Collection

```json
{
    "type": "collection",
    "config": {
        "abstract": "Illuminate\\Support\\Collection"
    }
}
```

### Template
