---
title: Validation
category: basics
intro: 
stage: outlining
enabled: true
sort: 10
references:
    - https://laravel.com/docs/validation
---

## Introduction

The Streams platform provides a simple interface to leverage [Laravel validation](https://laravel.com/docs/validation).

## Defining Rules

In general, you define validation rules in the Streams platform in a similar fashion as Laravel.

```php
$rules = [
    'title' => 'required|max:100',
    'body' => 'required',
];
```

### Field Rules

You can define **rules** directly on stream [fields](fields#defining-fields). Note you can specify the individual rules as an array or pipe deliminated string.

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

### Stream Rules

You can also define validation rules directly on the [stream cofiguration](streams#defining-streams). Here again, you can specify the individual rules as an array or pipe deliminated string.

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

### Custom Validators

The Streams platform supports [custom validators](https://laravel.com/docs/validation#custom-validation-rules). The **handler** or validator class is required as well as a **message** string which is translatable.

#### Field Validators

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

#### Stream Validators

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

## Validating
    - Entry Validator
    - Stream Validator ($data)
