---
title: Images
category: frontend
intro: 
enabled: true
sort: 10
---

## Introduction

The Streams platform comes with a fluid and highly extensible image handling and manipulation tool that leans heavily on the fantastic [Intervention Image](https://github.com/Intervention/image).

## Reading Images

To get started, use the `Images` facade to create a new image for working with.

```php
use Streams\Core\Support\Facades\Images;

$image = Images::make('img/foo.jpg');
```

The facade is aliased for use in [views](views) as well:

```blade
@verbatim{!! Images::make('resources/img/foo.jpg') !!}@endverbatim
```

### Image Sources

The first and only argument should be the source image to display. The following sources are supported out of the box:

#### Paths in the Filesystem

Any image path relative to the application root may be used.

```blade
@verbatim{!! Images::make('resources/img/foo.jpg') !!}@endverbatim
```

#### Configured Storage Disks

You may use any configured storage location as an image source.

```blade
@verbatim{!! Images::make('public://img/foo.jpg') !!}@endverbatim
```

If the file is not found relative to the base path of your application, the default public disk will be attempted.

```blade
@verbatim{!! Images::make('img/foo.jpg') !!}@endverbatim
```

#### Remote URLs

The URL of a remote image may also be used. The `allow_url_fopen` PHP directive must be enabled to use remote image sources.

```blade
@verbatim{!! Images::make('https://example.com/img/foo.jpg') !!}@endverbatim
```

Remote images are cached locally. To use remote images without caching locally just use regular `<img>` tags.

### Named Images

Use named images to register image variables:

#### Registering Images

You may regiter iamges by name using the **register** method:

```php
use Streams\Core\Support\Facades\Images;

Images::register('logo.jpg', 'images/logo.jpg');
```

```blade
@verbatim{!! Images::make('logo.jpg')->fit(300, 500)->quality(60) !!}@endverbatim
```

## Editing Images

After you initiat a new image instance with `Images::make()`, you can use the whole palette of [manipulation methods](http://image.intervention.io/use/basics#editing) on the instance.

Modification methods return the image instance, so you are able to chain methods.

```php
use Streams\Core\Support\Facades\Images;

$image = Images::make('img/foo.jpg')->fit(300, 500)->quality(60);
```

```blade
@verbatim{!! Images::make('resources/img/foo.jpg')->fit(300, 500)->quality(60) !!}@endverbatim
```

### Resizing Images

Use the following methods to resize images.

- [resize()](http://image.intervention.io/api/resize)
- [widen()](http://image.intervention.io/api/widen)
- [heighten()](http://image.intervention.io/api/heighten)
- [fit()](http://image.intervention.io/api/fit)
- [crop()](http://image.intervention.io/api/crop)
- [trim()](http://image.intervention.io/api/trim)

### Adjusting Images

Use the following methods to adjust various aspects of images.

- [encode()](http://image.intervention.io/api/encode)
- [gamma()](http://image.intervention.io/api/gamma)
- [brightness()](http://image.intervention.io/api/brightness)
- [contrast()](http://image.intervention.io/api/contrast)
- [colorize()](http://image.intervention.io/api/colorize)
- [greyscale()](http://image.intervention.io/api/greyscale)
- [invert()](http://image.intervention.io/api/invert)
- [mask()](http://image.intervention.io/api/mask)
- [flip()](http://image.intervention.io/api/flip)

#### quality()

Additionally, you may use the `quality` method to adjust the quality alone of JPG images.

```php
Images::make('img/foo.jpg')->quality(60);
```

### Applying Effects

Use the following methods to apply effects to images.

- [filter()](http://image.intervention.io/api/filter)
- [pixelate()](http://image.intervention.io/api/pixelate)
- [rotate()](http://image.intervention.io/api/rotate)
- [blur()](http://image.intervention.io/api/blur)

### Drawing

Use the following methods to draw on images.

- [text()](http://image.intervention.io/api/text)
- [pixel()](http://image.intervention.io/api/pixel)
- [line()](http://image.intervention.io/api/line)
- [rectangle()](http://image.intervention.io/api/rectangle)
- [circle()](http://image.intervention.io/api/circle)
- [ellipse()](http://image.intervention.io/api/ellipse)

### Macros

Macros are a basic method of [extending the Streams platform](extending).

#### Defining Macros

You can define macros in a service provider.

```php
use Streams\Core\Image\Image;

Image::macro('thumbnail', function () {
    return $this->fit(148)->encode('jpg', 50);
});
```

#### Applying Macros

```php
$thumbnail = Images::make('img/foo.jpg')->thumbnail();
```

## Outputting Images

Use output methods to display image data from an image object. The `img` method is used by default.

#### img()

Use the `img` method to return an `<img>` tag.

```blade
@verbatim{!! Images::make('img/foo.jpg') !!}@endverbatim
```

The first parameter can be an `alt` tag or array of attributes. If an alt tag is provided, the attributes can still be provided as a second parameter. Note this is the default output method when used in Blade.

```php
Images::make('img/foo.jpg')->img('Foo Bar Image', ['width' => '100'])
```

Note that unmatched methods will pass through to set attribute values.

```php
Images::make('img/foo.jpg')->width(100)->img('Foo Bar Image')
```

#### url()

Use the `url` method to output a URL to the image. The first argument may be an array of query string parameters to append. The second argument can be used to force secure URLs. If not specified, the URLs will use the protocol of the request. If 

```php
Images::make('img/foo.jpg')->url()

// Append a manual version query parameter.
Images::make('img/foo.jpg')->url(['version' => 'v1'])
```

#### inline()

Use the `inline` method to return an `<img>` tag with a **base64** encoded **src**.

```blade
@verbatim{!! Images::inline('img/foo.jpg') !!}@endverbatim
```

The first parameter can be an `alt` tag or array of attributes. If an alt tag is provided, the attributes can still be provided as a second parameter. Note this is the default output method when used in Blade.

```php
Images::make('img/foo.jpg')->inline('Foo Bar')
```

#### base64()

Use the `base64` method to return a base64 encoded string.

```blade
@verbatim<img src="{!! Images::make('img/foo.jpg')->base64() !!}">@endverbatim
```

#### css()

Use the `css` method to return a `url()` string for use in CSS backgrounds.

```blade
@verbatim<div style="background: {!! Images::make('img/foo.jpg')->css() !!};">@endverbatim
```

#### data()

The `data` method will return the contents of the image as a string.

```php
echo Images::make('img/foo.jpg')->data()
```

### Responsive Images

#### srcsets()

```php
Images::make('img/foo.jpg')
    ->srcsets([
        '1x' => [
            'resize'  => 400,
            'quality' => 60
        ],
        '2x' => [
            'resize'  => 800,
            'quality' => 90
        ],
        '640w' => [
            'resize'  => 800,
            'quality' => 90
        ]
    ]);
```

#### sources()

```php
Images::make('img/foo.jpg')
    ->srcsets([
        '(min-width: 600px)' => [
            'resize'  => 400,
            'quality' => 60
        ],
        '(min-width: 1600px)' => [
            'resize'  => 800,
            'quality' => 90
        ],
        'fallback' => [
            'resize'  => 1800
        ]
    ]);
```

#### picture()

```php
Images::make('img/foo.jpg')
    ->sources([
        '(min-width: 600px)' => [
            'resize'  => 400,
            'quality' => 60
        ],
        '(min-width: 1600px)' => [
            'resize'  => 800,
            'quality' => 90
        ],
        'fallback' => [
            'resize'  => 1800
        ]
    ])->picture();
```
