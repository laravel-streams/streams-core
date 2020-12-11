---
title: Fields
category: core_concepts
intro:
enabled: true
sort: 10
---

## Introduction

Fields represent the type and characteristics of your stream data. For example a "name" field would likely be a **string** field __type__.

Fields are strictly concerned with data. Please see the [UI package](../ui/introduction) for configuring field [inputs](../ui/inputs).

## Defining Fields

Fields can be defined within the JSON [configuration for your streams](streams#defining-streams). You can get started by simply defining fields by `handle` and their `type` respectively.

```json
// streams/contacts.json
{
    "fields": {
        "name": "string",
    }
}
```

To define more information about the field use an array:

```json
// streams/contacts.json
{
    "fields": {
        "name": {
            "type": "string",
            "name": "fields.name"
        },
    }
}
```

### Field Validation

Define **rules** and **validators** for fields to merge them with other [stream validation](streams#stream-validation).

```json
// streams/contacts.json
{
    "rules": {
        "name": [
            "required",
            "max:100"
        ],
        "email": [
            "required",
            "email:rfc,dns"
        ],
        "company": "required|unique"
    }
}
```

## Field Types

The field **type** is responsible for validating and casting its specific data type.

### String

The `string` field type stores a string value. Other string-like fields may extend the string type.

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
        $fieldType->config['options'] = [
            // Your options
        ];
    }
}
```

### Array

The `array` field type stores array values.

```json
{
    "type": "array",
    "config": {
        "format": "json" // json|yaml
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

### Boolean
### Integer
### Datetime
### Date
### Time
### Entry
### Entries
### Polymorphic
### Relationship
### Multiple
### Image
### Collection
### Template
