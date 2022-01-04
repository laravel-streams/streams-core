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
            "name": "Title",
            "description": "The title of the film.",
            "type": "string",
            "rules": ["min:4"],
            "config": {
                "default": "Untitled"
            },
            "example": "Star Wars: The Force Awakens"
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
 - <a href="{{ $entry->id }}">{{ $entry->title }} ({{ $entry->expand('stage')->value() }})</a>
@endforeach



### Entry

> Consider removing in favor of the [Object](object) field type.

```json
// streams/users.json
"fields": {
    "profile": {
        "type": "entry",
        "config": {
            "stream": "profiles"
        }
    }
}
```

#### Data Structure

```json
{
    "profile": {
        "first_name": "John",
        "last_name": "Doe",
        "username": "TheRealJohnDoe"
    }
}
```

#### Templating

Basic value access returns the entry instance:

```blade
@verbatim// Basic access
{{ $entry->profile->username }}@endverbatim
```

#### Expanded Value

Expanded values provide the same instance.

```blade
@verbatim// Expanded value
{{ $entry->profile()->username }}@endverbatim
```


### Prototype

Store an abstract object.

> Consider removing in favor of the [Object](object) field type.

```json
// streams/users.json
"fields": {
    "extension": {
        "type": "prototype"
    }
}
```

#### Configuration

@todo Generate config options from class::configuration

```json
// streams/users.json
"fields": {
    "extension": {
        "type": "prototype",
        "config": {
            "abstract": "App\\Addon\\Extension"
        }
    }
}
```

#### Data Structure

```json
{
    "extension": [
        {
            "@type": "App\\Addon\\Extension",
            "name": "Example Extension"
        }
    ]
}
```

#### Templating

Basic value access returns the instance:

```blade
@verbatim// Basic access
{{ $entry->permissions->first()->info }}@endverbatim
```

#### Expanded Value

Expanded values provide the same instance.

```blade
@verbatim// Expanded value
{{ $entry->permissions()
    ->pluck('key')
    ->implode(',t ') }}@endverbatim
```



### Entries

Store an array of stream entries.

> Consider removing in favor of the [Array](array) field type.

```json
// streams/users.json
"fields": {
    "addresses": {
        "type": "entries",
        "config": {
            "stream": "addresses"
        }
    }
}
```

#### Data Structure

```json
{
    "addresses": [
        {
            "label": "Home",
            "street": "3159 W 11th St",
            "city": "Cleveland",
            "state": "OH",
            "country": "US"
        },
        {
            "label": "School",
            "street": "173 Niagara St",
            "city": "St. Catharines",
            "state": "ON",
            "city": "CA"
        }
    ]
}
```

#### Templating

Basic value access returns the entry collection:

```blade
@verbatim// Basic access
{{ $entry->addresses->first()->street }}@endverbatim
```

#### Expanded Value

Expanded values provide the same collection.

```blade
@verbatim// Expanded value
{{ $entry->addresses()
    ->pluck('label')
    ->implode(', ') }}@endverbatim
```


### Grid

Multiple entries of mixed types.

> Consider removing in favor of the [Array](array) field type.

```json
// streams/users.json
"fields": {
    "content": {
        "type": "grid"
    }
}
```

## Data Structure

```json
{
    "content": [
        {
            "stream": "banner",
            "data": {
                // ...
            }
        }
    ]
}
```

#### Templating

Basic value access displays the entry collection:

```blade
@verbatim// Basic access
{{ $entry->content->count() }}@endverbatim
```

#### Expanded Value

The expanded value also provides the same collection.

```blade
@verbatim// Expanded value
{{ $entry->content()->count() }}@endverbatim
```


### Matrix

Multiple objects of mixed type.

> Consider removing in favor of the [Array](array) field type.

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

> Consider removing in favor of the [Array](array) field type w/collection configuration.

```json
{
    "type": "collection",
    "config": {
        "abstract": "Illuminate\\Support\\Collection"
    }
}
```
