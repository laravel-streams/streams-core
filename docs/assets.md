---
title: Assets
category: frontend
status: drafting
enabled: true
sort: 2
intro: 
---

## Introduction

The Streams platform comes with a fluid and highly extensible asset management tool for organizing, registering, customizing, and including your frontend assets.

### Asset Collections

Assets are organized into **collections** which can be accessed and output later. You can access or create an asset collection using the `Assets` facade or alias.

```php
use Streams\Core\Support\Facades\Assets;

$collection = Assets::collection('footer');
```

```blade
@verbatim{!! Assets::collection('footer') !!} // Outputs asset tags"@endverbatim
```

## Adding Assets

Use the `add()` method to add an asset to a **collection**.

```php
Assets::collection('footer')->add('resources/js/start.js');
```

```blade
@verbatim{!! Assets::collection('footer')->add('resources/js/start.js') !!}@endverbatim
```

### Asset Sources

The first and only argument should be the source of the asset. The following asset sources are supported out of the box.

#### Paths in the Filesystem

Any non-executable asset path relative to the application's **8*public root** may be used.

```blade
@verbatim{!! Assets::collection('footer')->add('js/example.js') !!} // /public/js/example.js@endverbatim
```

<!-- #### Configured Storage Disks

You may use any configured storage location as an asset source.

```blade
@verbatim{!! Assets::collection('footer')->add('s3::js/example.js') !!}@endverbatim
``` -->

#### Remote URLs

The URL of a remote asset may also be used. The `allow_url_fopen` PHP directive must be enabled to output `inline` or `content` methods for remote files.

```blade
@verbatim{!! Assets::collection('footer')->add('https://cdn.com/js/example.js') !!}@endverbatim
```

#### Hinted Assets

Hinted assets are prefixed with a `namespace::` that is replaced with a [registered path](#registering-paths).

```blade
// /public/vendor/anomaly/streams/ui/js/example.js@endverbatim
@verbatim{!! Assets::collection('footer')->add('ui::js/example.js') !!} 

// https://cdn.domain.com/js/example.js@endverbatim
@verbatim{!! Assets::collection('footer')->add('cdn::js/example.js') !!} 
```

### Named Assets

Use the `register()` method to **name** one or more **assets**. The assets parameter can be any valid source or array of sources.

```php
use Streams\Core\Support\Facades\Assets;

Assets::register('ui/tables', [
    'ui::js/tables.js',
    'ui::css/tables.css',
]);
```

You can now use the collection's `load()` method to load the assets by **name**.

```blade
@verbatim{!! Assets::collection('footer')->load('ui/tables') !!}@endverbatim
```

```php
Assets::collection('footer')->load('ui/tables');
```

You can also render the output of the named single assets.

```php
Assets::tags('ui/tables');
```


## Outputting Assets

Use output methods to include assets from a **collection**.

### Generating URLs

Use the `url()` method to return a single asset URL.

```blade
@verbatim{!! Assets::url('ui::js/example.js') !!}@endverbatim
```

You can also use the `urls()` method on a **collection** to return all URLs.

```blade
@verbatim{!! Assets::collection('urls')->urls() !!}@endverbatim
```

### Including Assets

Use the `tag()` method to return a single asset URL. An **attributes** array can be passed as a second parameter.

```blade
@verbatim{!! Assets::tag('ui::js/example.js', [
    'async' => true
]) !!}@endverbatim
```

You can also use the `tags()` method on a **collection** to return all tags.

```blade
@verbatim{!! Assets::collection('footer')->tags() !!}@endverbatim
```

## Registering Paths

Use the `addPath()` method to register a **namespace** and **path**. The path parameter can be any path in the filesystem relative to the application's public root or a remote URL prefix.

```php
use Streams\Core\Support\Facades\Assets;

Assets::addPath('ui', 'vendor/anomaly/streams/ui');
Assets::addPath('cdn', 'https://cdn.domain.com');
```

You can now use the above path hints to resolve assets.

```blade
@verbatim{!! Assets::collection('footer')->add('ui::js/example.js') !!} // /public/vendor/anomaly/streams/ui/js/example.js@endverbatim
@verbatim{!! Assets::collection('footer')->add('cdn::js/example.js') !!} // https://cdn.domain.com/js/example.js@endverbatim

@verbatim{!! Assets::url('ui::js/example.js') !!}@endverbatim
@verbatim{!! Assets::url('cdn::js/example.js') !!}@endverbatim
```
