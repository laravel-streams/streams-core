---
title: Routing
category: basics
intro: 
sort: 10
stage: reviewing
enabled: true
todo:
    - Allow configuring view resolution patterns using tags (resources/{stream}.blade.php, resources/{singular}.blade.php, resources/{stream}/{action}.blade.php)
---

## Introduction

All requests to your application are handled by **Laravel** unless you create the routes using one of the specific methods described below.

## Defining Routes

The Streams platform has a couple of ways it routes requests, which are listed below. Otherwise, [standard Laravel routing applies](https://laravel.com/docs/routing).

### Route Files

You can configure routes just as you would in a regular Laravel application using the `routes/web.php` file.

### Service Providers

You may use the enhanced [service providers](providers#routing) that come with the Streams platform to define routes.

### Streams Router

The Streams platform provides a `Route::streams()` method for defining routes. *All streams-specific routing approaches pass through this method.*

```php
// Options
Route::streams('uri', [
    'foo' => 'bar',
]);

// View
Route::streams('uri', 'view');

// Controller
Route::streams('uri', 'App\Http\Controller\Example@show');

// Controller and more
Route::streams('uri', [
    'uses' => 'App\Http\Controller\Example@show'
]);
```

The first argument is the URI and the second is either:

- The name of the [view](views) to render.
- A [Controller](controllers)`@verbatim@method@endverbatim` string.
- An array of [route options](#route-options).

### Stream Routes

Defining routes in your [stream configuration](streams#routing) makes it easy to automate naming and URL generation around your domain information and entities.

Define stream routes using a `action => options` format, where `options` is again either the URI, controller and method string, or an array of [route options](#route-options).

```json
// streams/contacts.json
{
    "routes": {
        "index": "contacts",
        "view": "contacts/{id}",
    },
    "profile": {
        "uri": "contacts/{id}",
        "view": "profile"
        }
    }
}
```

#### Automatic Naming

Unless a [route name](#named-routes) is specified, stream configured routes automatically name themselves like `streams::{stream}.{action}`.

```php
$url = route('streams::contacts.index');
```

#### Automatically Resolved Views

Unless a view is specified, the associated requests will attempt to resolve a view automatically.

```json
// streams/contacts.json
{
    "routes": {
        "index": "contacts",    // resources/contacts/index.php
        "view": "contacts/{id}", // resources/contacts/view.php
        "rss": "contacts/{id}/rss" // resources/contacts/rss.php
    }
}
```

You can configure automatic view patterns within the `streams/route.php` [configuration file](configuration). The process ignores the views if they do not exist.

## Parameters

The Streams platform adds support for deep parameter variables using a dot notation when using the `URL::streams()` method to [generate URLs](#generating-urls).

```php
URL::streams('uri/{foo.bar}', 'view');
```

### Stream Parameter

You can specify the stream associated with the route using the [route option](#streams) or by using the `{stream}` URI segment variable in your URI pattern to resolve the stream by its handle.

```php
Route::streams('address-book/{stream}', 'contacts');
```

Consider locking down this routing pattern using a [parameter constraint](#parameter-constraints).

```php
Route::streams('address-book/{stream}', [
    'view' => 'contacts.list',
    'constraints' => [
        'stream' =>  '(businesses|family)'
    ],
]);
```

The resolved stream will be available within the view:

```blade
@verbatim<h1>{{ $stream->name }}</h1>

<ul>
    @foreach ($stream->entries()->get() as $entry)
    <li>{{ $entry->name }}</li>
    @endforeach
</ul>@endverbatim
```

### Entry Parameters

You can specify a stream entry associated with the route using the [route option](#entries) or by using the `{id}` URI segment variable in your URI pattern to resolve the entry by its ID or handle.

```php
Route::streams('address-book/{stream}/{id}', 'contacts');
```

You can also use `{entry.*}` parameters to query the entry by its field values.

```php
// address-book/contacts/ryan@example.com
Route::streams('address-book/{stream}/{entry.email}', 'contacts');
```

The first matching entry will be available within the view:

```php
@verbatim<h1>{{ $entry->name }}</h1>@endverbatim
```

A `404` error page will be displayed entry resolution is attempted, but no entry is found.

## Route Options

All Streams platform-specific methods of registering routes support the following route options.

All route options are parsed with [controller data](controllers):

```php
Route::streams('address-book/{stream}/{id}', [
    'view' => '{streams.handle}',
]);
```

### View

Use the `view` option to specify a [view](views) to render:

```php
Route::streams('uri', [
    'foo' => 'bar',
    'view' => 'example',
]);
```

### Stream

Use the `stream` option to specify the stream associated with the request. [Stream configured routes](#stream-routes) will do this automatically.

```php
Route::streams('uri', [
    'stream' => 'contacts',
]);
```

The stream is automatically injected into the view:

```blade
@verbatim<h1>{{ $stream->name }}</h1>

<ul>
    @foreach ($stream->entries()->get() as $entry)
    <li>{{ $entry->name }}</li>
    @endforeach
</ul>@endverbatim
```

### Entry

You can also specify a specific entry identifier:

```php
Route::streams('uri', [
    'stream' => 'contacts',
    'entry' => 'john_smith',
]);
```

The stream entry is automatically injected into the view:

```blade
// uri/ryan_thompson
@verbatim<h1>{{ $entry->name }}</h1>@endverbatim
```

You can use entry fields to query entries for the view.

```php
// uri/ryan@example.com
Route::streams('uri/{entry.email}', [
    'stream' => 'contacts',
]);
```

You can also hard code the entry ID or handle:

```php
Route::streams('uri', [
    'stream' => 'contacts',
    'entry' => 'ryan_thompson',
]);
```

The first result is automatically injected into the view:

```blade
// uri/ryan_thompson
@verbatim<h1>{{ $entry->name }}</h1>@endverbatim
```

### Redirect

Use the `redirect` and optional `status_code` option to specify a redirect:

```php
Route::streams('uri/{entry.name}', [
    'redirect' => '/new/uri',
    'status_code' => 301, // Default
]);
```

Redirects highlight a good use case to leverage the fact that route options are parsed with controller data:

```php
Route::streams('uri/{entry.name}', [
    'redirect' => '/new/uri/{stream.handle}/{entry.name}',
    'status_code' => 301, // Default
]);
```

#### Native Redirects

You can create [Laravel redirects](https://laravel.com/docs/routing#redirect-routes) in your `routes/web.php` using the `Route` facade as well:

``` php
Route::redirect('/from', '/to');
Route::redirect('/from', '/to', 301);
Route::permanentRedirect('/from', '/to');
```

### Named Routes

Use the `as` option to specify the name of the route:

```php
Route::streams('uri', [
    'view' => 'example',
    'as' => 'login',
]);
```

You can refer to the route by name using the typical Laravel methods:

```php
$url = route('login');
```

### HTTP Verbs

Use the `verb` option to specify the HTTP verb the route should respond to:

```php
Route::streams('uri', ['verb' => 'any']);
Route::streams('uri', ['verb' => 'get']); // Default
Route::streams('uri', ['verb' => 'put']);
Route::streams('uri', ['verb' => 'post']);
Route::streams('uri', ['verb' => 'patch']);
Route::streams('uri', ['verb' => 'delete']);
Route::streams('uri', ['verb' => 'options']);
```

### Route Middleware

Use the `middleware` option to assign additional middleware to the route:

```php
Route::streams('uri', [
    'middleware' => ['first', 'second']
]);
```

### Parameter Constraints

Use the `constraints` option to specify allowed parameter formatting for the route using regular expression:

```php
Route::streams('uri/{name}', [
    'constraints' => ['name' => '[A-Za-z]+']
]);
```

Laravel does not support dots in parameter names at this time. For this reason, `{entry.name}` type parameters transform into `{entry__name}`.

```php
Route::streams('uri/{entry.name}', [
    'constraints' => ['entry__name' => '[A-Za-z]+']
]);
```

### Disabling CSRF

You can disable CSRF protection using the **csrf** option.

```php
Route::streams('uri', [
    'csrf' => false
]);
```

### Deferring Routes

Use the `defer` option to defer registering a route.

```php
Route::streams('/{id}', [
    // ...
    'defer' => true,
]);
```

## Generating URLs

You may use the `URL::streams()` method to generate URLs for named routes, including those with dotted parameter variables. This method also supports parsing URL strings with parameter data. The `extra` data argument is appending as a query string. Use the `absolute` argument to control whether the resulting URL is absolute or not.

```php
URL::streams($target, $parameters = [], $extra = [], $absolute = true);

$entry = Streams::entries('contacts')->first();

// contacts/{entry.email}/{entry.id}
$url = URL::streams('streams::contacts.view', ['entry' => $entry]);

// contacts/{email}/{id}
$url = URL::streams('streams::contacts.view', $entry);
```

You can also use [Laravel URL generation](https://laravel.com/docs/routing#named-routes) for named routes, though dotted parameters are not supported using Laravel methods:

```php
// Generating URLs.
$url = route('streams::contacts.index');

// Generating Redirects.
return redirect()->route('streams::contacts.index');
```

## Error Pages

Errors render views based on the status code of the error. For example, a `404` error will look a view in `resources/views/errors/{status_code}.blade.php`.

Laravel will automatically render a `404` page for any unhandled routes.

- [Laravel Custom Error Pages](https://laravel.com/docs/errors#custom-http-error-pages)
