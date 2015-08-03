# Asset

- [Introduction](#introduction)
	- [Collections](#collections)
	- [Filters](#filters)
- [Configuration](#configuration)
- [Asset Usage](#asset-usage)
	- [Adding Assets To A Collection](#adding-assets-to-a-collection)
	- [Obtaining Cached Output Files](#obtaining-cached-output-files)
	- [Obtaining Cached Output Tags](#obtaining-cached-output-tags)


<a name="introduction"></a>
## Introduction

The Streams Platform provides powerful asset manager for your application based on the [Assetic](https://github.com/kriswallsmith/assetic) framework by [Kris Wallsmith](http://kriswallsmith.net).

<a name="collections"></a>
### Collections

A collection is simply a collection of files that you would like to group together, with some properties attached to tell the asset manager how to do its job. Such properties include the filters which should be applied, the type of file to output, or the location where the source files reside.

When defining collections, you MUST include a file extension that represents the type of file you wish to output. If working with LESS, SACC, Stylus or CSS you might want to use `example.css` as a collection. If working with Coffee Script or Javascript you might want to use `example.js`.

<a name="filters"></a>
### Filters

Filters are simple flags that tell the asset manager how to manipulate an asset or entire asset collection. For example the `min` filter will minify a single asset or an entire asset collection.

#### Available Filters

`min`: runs the asset or asset collection through the appropriate minification filter.

`parse`: runs the asset or asset collection through the Twig parser. Compiler filters also parse when compiling.

`less`: runs the asset or asset collection through the LESS CSS compiler. Automatically applied to .less files.

`styl`: runs the asset or asset collection through the Stylus CSS compiler. Automatically applied to .styl files.

`scss`: runs the asset or asset collection through the SASS CSS compiler. Automatically applied to .scss files.

`coffee`: runs the asset or asset collection through the Coffee JS compiler. Automatically applied to .coffee files.

`embed`: embeds referenced images as base64 encoded data URIs.


<a name="configuration"></a>
## Configuration

The asset configuration is located at `vendor/anomaly/streams-platform/resources/config/assets.php` which can be overridden by creating your own configuration file at `config/streams/assets.php`.


<a name="asset-usage"></a>
## Asset Usage

<a name="adding-assets-to-collections"></a>
### Adding Assets To A Collection

The `Anomaly\Streams\Platform\Asset\Asset` class provides access to Asset services.

For example, let's import the asset manager into a controller and add an asset to an asset collection:

	<?php namespace Anomaly\ExampleModule\Http\Controller;
	
	use Anomaly\Streams\Platform\Asset\Asset;
	use Anomaly\Streams\Platform\Http\Controller\PublicController;
	
	class ExampleController extends PublicController
	{
		public function(Asset $asset)
		{
			$asset->add('example.css', 'module::css/main.css');
			$asset->add('example.js', 'module::js/main.js');
		}
	}

#### Adding Multiple Assets

You can add multiple assets to the same collection by chaining or calling the `add` method multiple times using the same collection. The asset manager is a singleton so the same instance is accessible anywhere in your application.

	$asset->add('main.css', 'module::css/main.css');
	
	$asset
		->add('main.css', 'module::css/extra.css');
		->add('main.css', 'module::css/example.css');

#### Automatic Compiler Detection

You may wish to use files that use an alternate syntax like LESS for CSS or Coffee for Javascript. In most cases you do not need to manually add filters to compile these assets to relevant syntax for output. Simply add them along with your other assets.

	$asset
		->add('theme.css', 'example::styles/example.css')
		->add('theme.css', 'example::styles/example.less')
		->add('theme.css', 'example::styles/example.scss')
		->add('theme.css', 'example::styles/example.styl');

<a name="obtaining-cached-output-files"></a>
### Obtaining Cached Output Files

The `path` method on the asset manager is used to compile and retrieve the path to the cached output file. If the file does not exist, or any included asset has been modified, the file will recompile. If you wish, you may pass a second argument specifying additional filters to apply to the entire collection:

	$path = $asset->path('example.js');
	
	$path = $asset->path('example.js', ['min']);

#### Obtaining Individual Asset Output

The `paths` method on the asset manager is used to compile and retrieve an `array` of paths to each individual asset in a collection. Each output is cached in a similar fashion as the `path` method. You may again pass a second argument specifying additional filters to be applied to *each asset*.

	$paths = $asset->paths('examples.js');
	
	$paths = $asset->path('examples.js', ['min']);

<a name="obtaining-cached-output-tags"></a>
### Obtaining Cached Output Tags

The `style` method on the asset manager wraps the `path` method in a `<style>` tag. In addition to a second argument specifying additional filters to apply, you may also pass a third argument specifying attributes to be added to the `<style>` tag:

	$tag = $asset->style('example.css');
	
	$tag = $asset->style('example.css', ['min'], ['media' => 'print']);

The `script` method on the asset manager wraps the `path` method in a `<script>` tag. In addition to a second argument specifying additional filters to apply, you may also pass a third argument specifying attributes to be added to the `<script>` tag:

	$tag = $asset->style('example.css');
	
	$tag = $asset->style('example.css', ['min'], ['media' => 'print']);

#### Obtaining Individual Asset Tags

The `styles` method on the asset manager wraps the `paths` method in `<style>` tags. In addition to a second argument specifying additional filters to apply to each asset, you may also pass a third argument specifying attributes to be added to the `<style>` tag:

	$tags = $asset->styles('example.css');
	
	$tags = $asset->styles('example.css', ['min'], ['media' => 'print']);

The `scripts` method on the asset manager wraps the `paths` method in `<script>` tags. In addition to a second argument specifying additional filters to apply to each asset, you may also pass a third argument specifying attributes to be added to the `<script>` tag:

	$tags = $asset->scripts('example.js');
	
	$tags = $asset->scripts('example.js', ['min'], ['defer']);