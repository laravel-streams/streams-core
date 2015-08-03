# Image

- [Introduction](#introduction)
- [Configuration](#configuration)
- [Image Usage](#image-usage)
	- [Working With Images](#working-with-images)
	- [Obtaining Cached Output Images](#obtaining-cached-output-images)


<a name="introduction"></a>
## Introduction

The Streams Platform provides powerful image manager for your application based on the [Intervention Image](https://github.com/Intervention/image) framework by Oliver Vogel.

The image manager let's you access and manipulate images anywhere in your application without the hassle of publishing them.

<a name="configuration"></a>
## Configuration

The asset configuration is located at `vendor/anomaly/streams-platform/resources/config/images.php` which can be overridden by creating your own configuration file at `config/streams/images.php`.


<a name="image-usage"></a>
## Image Usage

<a name="working-with-images"></a>
### Working With Images

The `Anomaly\Streams\Platform\Image\Image` class provides access to the image manager.

For example, let's import the image manager into a controller make an image, ready for further use:

	<?php namespace Anomaly\ExampleModule\Http\Controller;
	
	use Anomaly\Streams\Platform\Image\Image;
	use Anomaly\Streams\Platform\Http\Controller\PublicController;
	
	class ExampleController extends PublicController
	{
		public function(Image $image)
		{
			$example = $image->make('module::images/example.jpg');
		}
	}

#### Making Images From Other Sources

In addition to making an image using a prefixed path, you may also pass an instance of the `Anomaly\FilesModule\File\Contract\FileInterface`:

	$example = $image->make($repository->find(1));

Or a remote path:

	$example = $image->make('http://example.com/images/example.jpg');

#### Manipulating Images

You can manipulate images by using [Intervention Image API methods](http://image.intervention.io/). Of course, you can chain methods in a fluent style too.

	$example = $image->make('module::images/example.jpg');
	
	$example
		->resize(851, 315)
		->greyscale();

You may also add attributes for use with the `image` method described below. **NOTE: Any methods that do not match a *supported* Intervention Image API method will add attributes to the image.**

	$example = $image->make('module::images/example.jpg');
	
	$example
		->width('100%')         // width="100%"
		->class('img-rounded'); // class="img-rounded"

<a name="obtaining-cached-output-images"></a>
### Obtaining Cached Output Images

The `path` method on the image manager is used to process and retrieve the path to the cached output image. If the output image does not exist, or the source image has been modified, the image will reprocess.

	$example = $image->make('module::images/example.jpg');
	
	// Manipulate image
	
	$path = $example->path();

The `image` method on the image manager wraps the `path` method in an `<img>` tag. You may pass an optional second argument specifying the `alt` attribute, as well as a third argument specifying additional attributes to be added to the `<img>` tag:

	$avatar = $image->make('module::images/example.jpg');
	
	$tag = $avatar
		->resize(100, 100)
		->greyscale()
		->width(48)
		->class('img-rounded')
		->image('Ryan Thompson');
		
	// <img src="http://yourdomain.com/path/to/modified.jpg" width="48" class="img-rounded" alt="Ryan Thompson">
