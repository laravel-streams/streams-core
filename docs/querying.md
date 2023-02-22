---
title: Criteria
link_title: Querying
category: database
intro: An extensible, fast, and database-indifferent querying API.
stage: outlining
enabled: true
sort: 9
---

## Introduction

Querying builds upon knowledge of [streams](streams), [fields](fields), and [entries](entries). Using the querying techniques below you can retreive, insert, and update stream configured entry data.

### Getting Started

To initialize a new query use the `Streams::entries()` method.

```php
use Streams\Core\Support\Facades\Streams;

$query = Streams::entries('contacts');
```

## The Basics

You can **chain** the below methods together to build query logic and return a collection of **results**.

```php
use Streams\Core\Support\Facades\Streams;

$results = Streams::entries('contacts')
    ->where('email', 'like', '%@gmail.com')
    ->orderBy('name', 'asc')
    ->get();
```

### Filtering

#### Basic Where Clauses

You may use the `where` method on a query instance to add where clauses to the query. The most basic call to where requires three arguments. The first argument is the handle of the **field**. The second argument is an operator, which can be any of the database's supported operators including **IN** and **NOT IN**. Finally, the third argument is the value to evaluate against the field value.

For example, here is a query that verifies the value of the "votes" column is equal to 100:

```php
$users = Streams::entries('users')->where('votes', '=', 100)->get();
```

For convenience, if you want to verify that a field is equal to a given value, you may pass the value directly as the second argument to the where method:

```php
$users = Streams::entries('users')->where('votes', 100)->get();
```

You may use a variety of other operators when writing a where clause:

```php
$users = Streams::entries('users')
    ->where('votes', '>=', 100)
    ->get();

$users = Streams::entries('users')
    ->where('votes', '<>', 100)
    ->get();

$users = Streams::entries('users')
    ->where('name', 'like', 'T%')
    ->get();
```

#### Or Statements

You may chain where constraints together as well as add **or** clauses to the query. The orWhere method accepts the same arguments as the where method:

```php
$users = Streams::entries('users')
    ->where('votes', '>', 100)
    ->orWhere('name', 'John')
    ->get();
```

### Sorting/Ordering

The `orderBy` method allows you to sort the result of the query by a given field. The first argument to the `orderBy` method should be the field you wish to sort by, while the second argument controls the direction of the sort and may be either `asc` or `desc`:

```php
$users = Streams::entries('users')
    ->orderBy('name', 'desc')
    ->get();
```

If you need to sort by multiple fields, you may invoke `orderBy` as many times as needed:

```php
$users = Streams::entries('users')
    ->orderBy('name', 'desc')
    ->orderBy('email', 'asc')
    ->get();
```

### Limit/Offset

The `limit` method allows you to limit the number of result returned by the query and an offset value. The first argument to the `limit` method should be the number of entries you wish to return, while the second argument controls the offset of the query, if any:

```php
// The first 10
$users = Streams::entries('users')
    ->limit(10)
    ->get();

// The next 10
$users = Streams::entries('users')
    ->limit(10, 10)
    ->get();
```

### Pagination

The `paginate` method allows you to generate a paginated result. A [Laravel paginator](https://laravel.com/docs/pagination) instance is returned.

```php
$users = Streams::entries('users')->paginate(15);

echo $users->links(); // Render pagination
echo $users->items(); // Return all items
echo $users->total(); // Return total items
```


### Chunk

The `chunk` method allows you to chunk through large datasets without exhausting memory.

```php
Streams::entries('users')->chunk(1000, function ($users) {
    $users->each(function ($user) {
        echo $user->email;
    });
});
```

### Caching

The `cache` method allows you to cache query results. The first parameter should be the **seconds** in which to cache the results. An optional second parameter can be provided as a **key**, otherwise one will be generated based on your query **fingerprint**.

```php
$favorites = Streams::entries('books')
    ->where('favorited', true)
    ->cache(600, 'favorites')
    ->get();
```

For more information on managing cache please see the [cache documentation](caching).


### Eager Loading

The `with` method accepts an array of `relations` to load eagerly in order to optimize querying:

```php
$people = Streams::entries('people')
    ->with(['hometown'])
    ->get();

foreach ($people as $person) {
    echo $person->hometown?->name;
}
```

## Extending Queries

There are numerous techniques you can use to extend querying logic.

### Extending Basics

The **query** object is `macroable`.

- [Extending the Streams Platform](extending)

### Query Criteria

The **criteria** interface serves as the wrapper for various query building logic.
