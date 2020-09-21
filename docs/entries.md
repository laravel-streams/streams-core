---
title: Entries
category: basics
intro:
stage: drafting
enabled: true
sort: 2
todo:
    - This needs to be organized slightly better.
---


- Introduction
- Creating Entries
    - Flat File Storage
    - Entry Repository
    - Entry Prototype
- Retrieving Entries
    - Entry Repositories
    - Querying Entries


## Introduction

Domain entities are called `entries` within the Streams platform. A stream also defines entry attributes, or fields, that dictate the entry's properties and data-casting.

- [Defining Streams](streams)
- [Entry Fields](fields)
- [Field Types](fields#field-types)

## Creating Entries

Entries represent the rows in your database. In most cases, manually creating entry data is self-explanatory, based on the source of the stream.

### Flat-file Storage

You can define flat-file entry data as files within the `streams/{handle}/` directory where the `handle` is the stream handle to which the entry belongs.

Like streams, entry filenames serve as a `handle`, which you can use to reference the entry. JSON is the default data format, though other [data formats](sources#data-format) are available through [source configuration](sources).

```json
// streams/contacts/ryan_thompson.json
{
    "name": "Ryan Thompson",
    "email": "ryan@domain.com",
    "company": "fundamental_llc"
}
```

### Entry Repositories

Regardless of the source used, you can use repositories to create entries programmatically.

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

## Updating Entries

Updating entries is easy. You can, of course, directly modify the flat-file data. But let's take a look at a couple of other methods.

### Entry Repositories

Like the operations above, you can use the `Stream` facade to `save` and `delete` entries.

```php
$entry->name = "Mr Ryan Thompson";

Streams::repository('contacts')->save($entry);
```

```php
Streams::repository('contacts')->delete($entry);
```

- [Entry Repositories](repositories)

### Storage Methods

You can use a few storage methods directly on the entry instance itself.

```php
$entry->name = "Mr Ryan Thompson";

$entry->save(); // Returns bool.
```

```php
$entry->delete(); // Returns bool.
```

## Entry Objects

Working with entry objects is the same regardless of the source of the stream entries. With this, you can quickly scaffold projects using flat-file storage, then easily migrate stream schema into a database and manage entries there with zero code changes.

### Expanding Entry Values

Each field type provides it's own expanded data type besides the primary accessor and mutator casting. Please refer to individual [field type documentation] to learn more about their expanded values.

Use the `expand` method and specify the `handle` of the field to expand the value of:

```php
$entry = Streams::repository('contacts')->find('ryan_thompson');

$entry->expand('email')->mailto($entry->name); // Mailto link with custom link text.
```

- [Field Types](fields#field-types)
