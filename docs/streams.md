---
title: Streams
category: database
intro: Streams are code-configured data-structures.
sort: 1
references:
    - https://craftcms.com/docs/3.x/elements.html
    - https://craftcms.com/docs/3.x/element-queries.html
---

Stream configurations are the foundation of building with the Streams platform.

## Configuration

Stream configurations are stored in the `streams/` repository as JSON files. The filenames are used as the `handle` which you can use to access the Stream and it's Entry data.

### Basic Configuration

Stream configurations only _require_ field configurations. This makes it easy to test structural ideas and firm them up later with more detail, if necessary.

A very basic Stream structure might look like this:

```json
// streams/contacts.json
{
    "name": "Contacts",
    "fields": {
        "name": "string",
        "email": "email",
        "company": {
            "type": "relationship",
            "stream": "company"
        }
    }
}
```

### JSON References

You can use JSON file references anywhere in Stream configuration to reuse various configurations or tidy up larger ones. The JSON reference will be directly replaced with the referenced file's JSON data.

> Note all references are relative to the base installation path.

```json
// streams/contacts.json
{
    "name": "Contacts",
    "fields": "@streams/fields/contacts.json"
}
```

```json
// streams/fields/contacts.json
{
    "name": "string",
    "email": "email",
    "company": {
        "type": "relationship",
        "stream": "company"
    }
}
```

## Streams Facade

The `Streams` facade is how most all services built around streams are accessed.

#### Fetching specific Streams

You can access specific configured Stream instances by using the `Streams` facade:

```php
echo Streams::make('contacts')->name;   // Contacts
echo Streams::make('contacts')->handle; // contacts
```

#### Fetching all Streams

All registered Streams are pushed into a collection which you can also access using the `Streams` facade:

```php
foreach (Streams::collection() as $stream) {
    echo $stream->name;   // Contacts
    echo $stream->handle; // contacts
}
```

## Sources

Source configuration is defined in the Stream configuration. It defines where the source of the data for the Stream.

> If not specified the built-in flat-file database will be used by default.

- [Learn more about Sources](sources)

## Fields

Fields define the properties or attributes of the Stream data. They provide type casting, data validation, and other helpful functionality. 

- [Learn more about Fields](sources)

## Entries

Entries are like the rows of your database. They behave much like an `Eloquent` model. Entries will leverage the Stream configuration to maximize what you can do with your data with minimal input.

### Repositories

Repositories are the most basic way of access stream entries.

```php
foreach (Streams::repository('contacts')->all() as $entry) {
    echo $entry->expand('email')->mailto($entry->name); // <a href="mailto:obfuscated">Ryan Thompson</a>
}
```

- [Learn more about repositories](repositories)

### Querying Entries

You can use entry `Criteria` to query entries from your database much like a Laravel query builder:

- [Learn more about querying](querying)

## Learn More

Here are some ways that you can start leveraging configured Streams and their data.

- [RESTful API](/docs/api/introduction)
- [UI Components](/docs/ui/introduction)
