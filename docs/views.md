---
title: Views
category: frontend
intro: 
sort: 0
enabled: true
stage: reviewing
references:
    - https://statamic.dev/views
---

Views contain the HTML served by the frontend of your application. You can find and define views in the `resources/views` directory. A simple view might look something like this:

```blade
// resources/views/welcome.blade.php
<html>
    <body>
        <h1>@verbatim{{ config('app.name') }}@endverbatim</h1>
    </body>
</html>
```

Each file inside your `resources/views` directory is a **view** and is available for use however you like.

## Layouts

Layouts are the outer structural foundation of your application's HTML. It is considered best practice to leverage layouts via [view inheritance](https://laravel.com/docs/blade#template-inheritance) to abstract your view presentation.

```blade
// resources/views/layouts/default.blade.php
@verbatim<html>
    <head>
        <title>App Name - @yield('title')</title>
    </head>
    <body>
        @section('sidebar')
            This is the default sidebar.
        @show

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>@endverbatim
```

### Extending Layouts

When defining a child view, use the Blade `@verbatim@extends@endverbatim` directive to specify which layout the view should "inherit". Views that extend a Blade layout may inject content into the layout's sections using `@verbatim@section@endverbatim` directives. Remember, as seen in the example above, these sections' contents will be displayed in the layout using `@verbatim@yield@endverbatim`:

```blade
// resources/views/example.blade.php
@verbatim@extends('layouts.default')

@section('title', 'Example Title')

@section('sidebar')
    @parent

    <p>This is appended to the default sidebar.</p>
@endsection

@section('content')
    <p>This is the content.</p>
@endsection@endverbatim
```

## Partials

Partials are reusable views intended to be included in many other views and even within other partials. You can use any view as a "partial" by using the [include](https://laravel.com/docs/blade#including-subviews) directive.

```
// Import /resources/views/partials/assets.blade.php
@verbatim@include('partials.assets')@endverbatim
```

## Includes

Includes are like named slots that can be accessed outside of, and prior to, the view layer.

```php
use Streams\Core\Support\Facades\Includes;

Includes::include('assets', 'partials.scripts');
```

```blade
@verbatim@foreach($includes->get('assets', []) as $include)
    @include $include
@endforeach@endverbatim
```

## Conventions

We recommend the following conventions as best practice.

### Naming

- Use lowercase filenames.
- Use hyphens to separate words.
- Mind plurality - [we can leverage this](routing#automatically-resolved-views).

### Organizing

Below is an excellent example of organizing utilitarian views like [layouts](#layouts) and [partials](#partials). These views are used for application structure and DRY'ing up views.

```files
resources/views/
|-- partials/
|   |-- head.blade.php
|   |-- footer.blade.php
|   |-- navigation.blade.php
|-- layouts/
|   |-- amp.blade.php
|   |-- default.blade.php
|   |-- alternate.blade.php
```

### Stream Views

Organizing stream views by stream can not only be [automatically detected](routing#automatically-resolved-views) but bring order to large applications. You can even bundle stream specific partials and layouts within the stream directories to separate them from similar type views intended for global use, as shown above.

```files
resources/views/
|-- contacts/
|   |-- index.blade.php
|   |-- view.blade.php
|   |-- vcard.blade.php
```

The above views correlate to the below routing example.

```json
// streams/contacts.json
{
    "routes": {
        "index": "contacts",
        "view": "contacts/{id}",
        "vcard": "contacts/vcard/{id}"
    }
}
```
