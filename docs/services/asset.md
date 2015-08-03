# Asset

- [Introduction](#introduction)
	- [Configuration](#configuration)
- [Collections](#collections)
- [Filters](#filters)
	- [Minify](#minify)	


<a name="introduction"></a>
## Introduction

The Asset service is a simple and powerful asset manager for your application. `Anomaly\Streams\Platform\Asset\Asset` class helps you manage and use assets in your application and various addons.

The Asset service implements the popular [Assetic](https://github.com/kriswallsmith/assetic) package.

<a name="configuration"></a>
### Configuration

The Asset service has one configuration `streams::assets.paths` which holds a `prefix => path` array of additional path hints.

	'paths' => [
		'extra' => 'public/assets/extra'
	]

The above assets can now be accessed like:
	
	$asset->add('collection.css', 'extra::css/foo.css');

The configuration file is located at `vendor/anomaly/streams-platform/resources/config/assets.php` and can be overridden by placing making your own file at `config/streams/assets.php`.


<a name="collections"></a>
## Collections

A collection is simply a collection of files you would like to group together. Collections are named like a file where the extension denotes the type of asset file(s) they should produce. To add an asset to a collection use the add method:

	$asset->add('collection.css', 'prefix::path/to/asset.css', ['filter']);

The Asset service uses a fluent API so you can chain as many methods as you like.

Below is an example of adding multiples files to a single collection, combining those files and outputting a single file path with all the assets processed, combined and ready to go:

	$asset
		->add('example.css', 'prefix::path/to/asset.css')
		->add('example.css', 'prefix::path/to/asset.less')
		->add('example.css', 'prefix::path/to/asset.scss');
	
	$asset->path('example.css'); // Returns `public/assets/{application}/{hash}.css

Here is a similar example of how to do almost the same thing, but output a path for each asset:

	$asset
		->add('example.js', 'prefix::path/to/asset.js')
		->add('example.js', 'prefix::path/to/asset.coffee')
		->add('example.js', 'prefix::path/to/asset.jsx');
	
	$asset->paths('example.js') // Returns array of compiled .js files


<a name="filters"></a>
## Filters

Filters are simple flags that manipulate your assets. For example, to minify a CSS file just add the `min` filter.

	$asset->add('collection.css', 'prefix::path/to/asset.css', ['min']);

You may also apply filters to an entire collection of assets.

	$asset->path('collection.js', ['min']);

Some filters are applied automatically. Adding a .less file will automatically add the `less` filter.

	$asset->add('collection.css', 'prefix::path/to/asset.less');


<a name="min-filter"></a>
### `min`

The `min` filter runs the asset or asset collection through the appropriate minification filter.