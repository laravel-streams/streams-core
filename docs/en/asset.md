# Asset

- [Introduction](#introduction)
	- [Assets](#assets)
	- [Collections](#collections)
	- [Filters](#filters)
	- [Paths](#paths)
- [Basic Usage](#basic-usage)
	- [Adding Assets](#adding-assets)
	- [Dumping Output](#output)

<hr>

<a name="introduction"></a>
## Introduction

PyroCMS provides a powerful asset management right out of the box. Built around the [Assetic](https://github.com/kriswallsmith/assetic) framework by Kris Wallsmith, the asset service provides a fluent API for managing collections of assets.

The `\Anomaly\Streams\Platform\Asset\Asset` class makes it easy to add assets to a collection, manipulate the collection and/or it's assets with filters, then dump the result and include it in your markup.

<a name="assets"></a>
### Assets

An asset is a file with _filterable_ content that can be loaded and dumped.

<a name="collections"></a>
### Collections

Collections are used to organize the assets you are working with. Assets in a collection can be combined or used individually.

<div class="alert alert-info">
<strong>Note:</strong> Collections are <em>always</em> named such that it reflects the desired output name.
</div>

	$asset->add("collection.css", "theme::example.scss");
	$asset->add("collection.js", "theme::example.js");

<a name="filters"></a>
### Filters

Filters are used to mutate the content of the assets.

<div class="alert alert-info">
<strong>Note:</strong> Filters can be applied to individual assets in a collection as well as the entire collection.
</div>

	$asset->add("collection.css", "theme::example.scss", ["min", "live"]);

#### Available Filters

- `min`: minifies content
- `less`: parses LESS into CSS
- `styl`: parses STYL into CSS
- `scss`: parses SCSS into CSS
- `parse`: parses content with Twig
- `coffee`: compiles CoffeeScript into Javascript
- `embed`: embeds image data in your stylesheets
- `live`: refreshes content when LIVE_ASSETS is enabled

#### Automatic Filters

`scss`, `less`, `styl`, and `coffee` filters are are applied automatically to matching files.

You may wish to use files that use an alternate syntax like LESS for CSS or Coffee for Javascript. In most cases you do not need to manually add filters to compile these assets to relevant syntax for output. Simply add them along with your other assets.

	$asset
		->add('theme.css', 'example::styles/example.css')
		->add('theme.css', 'example::styles/example.less')
		->add('theme.css', 'example::styles/example.scss')
		->add('theme.css', 'example::styles/example.styl');

<a name="paths"></a>
### Paths

To avoid having to use full paths to your assets there are a number of path hints available. Hints are a namespace that prefixes the asset path.

	"theme::js/initialize.js"
	
	"anomaly.module.products::js/initialize.js"

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

	$asset->addPath("foo", base_path("example/path"));
	
	$asset->add("scripts.js", "foo::extra.js"); // example/path/extra.js

<hr>

<a name="basic-usage"></a>
## Basic Usage

The `Anomaly\Streams\Platform\Asset\Asset` class provides access to Asset services. Simply inject the class into your own to get started.

	<?php namespace Anomaly\ExampleModule\Http\Controller;
	
	use Anomaly\Streams\Platform\Asset\Asset;
	use Anomaly\Streams\Platform\Http\Controller\PublicController;
	
	class ExampleController extends PublicController
	{
		public function index(Asset $asset)
		{
			$asset->add('example.css', 'module::css/main.css');
			$asset->add('example.js', 'module::js/main.js');
		}
	}
	
<a name="adding-assets"></a>
### Adding Assets

For example, let's import the asset manager into a controller and add an asset to an asset collection:

	<?php namespace Anomaly\ExampleModule\Http\Controller;
	
	use Anomaly\Streams\Platform\Asset\Asset;
	use Anomaly\Streams\Platform\Http\Controller\PublicController;
	
	class ExampleController extends PublicController
	{
		public function index(Asset $asset)
		{
			$asset->add('example.css', 'module::css/main.css');
			$asset->add('example.js', 'module::js/main.js');
		}
	}

The asset class is available on base controllers and can be accessed quickly like this:

    $this->asset->add('example.css', 'module::css/main.css');

#### Adding Single Assets

Assets can be added by specifying their path from your application root:

	$asset->add('example.css', 'public/main.css');

#### Adding Multiple Assets

Adding multiple assets to a collection is easy.

	$asset->add('main.css', 'module::css/main.css');
	
	$asset
		->add('main.css', 'module::css/extra.css');
		->add('main.css', 'module::css/example.less');

<div class="alert alert-info">
<strong>Note:</strong> The asset class is a singleton. Loaded assets are carried throughout your application request.
</div>

<a name="output"></a>
### Dumping Output

Whenever you call an output method for a collection the output is dumped and the resulting output is returned.

<div class="alert alert-warning">
<strong>Caution:</strong> The collection output is only processed when necessary. If you find your assets are not refreshing during development, enable LIVE_ASSETS in your .env file and add the "live" filter.
</div>

#### Combining Assets

To combine the assets in a collection and return the dumped content path use the `path` method. An optional array of filters to apply to the entire collection can be passed as the second parameter.

	$asset->path("collection.js");
	$asset->path("collection.js", ["min"]);
	
	url($path);

You can quickly return the URL to a asset dump via the `UrlGenerator` by using the `url` method:

	$asset->url('example.css', $filters = [], $parameters = [], $secure = null);
	
To return the combined assets as a tag use the `style` or `script` method:

	$asset->style("example.css", $filters = [], $attributes = []);
	$asset->script("example.js", $filters = [], $attributes = []);

#### Dumping Individual Assets

You can also extract the individual assets from a collection. The assets are filtered all the same.

	for ($asset->paths("collection.js", ["min"]) as $path) {
		echo url($path);
	}

The same approach can be used for extracting individual asset URLs and tags:

	$asset->urls('example.css', $filters = [], $parameters = [], $secure = null);

	$asset->styles("example.css", $filters = [], $attributes = []);
	$asset->scripts("example.js", $filters = [], $attributes = []);

#### Displaying Content Inline

The `inline` method can be used to return the dumped content as a string:

	echo $asset->inline("example.css");
