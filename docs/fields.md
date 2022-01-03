---
title: Fields
category: core_concepts
intro:
enabled: true
sort: 10
---

## Introduction

Fields represent the type and characteristics of your stream data. For example a "name" field would likely be a **string** field type.

Fields are strictly concerned with data. Please see the [UI package](../ui/introduction) for configuring field [inputs](../ui/inputs).

## Defining Fields

Fields can be defined within the JSON [configuration for your streams](streams#defining-streams). You can get started by simply defining fields by `handle` and their `type` respectively.

#### Basic Example

```json
// streams/contacts.json
{
    "fields": [
        {
            "handle": "title",
            "type": "string"
        }
    ]
}
```

#### Full Example

To define more information about the field use an array:

```json
// streams/contacts.json
{
    "fields": [
        {
            "handle": "title",
            "type": "string",
            "rules": ["min:4"]
        }
    ]
}
```

### Field Validation

Define [Laravel validation rules](https://laravel.com/docs/validation#available-validation-rules) for fields and they will be merged the [stream validation rules](streams#stream-validation).

```json
// streams/contacts.json
{
    "fields": [
        {
            "handle": "name",
            "type": "string",
            "rules": ["required", "max:100"]
        },
        {
            "handle": "email",
            "type": "email",
            "rules": ["required", "email:rfc,dns"]
        },
        {
            "handle": "company",
            "type": "string",
            "rules": ["required", "unique"]
        }
    ]
}
```

## Field Types

The field **type** is responsible for validating, casting, and more for its specific data type.

@foreach (Streams::entries('docs_core')->where('category', 'field_types')->orderBy('sort', 'ASC')->orderBy('name', 'ASC')->get() as $entry)
 - <a href="{{ $entry->id }}">{{ $entry->title }}</a>
@endforeach

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
        "related": "stream"
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
        "path": "storage::uploads.img"
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
