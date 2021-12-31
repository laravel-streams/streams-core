---
title: Validation
category: database
intro: Organizing and executing data validation rules.
stage: outlining
enabled: true
sort: 11
references:
    - https://laravel.com/docs/validation
---

## Introduction

The Streams platform provides a simple interface to leverage Laravel's own validation. Please make sure you are familiar with basic [Laravel validation](https://laravel.com/docs/validation) before proceeding.

## Defining Rules

The Streams platform leans heavily on native Laravel validation, streamlines the process, and allows flexibility to adjust this behavior entirely.

### Rule Configuration

All Streams rule configurations are defined as an array of rules on the field in which they apply to.

#### Defining Rules

You may define **rules** whithin the [field configuration](fields#defining-fields):

```json
// streams/contacts.json
{
    "fields": {
        "name": {
            "type": "string",
            "rules": ["required", "max:100"]
        },
        "email": {
            "type": "email",
            "rules": ["unique", "required"]
        },
        "company": {
            "type": "relationship",
            "config": {
                "related": "companies"
            },
            "rules": ["required"]
        }
    }
}
```

#### Custom Rules

You may also define [custom validation rules](https://laravel.com/docs/validation#custom-validation-rules) for fields.

```json
// streams/contacts.json
{
    "fields": {
        "name": {
            "type": "string",
            "rules": [
                "required",
                "App\\Rules\\Example"
            ]
        }
    }
}
```

## Validating

Being that data validation is a fundamental principle, all validation typically operates around the domain objects.

### Entry Validator

You can return a pre-loaded validator instance directly from the entry itself.

```php
use Streams\Core\Support\Facades\Streams;

$entry = Streams::repository('contacts')->find('john-doe');

if ($entry->validator()->passes()) {
    // Yay!
}
```

### Stream Validator

You may also return a validator instance with your own **data** which can be an entry object or _array_ of data to validate as an entry.

```php
use Streams\Core\Support\Facades\Streams;

$validator = Streams::repository('contacts')->validator([
    'name' => 'John Doe',
    'email' => 'john@doe.me',
    'company' => 'streams',
]);

if ($entry->validator()->passes()) {
    // Yay!
}
```
