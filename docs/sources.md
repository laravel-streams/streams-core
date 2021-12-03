---
title: Sources
category: database
intro: Source adapters connect streams to any source of information you might encounter.
enabled: true
sort:
---

## Introduction

Source adapters helps you query any source of data you might encounter in the wild.

### Defining Sources 

Specify **source** information in your [stream configuration](streams#defining-streams).

If no source is specified, the below defaults will be assumed.


```json
// streams/{handle}.json
{
    "config": {
        "source": {
            "format": "json",
            "type": "filebase",
            "path": "streams/data/{handle}"
        }
    }
}
```


## Available Sources

The following **sources** are available with the Streams platform by default.

### Self

You can define data within on your stream configuration file.

```json
// streams/contacts.json
{
    "config": {
        "source": {
            "type": "self"
        }
    },
    "data": {
        "john": {
            "name": "John Doe"
        },
        "jane": {
            "name": "Jane Doe"
        }
    }
}
```

### Filebase

The flat file database powered by the fantastic [Filebase](https://github.com/tmarois/Filebase) package is the **default** source.


```json
// streams/contacts.json
{
    "config": {
        "source": {
            "format": "json",
            "type": "filebase",
            "path": "streams/data/contacts"
        }
    }
}
```

#### JSON Format

```json
// streams/data/contacts/ryan.json
{
    "name": "Ryan",
    "email": "ryan@example.com"
}
```

#### YAML Format

@verbatim
```yaml
// streams/data/contacts/ryan.yaml
---
name: "Ryan"
email: "ryan@example.com"
---
The body is built in: {{ $entry->name }}
```
@endverbatim

#### MD Format

@verbatim
```markdown
// streams/data/contacts/ryan.md
---
name: "Ryan"
email: "ryan@example.com"
---
The body is built in: {{ $entry->name }}
```
@endverbatim

#### TPL Format
@verbatim
```template
// streams/data/contacts/ryan.tpl
---
name: "Ryan"
email: "ryan@example.com"
---
The body is built in: {{ $entry->name }}
```
@endverbatim

### Eloquent Model

The eloquent model source uses Laravel models to query and can return stream-enhanced Eloquent models.

```json
// streams/contacts.json
{
    "config": {
        "source": {
            "type": "eloquent",
            "model": "App\\Contact\\ContactModel"
        }
    }
}
```

### Laravel Database

The Laravel database source uses generic Laravel database tables to query and return stream [entries](entries).

```json
// streams/contacts.json
{
    "config": {
        "source": {
            "type": "database",
            "table": "contacts",
            "connection": "default"
        }
    }
}
```

## Extending

You can create and register a custom source adapter for **any source of information** you might encounter.

### Custom Sources

**@todo Talk about developing custom source adapters.**
