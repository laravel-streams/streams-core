---
title: Entries
category: database
intro:
stage: drafting
enabled: true
sort: 10
---

## Introduction

Domain entities are called `entries` within the Streams platform. A stream also defines entry attributes, or fields, that dictate the entry's properties and data-casting.

- [Defining Streams](streams)
- [Entry Fields](fields)
- [Field Types](fields#field-types)

## Entry Storage

Entries represent the rows in your database. 

### Flat-file Storage

You can define entry data as files within the `streams/{handle}/` directory where the `handle` is the stream handle to which the entry belongs.

Like streams, entry filenames serve as a `handle`, which you can use to reference the entry. JSON is the default data format, though other [data formats](sources#data-format) are available through [source configuration](sources).

```json
// streams/contacts/ryan_thompson.json
{
    "name": "Ryan Thompson",
    "email": "ryan@domain.com",
    "company": "fundamental_llc"
}
```

### Creating Entries

Regardless of the source used, you can use the below-mentioned repositories to create entries programmatically.

```php
$entry = Streams::repository('contacts')->create([
    "name" => "Ryan Thompson",
    "email" => "ryan@domain.com",
    "company" => "fundamental_llc",
]);
```

- [Entry Repositories](repositories)

## Retrieving Entities

The Streams platform separates methods to retrieve and store entries from the entry objects themselves, less a few convenient functions like `save` and `delete`, by using a repository pattern.

### Entry Repositories

Repositories are responsible for encapsulating storage and querying logic.

Entry repositories are accessed via the `Streams` facade:

```php
foreach (Streams::repository('contacts')->all() as $entry) {
    $entry->name; // The name value.
}
```

You can also retrieve specific entries by their `handle`:

```php
$entry = Streams::repository('contacts')->find('ryan_thompson');
```

- [Entry Repositories](repositories)

### Querying Entries

You can also query entries using a fluent API like you would with `Eloquent`.

```php
foreach (Streams::entries('family')->where('relation', 'brother')->get() as $sibling) {
    $entry->email; // The email value.
}
```

- [Querying Entries](querying)

### Expanding Entry Values

Each field type provides it's own expanded data type besides the primary accessor and mutator casting. Please refer to individual [field type documentation] to learn more about their expanded values.

Use the `expand` method and specify the `handle` of the field to expand the value of:

```php
$entry = Streams::repository('contacts')->find('ryan_thompson');

$entry->expand('email')->mailto($entry->name); // Mailto link with custom link text.
```

- [Field Types](fields#field-types)
