# Image

- [Introduction](#introduction)
	- [Sources](#sources)
	- [Alterations](#alterations)
	- [Paths](#paths)
- [Basic Usage](#basic-usage)
	- [Displaying Images](#displaying-images)
	- [Images Sets](#images-sets)
	- [Macros](#macros)

<hr>

<a name="introduction"></a>
## Introduction

Pyro provides powerful image manipulation and management with zero setup. The `Image` manager is built over the [Intervention Image](https://github.com/Intervention/image) framework by Oliver Vogel.

By using `\Anomaly\Streams\Platform\Image\Image` you can easily access, manipulate, and/or dump images from anywhere.

<a name="sources"></a>
### Sources

You can make an image instance from nearly anything. To make an image instance simply call `make($source)` on the Image class.

	public function handle(Anomaly\Streams\Platform\Image\Image $manager)
	{
		$image->make("theme::logo.jpg");
	}

#### Available Sources

You can make an image from a number of different paths.

- **Path:** `$manager->make("anomaly.module.products::img/example.jpg");`
- **URL:** `$manager->make("http://domain.com/example.jpg");`
- **Disk Path:** `$manager->make("local://folder/example.png");`

You can also make an image from an object.

- **File:** `$manager->make($file);`
- **Presenter:** `$manager->make($presenter);`

Lastly, the `FilePresenter` and `FileInterface` both provide fluent access to the image class via the `make` OR `image` class. They are identical.

	$image = $file->make();
	
	echo $file->image()->resize(80)->quality(70)->img();

<div class="alert alert-warning">
<strong>Remember:</strong> The URL source does not support alterations.
</div>

<div class="alert alert-primary">
<strong>Tip:</strong> The image height and width are also set when the source is set.
</div>

<a name="alterations"></a>
### Alterations

There are a number of different ways you can modify an image. To apply alterations to an image simply call the method on the image instance.

	$image
		->resize(800)
		->quality(60);

#### Available Alterations

For more information on parameters for the following supported methods please reference the [Intervention Documentation](http://image.intervention.io).

- `quality`
- `blur`
- `brightness`
- `colorize`
- `contrast`
- `crop`
- `encode`
- `fit`
- `flip`
- `gamma`
- `greyscale`
- `heighten`
- `invert`
- `limitColors`
- `pixelate`
- `opacity`
- `resize`
- `rotate`
- `amount`
- `widen`
- `orientate`

#### Renaming Output Files

You can also alter the filename for the output file. By default, the same filename and path will be used but moved to the `public/app` directory. If alterations are applied the filename will be a hashed string unique the source file and alterations defined.

You can change the filename by using the rename or setFilename methods. They are identical.

	$image->rename("example.jpg");
	
	$image->setFilename("example.jpg");
	
If you specify a path instead of a filename only then the path will be overridden as well.

	$image->rename("my/awesome/directory/example.jpg");
	
	$image->setFilename("my/awesome/directory/example.jpg");

<a name="paths"></a>
### Paths

To avoid having to use full paths to your images there are a number of path hints available. Hints are a namespace that prefixes the image path.

	"theme::img/example.jpg"
	
	"anomaly.module.products::img/example.jpg"

#### Available Path Hints

All paths are relative to your applications base path.

- `public`: public/
- `asset`: public/app/{app_reference}/
- `storage`: storage/streams/{app_reference}/
- `download`: public/app/{app_reference}/assets/downloads/
- `streams`: vendor/anomaly/streams-platform/resources/
- `bower`: bin/bower_components/
- `theme`: {active\_theme\_path}/resources/
- `module`: {active\_module\_path}/resources/

<div class="alert alert-info">
<strong>Note:</strong> Every single addon also registers a prefix for it's resources path like <strong>vendor.module.example</strong>
</div>

#### Registering Path Hints

Registering path hints is super easy:

	$image->addPath("foo", base_path("example/path"));
	
	$image->url("foo::example.jpg");

<hr>

<a name="basic-usage"></a>
## Basic Usage

The `Anomaly\Streams\Platform\Image\Image` class provides access to Image services. Simply inject the class into your own to get started.

	<?php namespace Anomaly\ExampleModule\Http\Controller;
	
	use Anomaly\Streams\Platform\Image\Image;
	use Anomaly\Streams\Platform\Http\Controller\PublicController;
	
	class ExampleController extends PublicController
	{
		public function index(Image $manager)
		{
			$logo = $manager
				->make("theme::images/logo.jpg")
				->blur(10)
				->url();
			
			return $this->view->make("example::view", compact("logo"));
		}
	}

<a name="displaying-images"></a>
### Displaying Images

There are a few different methods available to display images in your code.

#### Returning Image Paths

To return the image URL or path use the `url` or `path` method.

	$image = $manager->make("theme::images/logo.jpg");
	
	$image->path();
	
	$image->url(array $parameters = [], $secure = null);

#### Returning Image Tags

To return an actual `img` HTML tag use the `image` or `img` method. They are identical.

	$image = $manager->make("theme::images/logo.jpg");
	
	$image->img($alt = null, array $attributes = []);

	$image->image($alt = null, array $attributes = []);

#### Returning An Image Response

You can return the encoded string for the image source by using the `encode` method.

	$image = $manager->make("theme::images/logo.jpg");
	
	return $image->encode("jpg", 70);

<a name="image-sets"></a>
### Image Sets

The image manager makes it easy to define and display set's of image like HTML5 `srcsets`. 

#### srsset

To return an HTML5 `srcset` you first need to set the srcsets. Be sure to apply any initial alterations *before* defining your srcsets.

	$image->srcsets(
		[
			"1x" => [
				"resize"  => 400,
				"quality" => 60
			],
			"2x" => [
				"resize"  => 800,
				"quality" => 90
			],
			"640w" => [
				"resize"  => 800,
				"quality" => 90
			]
		]
	);

Next you return the image HTML tag with the `image` or `img` method. The `srcset` attribute will be automatically included.

	return $image->img($alt = null, array $attributes = []);
	
	return $image->image($alt = null, array $attributes = []);

You can also return the `srcset` to use manually with the `srcset` method.

	return $image->srcset();

#### picture

Returning a `picture` is very similar to using `srcset`. To get started you need to set the sources. Again, be sure to apply any initial alterations *before* defining your srcsets.

	$image->sources(
		[
			"(min-width: 600px)" => [
				"resize"  => 400,
				"quality" => 60
			],
			"(min-width: 1600px)" => [
				"resize"  => 800,
				"quality" => 90
			],
			"fallback" => [
				"resize"  => 1800
			]
		]
	);

Next simply use the `picture` method to return the picture HTML tag. An optional array of additional attributes can also be provided.

	return $image->picture(array $attributes = []);

#### Agent Specific Images

Just like `srcset` and `picture` above, the `agents` method provides a mechanism for changing the image displayed based on the environment. In this case the browser agent will cause the alterations to an image to differ at runtime. This means you can use the `agent` method along with normal output methods like `url` and `img`.

To get started set your alterations per agent. You can use any agent matching string like `Firefox` or `Windows` as well as any of the following keywords: `phone`, `mobile`, `tablet`, and `desktop`.

	$image->agents(
		[
			"mobile" => [
				"resize"  => 400,
				"quality" => 60
			],
			"dekstop" => [
				"resize"  => 800,
				"quality" => 90
			],
			"Windows" => [
				"resize"  => [1, 1],
				"quality" => 0
			]
		]
	);
	
Next you can output the image like you normally would:

	$image->encode();
	
	$image->img();
	
	$image->url();

<a name="macros"></a>
### Macros

Macros are stored procedures that can apply a single or multiple alterations to an image at once.

#### Creating Macros

Macros are stored in the `streams::images.macros` config. You can override this configuration file by creating your own at `resources/core/config/streams/images.php`.

Macros can be set with an array just like `srcset` or `picture` sources:

	"macros" => [
		"resize"  => 800,
		"quality" => 90
	]

You can also define a macro as a `Closure` that accepts an `Image $image` argument. Closure macros are called from Laravel`s service container and as such, support direct injection.
	
	"macros" => [
        "pink" => function(\Anomaly\Streams\Platform\Image\Image $image) {
            $image->colorize(100, 0, 100);
        }
    ]

#### Running Macros

Running macros is easy. Just use the `macro` method or call the macro by name.

	$image->macro("thumb");
	
	$image->thumb();

You can also chain macros together and utilize `srcset` within macros.

	$image
		->macro("thumb")
		->macro("desaturate")
		->macro("responsive") // Set's common srcsets.
		->img();