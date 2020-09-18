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

The Streams platform comes with a fluid and highly extensible image handling and manipulation tool that leans heavily on the fantastic [Intervention Image](https://github.com/Intervention/image).

## Reading Images

To get started, use the `Images` facade to create a new image for working with.

```php
use Anomaly\Streams\Platform\Support\Facades\Images;

$image = Images::make('public/foo.jpg');
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
@verbatim{!! Images::make('resources/img/foo.jpg') !!}@endverbatim
```

Remote images are cached locally. To use remote images without caching locally just use regular `<img>` tags.

## Editing Images

After you initiat a new image instance with `Images::make()`, you can use the whole palette of [manipulation methods](http://image.intervention.io/use/basics#editing) on the instance.

Modification methods return the image instance, so you are able to chain methods.

```php
use Anomaly\Streams\Platform\Support\Facades\Images;

$image = Images::make('public/foo.jpg')->fit(300, 500)->quality(60);
```

```blade
@verbatim{!! Images::make('resources/img/foo.jpg')->fit(300, 500)->quality(60) !!}@endverbatim
```

### Resizing Images

Use the following methods to resize images.

#### fit()

Combine cropping and resizing to format image in a smart way. This method will find the best fitting aspect ratio of your given width and height on the current image automatically, cut it out and resize it to the given dimension. You may pass an optional boolean value as third parameter, to prevent possible upsizing and a custom position of the cutout as fourth parameter.

```php
$image->fit($width, $height = null, $upsize = false, $position = 'center')
```

The following values are supported for the `position` parameter.

- top-left
- top
- top-right
- left
- center (default)
- right
- bottom-left
- bottom
- bottom-right

#### resize()

Resizes current image based on given width and/or height. To disable resize constrains, pass an optional boolean with `false` value as the third parameter. To allow upsizing, pass an optional boolean with `true` value as the fourth parameter.

```php
// Resize image to fixed size
Image::make('img/foo.jpg')->resize(300, 200);

// resize only the width of the image
Image::make('img/foo.jpg')->resize(300, null);

// resize only the height of the image
Image::make('img/foo.jpg')->resize(null, 200);

// resize the image to a width of 300 and disable constraining aspect ratio (auto height)
Image::make('img/foo.jpg')->resize(300, null, false);

// resize the image to a height of 200 and disable constraining aspect ratio (auto width)
Image::make('img/foo.jpg')->resize(null, 200, false);

// Allow possible upsizing
Image::make('img/foo.jpg')->resize(null, 400, true, false);

// resize the image so that the largest side fits within the limit; the smaller
// side will NOT be scaled to maintain the original aspect ratio. Upsizing allowed.
Image::make('img/foo.jpg')->resize(400, 400, false, false);
```

#### widen()

Resizes the current image to new width, constraining aspect ratio. Pass an optional boolean as second parameter, to prevent possible upsizing.

```php
// resize image to new width
Image::make('img/foo.jpg')->widen(300);

// resize image to new width and allow upsizing
Image::make('img/foo.jpg')->widen(300, true);
```

#### heighten()

Resizes the current image to new height, constraining aspect ratio. Pass an optional boolean as econd parameter, to prevent possible upsizing.

```php
// Resize image to new height
Image::make('img/foo.jpg')->heighten(100);

// Resize image to new height and allow upsizing
Image::make('img/foo.jpg')->heighten(100, true);
```

#### crop()

Cut out a rectangular part of the current image with given width and height. Define optional **x,y** coordinates to move the **top-left corner** of the cutout to a specific position.

```php
Image::make('img/foo.jpg')->crop(100, 100, 25, 25);
```

#### trim()

Trim away image space in given color. Define an optional base to pick a color at a certain position and borders that should be trimmed away. You can also set an optional tolerance level, to trim similar colors and add a feathering border around the trimed image.

```php
// Trim image (by default on all borders with top-left color)
Image::make('img/foo.jpg')->trim();

// Trim image (on all borders with bottom-right color)
Image::make('img/foo.jpg')->trim('bottom-right');

// Trim image (only top and bottom with transparency)
Image::make('img/foo.jpg')->trim('transparent', ['top', 'bottom']);

// Trim image (only left side top-left color)
Image::make('img/foo.jpg')->trim('top-left', 'left');

// Trim image on all borders (with 40% tolerance)
Image::make('img/foo.jpg')->trim('top-left', null, 40);

// Trim image and leave a border of 50px by feathering
Image::make('img/foo.jpg')->trim('top-left', null, 25, 50);
```

### Adjusting Images

Use the following methods to adjust various aspects of images.

#### encode()

Encodes the current image in given **format** and *optional* image **quality**. Quality supports values from 0 (poor quality, small file) to 100 (best quality, big file). Quality is only applied when encoding JPGs.

Define the encoding format from one of the following formats:

- **jpg** — Return JPEG encoded image data
- **png** — Return Portable Network Graphics (PNG) encoded image data
- **gif** — Return Graphics Interchange Format (GIF) encoded image data
- **tif** — Return Tagged Image File Format (TIFF) encoded image data
- **bmp** — Return Bitmap (BMP) encoded image data
- **ico** — Return ICO encoded image data
- **psd** — Return Photoshop Document (PSD) encoded image data
- **webp** — Return WebP encoded image data

```php
// Encode png image as jpg.
Image::make('img/foo.png')->encode('jpg', 75);
```

#### quality()
#### gamma()
#### brightness()
#### contrast()
#### colorize()
#### greyscale()
#### invert()
#### mask()
#### flip()

### Applying Effects

Use the following methods to apply effects to images.

- filter()
- pixelate()
- rotate()
- blur()

### Drawing

Use the following methods to draw on images.

- text()
- pixel()
- line()
- rectangle()
- circle()
- ellipse()

## Outputting Images

Use output methods to display image data from an image object. The `img` method is used by default.

- img($alt = null, array $attributes = [])
- url(array $parameters = [], $secure = null)
- base64()
- path()
- inline($alt = null, array $attributes = [])
- css()
- data()

### Responsive Images
- sourcesets
