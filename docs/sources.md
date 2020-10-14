---
title: Sources
category: database
intro: Source adapters connect streams to any source of information you might encounter.
enabled: true
sort:
---

## Introduction

Source adapters connect streams to any source of information you might encounter.

### Defining Sources 

Specify **source** information in your [stream configuration](streams#defining-streams). Below is the default configuration.

```json
// streams/contacts.json
{
    "source": {
        "type": "filebase",
        "format": "md"
    }
}
```

## Available Sources

The following **sources** are available with the Streams platform by default.

### Filebase

The flat file database powered by the fantastic [Filebase](https://figt) package is the **default** source.

```json
// streams/contacts.json
{
    "source": {
        "type": "filebase",
        "format": "md",
        "prototype": "Streams\\Core\\Entry\\Entry"
    }
}
```

#### Available Formats

The following formats are supported:

- `json`
- `md`
- `yaml`

### Eloquent Model

The eloquent model source uses Laravel models to query and return stream-enhanced models.

```json
// streams/contacts.json
{
    "source": {
        "type": "eloquent",
        "model": "App\\Contact\\ContactModel"
    }
}
```

### Laravel Database

The Laravel database source uses genetic Laravel database tables to query and return stream [entry prototypes](entries).

```json
// streams/contacts.json
{
    "source": {
        "type": "database",
        "table": "contacts",
        "connection": "default",
        "prototype": "Streams\\Core\\Entry\\Entry"
    }
}
```

## Extending

You can very likely provide a custom source adapter for **any source of information** you might encounter.

### Custom Sources

@todo talk about developing custom source adapters.
