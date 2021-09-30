---
title: Caching
category: basics
intro: 
sort: 21
stage: drafting
enabled: true
---

## Introduction

Streams Core provides a convenient API to link [Laravel cache](https://laravel.com/docs/cache) data to a Stream. When caching in this way, you can flush all cached items related to a Stream together.

### Configuration

@todo document configuration

```json
/streams/examples.json
{
    "config": {
        "cache.collection": "default",
        "cache.store": "default"
    }
}
```

## Cache Usage

#### The Cache Instance

To obtain a Stream-linked cache instance, you may use the `cache()` method on the desired Stream instance:

```php
$cache = Streams::make('examples')->cache();

$cache->get('key');
```

### Retrieving Items

Use the `get` method to retrieve items from the cache. If the item does not exist in the cache, `null` will be returned. You may pass a second argument specifying the default value to return if the item doesn't exist:

```php
$cache = Streams::make('examples')->cache();

$value = $cache->get('key');

$value = $cache->get('key', 'default');
```

You may also pass a `closure` as the default value. The get method will return the closure result if the specified item does not exist in the cache. Using a closure allows you to defer the retrieval of expensive default values until they are needed:

```php
$stream = Streams::make('examples');

$value = $stream->cache()->get('key', function () use ($stream) {
    return $stream->entries()->all();
});
```

#### Checking Items

Use the `exists` method to check if an item exists in cache:

```php
if (Streams::make('examples')->cache()->has('key')) {
    // We have it!
}
```

#### Incrementing/Decrementing Values

Use the `increment` and `decrement` methods to increment or decrement the value of cached integer value:

```php
$cache = Streams::make('examples')->cache();

$cache->increment('key');
$cache->increment('key', $amount);

$cache->decrement('key');
$cache->decrement('key', $amount);
```

#### Retrieve & Store

Use the `remember` method to retrieve an item from the cache and store a default value if the requested item doesn't exist.

```php
$value = Streams::make('examples')->cache()->remember('key', $seconds, function () {
    return Streams::entries('examples')->get();
});
```

#### Retrieve & Delete

Use the `pull` method to retrieve an item from the cache and then delete the item.

```php
$value = Streams::make('examples')->cache()->pull('key');
```


### Storing Items

Use the `put` method to store items in the cache:

```php
Streams::make('examples')->cache()->put('key', 'value', $seconds);
```

You can also pass a `DateTime` instance instead of seconds:

```php
Streams::make('examples')->cache()->put('key', 'value', now()->addMinutes(10));
```

If the storage time is not passed to the put method, the item will be stored indefinitely:

```php
Streams::make('examples')->cache()->put('key', 'value');
```

#### Store If Not Present

Use the `add` method to store items in the cache only if they do not already exist:

```php
Streams::make('examples')->cache()->add('key', 'value', $seconds);
```

#### Store Forever

Use the `forever` method to store items in the cache indefinitely:

```php
Streams::make('examples')->cache()->forever('key', 'value');
```

> Items that are stored "forever" may be removed under some circumstances.

### Removing Items

Use the `forget` method to remove items from the cache:

```php
Streams::make('examples')->cache()->forget('key');
```

You can also remove items by providing a zero or negative number of seconds:

```php
Streams::make('examples')->cache()->put('key', 'value', 0);

Streams::make('examples')->cache()->put('key', 'value', -5);
```

> Stream entry changes automatically forget/flush cache items.

#### Removing All Items

You can clear the entire cache using the `flush` method:

```php
Streams::make('examples')->cache()->flush();
```

> The flush method only flushes linked cache.


## Related Documentation

- [Query Cache](querying#caching)
- [Laravel Cache](https://laravel.com/docs/cache)

Todo: 

- [@todo Response Cache](routing#caching-responses)
- [@todo View Cache](querying#caching-results)
- [@todo API Cache](querying#caching-results)
