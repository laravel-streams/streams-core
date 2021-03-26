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

The Streams platform leans heavily on native Laravel validation and focuses on automating the process from domain information and allowing flexibility to adjust this behavior entirely.

### Rule Configuration

Rules are generally configured and built the same way within the Streams platform. All Streams rule configurations support arrays of rules or the typical pipe deliminated string.

#### Stream Rules

You can also define validation rules within [stream cofiguration](streams#defining-streams).

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

#### Field Rules

You can define **rules** whithin [field configuration](fields#defining-fields) as well.

```json
// streams/contacts.json
{
    "fields": {
        "name": {
            "type": "string",
            "rules": [
                "required",
                "max:100"
            ]
        },
        "email": {
            "type": "email",
            "rules": [
                "required",
                "email:rfc,dns"
            ]
        },
        "company": {
            "rules": "required|unique",
            "type": "relationship",
            "stream": "companies"
        }
    }
}
```

### Custom Validators

The Streams platform supports [custom validators](https://laravel.com/docs/validation#custom-validation-rules). The **handler** or validator class is required as well as a **message** string which is translatable.

#### Stream Validators

Validators can also be defined on the [stream configuration](streams#defining-streams) to support all fields.

```json
// streams/contacts.json
{
    "rules": [
        "name": ["custom_rule"]
    ],
    "validators": {
        "custom_rule": {
            "handler": "App\\Validators\\CustomRuleValidator",
            "message": "The :attribute value is no good."
        }
    }
}
```

#### Field Validators

Validators can be defined on the [field configuration](fields#defining-fields) in which they apply.

```json
// streams/contacts.json
{
    "fields": {
        "name": {
            "type": "string",
            "rules": [
                "name": ["custom_rule"]
            ],
            "validators": {
                "custom_rule": {
                    "handler": "App\\Validators\\CustomRuleValidator",
                    "message": "The :attribute value is no good."
                }
            }
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
