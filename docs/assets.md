---
title: Assets
category: frontend
intro: 
---

## Introduction

The Streams platform comes with a fluid and highly extensible asset pipeline tool for organizing, registering, and including your frontend assets.

## Reading Assets

To get started, use the `Assets` facade to create a interact with asset **collections**.

```php
Assets::collection('footer')->add('resources/js/start.js');
```

```blade
@verbatim{!! Assets::collection('footer')->add('resources/js/start.js') !!}@endverbatim
```

### Asset Sources

The first and only argument should be the source of the asset. The following sources are supported out of the box:

#### Paths in the Filesystem

Any asset path relative to the application root may be used.

```blade
@verbatim{!! Assets::collection('footer')->add('resources/js/require.js') !!}@endverbatim
```

#### Configured Storage Disks

You may use any configured storage location as an asset source.

```blade
@verbatim{!! Assets::collection('footer')->add('public::js/require.js') !!}@endverbatim
```

If the file is not found relative to the base path of your application, the default public disk will be attempted.

```blade
@verbatim{!! Assets::collection('footer')->add('js/require.js') !!}@endverbatim
```

#### Remote URLs

The URL of a remote ass may also be used. The `allow_url_fopen` PHP directive must be enabled to use remote asset sources.

```blade
@verbatim{!! Assets::collection('footer')->add('https://example.com/js/require.js') !!}@endverbatim
```

Remote assets are cached locally. To use remote assets without caching locally just use regular `style` and `script` tags.

### Named Assets
@todo finish "Named Assets"
#### Registering Assets
#### Specifying Named Assets
## Outputting Assets

Use output methods to include assets from a **collection**. The `tag` method is used by default.

@todo finish up

- `urls`
- `tags`
- `inlines`
- `paths`
- `content`
