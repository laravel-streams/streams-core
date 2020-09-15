---
title: Routing
category: basics
intro: 
sort: 1
stage: drafting
enabled: true
references:
    - https://statamic.dev/routing
todo:
    - Allow configuring view resolution patterns using tags (resources/{stream}.blade.php, resources/{singular}.blade.php, resources/{stream}/{action}.blade.php)
---

## Introduction

Laravel handles all application requests unless otherwise configured.

## Defining Routes

The Streams platform has a few specific routing approaches, which essentially map to the same native Laravel routing behind the scenes.

### Route Files

You can configure routes as you would in a regular Laravel application in `routes/web.php`.

### Service Providers

You can also use a streamlined [service provider](providers) to define routes.

### Route Facade

The Streams platform provides a `Route::streams()` method for defining routes. All streams-specific routing approaches pass through this method.

```php
// Route a view.
Route::streams('uri', 'view');

// Route more.
Route::streams('uri', [
    'foo' => 'bar',
]);
```

The first argument is the URI and the second is either the name of the [template](templates) to render, a [controller](controllers) with `@verbatim@method@endverbatim`, or an array of options.

#### Route View

When using an array of options you can still specify the `view` to render:

```php
Route::streams('uri', [
    'foo' => 'bar',
    'view' => 'example',
]);
```

#### Route Stream

To specify the stream for the route:

```php
Route::streams('uri', [
    'foo' => 'bar',
    'stream' => 'contacts',
]);
```

The stream instance will be injected into the view:

```blade
@verbatim<h1>{{ $stream->name }}</h1>@endverbatim
```

#### Routing Entries

To specify the stream entry for the route:

```php
Route::streams('uri/{id}', [
    'foo' => 'bar',
    'stream' => 'contacts',
]);
```

The stream entry will be injected into the view:

```blade
@verbatim<h1>{{ $entry->name }}</h1>@endverbatim
```

#### Routing a Specific Entry

You can also specify a specific entry:

```php
Route::streams('uri', [
    'foo' => 'bar',
    'stream' => 'contacts',
    'entry' => 'ryan_thompson',
]);
```

The stream entry will be injected into the view:

```blade
@verbatim<h1>{{ $entry->name }}</h1>@endverbatim
```

#### HTTP Verbs

Use the `verb` options to define the HTTP verb the route should respond to:

```php
Route::streams('uri', ['verb' => 'get']); // Default
Route::streams('uri', ['verb' => 'post']);
Route::streams('uri', ['verb' => 'put']);
Route::streams('uri', ['verb' => 'patch']);
Route::streams('uri', ['verb' => 'delete']);
Route::streams('uri', ['verb' => 'options']);
Route::streams('uri', ['verb' => 'any']);
```

#### Route Middleware

To assign additional middleware to the route:

```php
Route::streams('uri', [
    'middleware' => ['first', 'second']
]);
```

#### Parameter Constraints

You can specify parameter format `constraints` for routes using regular expression:

```php
Route::streams('uri/{name}', [
    'constraints' => ['name' => '[A-Za-z]+']
]);
```

### Stream Routes

You can define routes in your [stream configuration](streams#routing). Define stream routes like `action => route` where `route` is the URI or an array of route options.

```json
// streams/contacts.json
{
    "routes": {
        "index": "contacts",
        "view": "contacts/{id}"
    }
}
```

The route is automatically named like `streams::{stream}.{action}`.

#### Generating URLs

You may use the stream's route name when generating URLs or redirects via the global `route` function:

```php
// Generating URLs.
$url = route('streams::contacts.view');

// Generating Redirects.
return redirect()->route('streams::contacts.index');
```

#### Automatically Resolved Views

The `index` and `view` route names are special in that they try and automatically resolve the view to use.

```json
// streams/contacts.json
{
    "routes": {
        "index": "contacts",    // resources/contacts.blade.php
        "view": "contacts/{id}" // resources/contact.blade.php
    }
}
```

## Redirects

You can create redirects in your `routes/web.php` using the `Route` facade:

``` php
Route::redirect('/from', '/to');
Route::redirect('/from', '/to', 301);
Route::permanentRedirect('/from', '/to');
```

- [Laravel Redirect Routes](https://laravel.com/docs/routing#redirect-routes).

## Error Pages

Errors render views based on the status code of the error. For example, a `404` error will look a view in `resources/views/errors/{status_code}.blade.php`.

Laravel will automatically render a `404` page for any unhandled routes.

- [Laravel Custom Error Pages](https://laravel.com/docs/errors#custom-http-error-pages)
