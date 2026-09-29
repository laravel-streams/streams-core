---
title: 'Core: Routes'
nav_title: Routes
description: 'Stream routes JSON, Route::streams, EntryController, parse and defer.'
section: packages
package: core
order: 130
tags: [core, routes]
status: ready
---

Streams can register Laravel routes from JSON and through the `Route::streams()` macro.

## Stream JSON routes

```json
{
    "routes": [
        {
            "handle": "view",
            "uri": "{uri}",
            "parse": true,
            "view": "{layout}"
        },
        {
            "uri": "blog/{id}",
            "view": "posts.show",
            "defer": true
        }
    ]
}
```

| Option | Purpose |
|--------|---------|
| `parse` | Register one route per entry (bind `{field}` placeholders from entries) |
| `defer` | Register routes on `App::booted()` instead of immediately |
| `view` | Blade view name passed to `EntryController` |
| `middleware`, `verb`, `csrf` | Standard Laravel route options |

URI placeholders like `{entry.slug}` become criteria bindings (`entry__slug` internally).

## Route::streams macro

```php
Route::streams('posts/{id}', [
    'stream' => 'posts',
    'view' => 'posts.show',
]);
```

String routes without `@` default to `EntryController` with a `view` parameter.

## EntryController

`Streams\Core\Http\Controller\EntryController` resolves:

- The target stream
- The entry (by route id or criteria parameters)
- The view or redirect from route config

Returns `Response::view()` or a redirect response.

## URL helper

```php
URL::streams('posts/{id}', ['id' => 'hello']);
```

## Related

- [Hub: Routing](/docs/routing)
- [Hub: Site pages](/docs/site-pages)
- [Applications](/docs/core/applications)
