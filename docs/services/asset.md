# Asset

- [Introduction](#introduction)
	- [Configuration](#configuration)
- [Collections](#collections)
	- [Generating Output](#generating-output)
- [Filters](#filters)
	- [Available Filters](#available-filters)


<a name="introduction"></a>
## Introduction

The Asset service is a simple and powerful asset manager for your application. It helps you manage, manipulate and use assets in your application and various addons.

	use Anomaly\Streams\Platform\Asset\Asset;

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

The Asset service uses a fluent API so you can chain as many methods as you like. **Note that collections MUST include a file extension reflecting their desired output file extension.**

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

<a name="generating-output"></a>
### Generating Output

#### path($collection, array $filters = [])

	$asset->path('print.css', ['min']);

Returns the file path for the combined assets in `$collection` after processing. The `$filters` array will be added to existing asset filters.

#### paths($collection, array $filters = [])

Similar to the path method, returns an array of file paths for each asset in `$collection` after processing. The `$filters` array will be added to each asset's existing filters.

#### `style($collection, array $filters = [], array $attributes = [])`

Returns the a `<style>` tag for the combined assets in `$collection` after processing. The `$filters` array will be added to existing asset filters. The `$attributes` will be added as HTML attributes to the style tag.

#### `styles($collection, array $filters = [], array $attributes = [])`

Similar to the style method, returns an array of `<style>` tags for each asset in `$collection` after processing. The `$filters` array will be added to each asset's existing filters. The `$attributes` will be added as HTML attributes to each style tag.

#### `script($collection, array $filters = [], array $attributes = [])`

Returns the a `<script>` tag for the combined assets in `$collection` after processing. The `$filters` array will be added to existing asset filters. The `$attributes` will be added as HTML attributes to the script tag.

#### `scripts($collection, array $filters = [], array $attributes = [])`

Similar to the script method, returns an array of `<script>` tags for each asset in `$collection` after processing. The `$filters` array will be added to each asset's existing filters. The `$attributes` will be added as HTML attributes to each script tag.


<a name="filters"></a>
## Filters

Filters are simple flags that manipulate your assets. For example, to minify a CSS file just add the `min` filter.

	$asset->add('collection.css', 'prefix::path/to/asset.css', ['min']);

You may also apply filters to an entire collection of assets.

	$asset->path('collection.js', ['min']);

Some filters are applied automatically. Adding a .less file will automatically add the `less` filter.

	$asset->add('collection.css', 'prefix::path/to/asset.less');


<a name="available-filters"></a>
### Available Filters

`min`: runs the asset or asset collection through the appropriate minification filter.

`parse`: runs the asset or asset collection through the Twig parser. Compiler filters also parse when compiling.

`less`: runs the asset or asset collection through the LESS CSS compiler. Automatically applied to .less files.

`styl`: runs the asset or asset collection through the Stylus CSS compiler. Automatically applied to .styl files.

`scss`: runs the asset or asset collection through the SASS CSS compiler. Automatically applied to .scss files.

`coffee`: runs the asset or asset collection through the Coffee JS compiler. Automatically applied to .coffee files.

`embed`: embeds referenced images as base64 encoded data URIs.