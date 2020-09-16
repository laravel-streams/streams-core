---
title: Images
category: frontend
intro: 
enabled: true
sort: 10
references:
    - https://laravel.com/docs/filesystem
    - http://image.intervention.io/
---

## Introduction

The Streams platform comes with a fluid and highly extensible image handling and manipulation system that leans heavily on the fantastic [Intervention Image](https://github.com/Intervention/image).

### Path Hints

You will notice that images are almost always prefixed with a `hint::` of some sort.

You can [publish and configure](configuration#publishing-configuration) image path hints within the `config/streams/images.php` file.

You can also add paths at runtime, like from a service provider:

```php
Images::addPath($hint, $path);
```

All unprefixed image paths will be assumed relative to the application's base directory. The following path hints are baked in:

```php
Images::addPath('public', public_path());
Images::addPath('resources', resource_path());
```

## Reading Images

You may use the `Images` facade to create image instances for working with.

```php
use Anomaly\Streams\Platform\Support\Facades\Images;

$image = Images::make('public/foo.jpg');
```

The facade is aliased for use in [views](views) as well:

```blade
@verbatim{!! Images::make('public/foo.jpg') !!}@endverbatim
```

Acceptted image sources include:

- Path of the image in filesystem.
- **Hinted** path of the image in filesystem.
- URL of an image (`allow_url_fopen` must be enabled).

## Editing Images
- blur
- brightness
- colorize
- encode($format = null, $quality = null)
- contrast
- copy
- crop
- fit
- flip
- gamma
- greyscale
- heighten
- insert
- interlace
- invert
- limitColors
- pixelate
- opacity
- resize
- resizeCanvas
- rotate
- amount
- widen
- orientate
- text

## Outputting Images
- img($alt = null, array $attributes = [])
- url(array $parameters = [], $secure = null)
- base64()
- path()
- inline($alt = null, array $attributes = [])
- css()
- data()

### Responsive Images
- sourcesets
