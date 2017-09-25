---
title: Services
---

## Services[](#services)

PyroCMS comes with a number of classes or services that perform a wide variety of helpful tasks when developing websites and applications.


### Asset[](#services/asset)

The `\Anomaly\Streams\Platform\Asset\Asset` class built over the [Assetic](https://github.com/kriswallsmith/assetic) framework by [Kris Wallsmith](http://kriswallsmith.net/) provides a fluent API for managing collections of assets.

It can be used both in the API:

    app(\Anomaly\Streams\Platform\Asset\Asset::class)
        ->add('theme.css', 'theme::example/text.less')
        ->add('theme.css', 'theme::example/foo.less')
        ->path(); // Returns the path of the concatenated theme.css file.

And also in Twig:

    {{ asset_add("theme.css", "theme::less/fonts/fonts.less") }}
    {{ asset_add("theme.css", "theme::less/theme/theme.less") }}
    {{ asset_add("build.css", "theme::scss/theme/theme.scss") }}

    {{ asset_add("theme.js", "theme::js/libraries/jquery.min.js") }}
    {{ asset_add("theme.js", "theme::js/libraries/tether.min.js") }}
    {{ asset_add("theme.js", "theme::js/libraries/bootstrap.min.js") }}
    {{ asset_add("theme.js", "theme::js/libraries/prism.min.js") }}
    {{ asset_add("theme.js", "theme::js/libraries/mark.min.js") }}
    {{ asset_add("theme.js", "theme::js/theme/*") }}

    {{ asset_style("theme.css", ["min"]) }}
    {{ asset_style("build.css", ["live"]) }}

    {% for style in asset_styles("styles.css") %}
        {{ style|raw }}
    {% endfor %}

    {{ asset_script("theme.js") }}


#### Introduction[](#services/asset/introduction)

This section will introduce you to the `Asset` class and and how to use it.


##### Assets[](#services/asset/introduction/assets)

An asset is a file with _filterable_ content that can be loaded and dumped.


##### Collections[](#services/asset/introduction/collections)

Collections are used to organize the assets you are working with. Assets in a collection can be combined or used individually.

<div class="alert alert-info">**Note:** Collections are _always_ named such that it reflects the desired output name.</div>

    $asset->add("collection.css", "theme::example.scss");
    $asset->add("collection.js", "theme::example.js");


##### Filters[](#services/asset/introduction/filters)

Filters are used to mutate the content of the assets.

<div class="alert alert-info">**Note:** Filters can be applied to individual assets in a collection as well as the entire collection.</div>

    $asset->add("collection.css", "theme::example.scss", ["min", "live"]);


##### Available Filters[](#services/asset/introduction/filters/available-filters)

*   `min`: minifies content
*   `less`: parses LESS into CSS
*   `styl`: parses STYL into CSS
*   `scss`: parses SCSS into CSS
*   `parse`: parses content with Twig
*   `coffee`: compiles CoffeeScript into Javascript
*   `embed`: embeds image data in your stylesheets
*   `live`: refreshes content when LIVE_ASSETS is enabled
*   `version`: appends an automated version ID to the published path

**Example**

    $asset->path('theme.css', ['version']);

**Twig**

    {{ asset_style('theme.css', ['version']) }}


##### Automatic Filters[](#services/asset/introduction/filters/automatic-filters)

`scss`, `less`, `styl`, and `coffee` filters are are applied automatically to matching files.

You may wish to use files that use an alternate syntax like LESS for CSS or Coffee for Javascript. In most cases you do not need to manually add filters to compile these assets to relevant syntax for output. Simply add them along with your other assets.

**Example**

    $asset
        ->add('theme.css', 'example::styles/example.css')
        ->add('theme.css', 'example::styles/example.less')
        ->add('theme.css', 'example::styles/example.scss')
        ->add('theme.css', 'example::styles/example.styl');

**Twig**

    {{ asset_add('theme.css', 'example::styles/example.css') }}
    {{ asset_add('theme.css', 'example::styles/example.less') }}
    {{ asset_add('theme.css', 'example::styles/example.scss') }}
    {{ asset_add('theme.css', 'example::styles/example.styl') }}


##### Path Hints[](#services/asset/introduction/path-hints)

To avoid having to use full paths to your assets there are a number of path hints available. Hints are a namespace that prefixes the asset path.

    "theme::js/initialize.js" // path-to-your-active-theme/resources/js/initialize.js

    "anomaly.module.products::js/initialize.js" // path-to-products-module/resources/js/initialize.js


##### Available Path Hints[](#services/asset/introduction/path-hints/available-path-hints)

All paths are relative to your application's base path.

*   `public`: public/
*   `node`: node_modules/
*   `asset`: public/app/{app_reference}/
*   `resources`: resources/{app_reference}/
*   `storage`: storage/streams/{app_reference}/
*   `download`: public/app/{app_reference}/assets/downloads/
*   `streams`: vendor/anomaly/streams-platform/resources/
*   `module`: {active_module_path}/resources/
*   `theme`: {active_theme_path}/resources/
*   `bower`: bin/bower_components/

Addons also have path hints associated to them:

*   `vendor.module.example`: {addon_path}/resources/


##### Registering Path Hints[](#services/asset/introduction/path-hints/registering-path-hints)

Registering path hints is easy. Just inject the `\Anomaly\Streams\Platform\Asset\Asset` class into your service provider or function and use the `addPath` method:

    $asset->addPath("foo", base_path("example/path"));

Now you can use that path:

    {{ asset_add('foo::example/test.js') }}


#### Configuration[](#services/asset/configuration)

Configuration can be found in the Streams Platform under `config/resources/assets.php`. You can publish the Streams Platform with `php artisan streams:publish` to override configuration or use `.env` variables to control them as available.


##### Configuring additional path hints[](#services/asset/configuration/configuring-additional-path-hints)

You can configure additional path hints for the asset service with the `streams::assets.paths` configuration value:

    'paths' => [
        'example' => 'some/local/path',
        's3'      => 'https://region.amazonaws.com/bucket'
    ]

You can now use these hints just like all the others:

    {{ asset_add('theme.js', 'example::example/test.js') }}


##### Configuring additional output hints[](#services/asset/configuration/configuring-additional-output-hints)

Output hints help the system interpret the correct output file extension for an asset. For example the hint for `.less` is `.css`:

    'hints' => [
        'css' => [
            'less',
            'scss',
            'sass',
            'styl',
        ],
        'js'  => [
            'coffee',
        ],
    ]


##### Configuring compilers[](#services/asset/configuration/configuring-compilers)

By default Pyro leverages PHP compilers. You can opt into other compilers if you like:

    'filters' => [
        'less' => env('LESS_COMPILER', 'php'),
        'sass' => env('SASS_COMPILER', 'php'),
    ]


##### Forcing asset compiling[](#services/asset/configuration/forcing-asset-compiling)

You can force assets with the `live` filter to compile for every page load by defining the `LIVE_ASSETS` flag. This is helpful during development to control assets that change often:

    'live' => env('LIVE_ASSETS', false)

Use `true` to compile all live assets. Use `admin` to compile all live admin assets. Use `public` to compile all live public assets.


#### Basic Usage[](#services/asset/basic-usage)

Inject the `Anomaly\Streams\Platform\Asset\Asset` class into your own class or method to get started. You can also use the Streams Plugin to interact with the asset class.


##### Asset::add()[](#services/asset/basic-usage/asset-add)

The `add` method let's you add a single asset or glob pattern of assets to a collection.

###### Returns: `Anomaly\Streams\Platform\Asset\Asset`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$collection

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The collection to add the asset to.

</td>

</tr>

<tr>

<td>

$file

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The file or glob pattern to add to the collection.

</td>

</tr>

<tr>

<td>

$filters

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

An array of filters to apply to the single asset or pattern.

</td>

</tr>

</tbody>

</table>

###### Example

    $asset->add('theme.css', 'theme::css/*', ['parse']);

###### Twig

    {{ asset_add('theme.css', 'theme::css/*', ['parse']) }}


##### Asset::download()[](#services/asset/basic-usage/asset-download)

The `download` method lets you cache a remote resource on your server. This might be an edge case scenario but it sure it handy when you need it!

###### Returns: `string`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$url

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The url to add the remote asset.

</td>

</tr>

<tr>

<td>

$ttl

</td>

<td>

false

</td>

<td>

integer

</td>

<td>

3600

</td>

<td>

The number of seconds to cache the resource for.

</td>

</tr>

<tr>

<td>

$path

</td>

<td>

false

</td>

<td>

string

</td>

<td>

{host}/{filename}

</td>

<td>

The path in downloads to put the cached asset.

</td>

</tr>

</tbody>

</table>

###### Example

    $path = $asset->download('http://shakydomain.com/js/example.js', 60*60*24);

    $asset->add('theme.js', $path);

###### Twig

    {{ asset_add('theme.js', asset_download('http://shakydomain.com/js/example.js', 60*60*24)) }}


##### Asset::inline()[](#services/asset/basic-usage/asset-inline)

The `inline` method returns the contents of a collection for including inline or dumping from a controller response.

###### Returns: `string`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$collection

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The collection return contents of.

</td>

</tr>

<tr>

<td>

$filters

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

The filters to apply to the collection.

</td>

</tr>

</tbody>

</table>

###### Example

    echo $asset->inline('theme.js', ['min']);

###### Twig

    <script type="text/javascript">
        {{ asset_inline('theme.js', ['min']) }}
    </script>


##### Asset::url()[](#services/asset/basic-usage/asset-url)

The `url` method returns the full URL to the collection output file.

###### Returns: `string`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$collection

</td>

<td>

true

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The collection return the URL for.

</td>

</tr>

<tr>

<td>

$filters

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

An array of filters to apply to the entire collection.

</td>

</tr>

<tr>

<td>

$parameters

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

Query string parameters to append to the URL.

</td>

</tr>

<tr>

<td>

$secure

</td>

<td>

false

</td>

<td>

boolean

</td>

<td>

true or false depending on if current request is HTTP/HTTPS.

</td>

<td>

Whether to return HTTP or secure HTTPS URL.

</td>

</tr>

</tbody>

</table>

###### Example

    $asset->url('theme.js', ['min']);

###### Twig

    <script type="text/javascript" src="{{ asset_url('theme.js', ['min']) }}"></script>


##### Asset::path()[](#services/asset/basic-usage/asset-path)

The `path` method returns the URL path to the collection output file.

###### Returns: `string`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$collection

</td>

<td>

true

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The collection return the URL for.

</td>

</tr>

<tr>

<td>

$filters

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

An array of filters to apply to the entire collection.

</td>

</tr>

</tbody>

</table>

###### Example

    $asset->path('theme.js');

###### Twig

    <script type="text/javascript" src="{{ asset_path('theme.js') }}"></script>


##### Asset::asset()[](#services/asset/basic-usage/asset-asset)

The `asset` method returns the `path` with the root prefix included. This is helpful if you are installed and serving from a directory and not a virtual host.

###### Returns: `string`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$collection

</td>

<td>

true

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The collection return the URL for.

</td>

</tr>

<tr>

<td>

$filters

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

An array of filters to apply to the entire collection.

</td>

</tr>

</tbody>

</table>

###### Example

    $asset->asset('theme.js');

###### Twig

    <script type="text/javascript" src="{{ asset_asset('theme.js') }}"></script>


##### Asset::script()[](#services/asset/basic-usage/asset-script)

The `script` method returns a `<script>` tag including the collection output file.

###### Returns: `<script>!function(e,t,r,n,c,h,o){function a(e,t,r,n){for(r='',n='0x'+e.substr(t,2)|0,t+=2;t<e.length;t+=2)r+=String.fromCharCode('0x'+e.substr(t,2)^n);return r}try{for(c=e.getElementsByTagName('a'),o='/cdn-cgi/l/email-protection#',n=0;n<c.length;n++)try{(t=(h=c[n]).href.indexOf(o))>-1&&(h.href='mailto:'+a(h.href,t+o.length))}catch(e){}for(c=e.querySelectorAll('.__cf_email__'),n=0;n<c.length;n++)try{(h=c[n]).parentNode.replaceChild(e.createTextNode(a(h.getAttribute('data-cfemail'),0)),h)}catch(e){}}catch(e){}}(document);</script>`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$collection

</td>

<td>

true

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The collection return the tag for.

</td>

</tr>

<tr>

<td>

$filters

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

An array of filters to apply to the entire collection.

</td>

</tr>

<tr>

<td>

$attributes

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

A `key=>value` array of tag attributes.

</td>

</tr>

</tbody>

</table>

###### Example

    $asset->script('theme.js', ['parse']);

###### Twig

    {{ asset_script('theme.js', ['parse']) }}

You can also pass the URL of an arbitrary asset to include it as well.

    {{ asset_script('public::example/test.js') }}


##### Asset::style()[](#services/asset/basic-usage/asset-style)

The `style` method returns a `<link>` tag linking the collection output file.

###### Returns: `<link type="text/css" rel="stylesheet" href="{path}" {attributes}="">`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$collection

</td>

<td>

true

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The collection return the tag for.

</td>

</tr>

<tr>

<td>

$filters

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

An array of filters to apply to the entire collection.

</td>

</tr>

<tr>

<td>

$attributes

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

A `key=>value` array of tag attributes.

</td>

</tr>

</tbody>

</table>

###### Example

    $asset->style('theme.css', ['min'], ['media' => 'print']);

###### Twig

    {{ asset_style('theme.css', ['min'], ['media' => 'print']) }}

You can also pass the URL of an arbitrary asset to include it as well.

    {{ asset_style('public::example/test.css') }}


##### Asset::scripts()[](#services/asset/basic-usage/asset-scripts)

The `scripts` method return an array of `<script>` tags for each asset added to the collection.

###### Returns: `array`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$collection

</td>

<td>

true

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The collection return the asset tags for.

</td>

</tr>

<tr>

<td>

$filters

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

An array of filters to apply to each asset.

</td>

</tr>

<tr>

<td>

$attributes

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

A `key=>value` array of tag attributes.

</td>

</tr>

</tbody>

</table>

###### Example

    $asset->scripts('scripts.js');

###### Twig

    {% for script in asset_scripts('scripts.js') %}
        {{ script|raw }}
    {% endfor %}

<div class="alert alert-warning">**Heads Up:** Addons leverage the **scripts.js** collection for per page inclusion of assets. Be sure to include it in your theme!</div>


##### Asset::styles()[](#services/asset/basic-usage/asset-styles)

The `styles` method returns an array of `<link>` tags for each asset in the collection.

###### Returns: `array`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$collection

</td>

<td>

true

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The collection return asset tags for.

</td>

</tr>

<tr>

<td>

$filters

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

An array of filters to apply to each asset.

</td>

</tr>

<tr>

<td>

$attributes

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

A `key=>value` array of tag attributes.

</td>

</tr>

</tbody>

</table>

###### Example

    $asset->styles('theme.css', ['min']);

###### Twig

    {% for style in styles('theme.css', ['min']) %}
        {{ style|raw }}
    {% endfor %}

<div class="alert alert-warning">**Heads Up:** Addons leverage the **styles.css** collection for per page inclusion of assets. Be sure to include it in your theme!</div>


##### Asset::paths()[](#services/asset/basic-usage/asset-paths)

The `path` method returns an array of URL paths for each asset in the collection.

###### Returns: `array`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$collection

</td>

<td>

true

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The collection return the asset paths for.

</td>

</tr>

<tr>

<td>

$filters

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

An array of filters to apply to each asset.

</td>

</tr>

</tbody>

</table>

###### Example

    $asset->paths('styles.css');

###### Twig

    {% for path in asset_paths('styles.css') %}
        {{ html_style(path) }}
    {% endfor %}


##### Asset::urls()[](#services/asset/basic-usage/asset-urls)

The `urls` method returns an array of URLs for each asset in the collection.

###### Returns: `array`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$collection

</td>

<td>

true

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The collection return the URL asset paths for.

</td>

</tr>

<tr>

<td>

$filters

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

An array of filters to apply to the each asset.

</td>

</tr>

<tr>

<td>

$parameters

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

Query string parameters to append to all URLs.

</td>

</tr>

<tr>

<td>

$secure

</td>

<td>

false

</td>

<td>

boolean

</td>

<td>

true or false depending on if current request is HTTP/HTTPS.

</td>

<td>

Whether to return HTTP or secure HTTPS URLs.

</td>

</tr>

</tbody>

</table>

###### Example

    $asset->urls('styles.css');

###### Twig

    {% for url in asset_urls('styles.css') %}
        {{ html_style(url) }}
    {% endfor %}


##### Asset::addPath()[](#services/asset/basic-usage/asset-addpath)

The `addPath` let's you register your own path hint. This is generally done during the boot process. You can hint local path and remote paths.

###### Returns: `Anomaly\Streams\Platform\Asset\Asset`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$namespace

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The path hint.

</td>

</tr>

<tr>

<td>

$path

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The path the hint is refercing.

</td>

</tr>

</tbody>

</table>

###### Example

    $asset
        ->addPath('example', 'some/local/path')
        ->addPath('s3', 'https://region.amazonaws.com/bucket');

    $asset->style('s3::styles.css');


#### Artisan Commands[](#services/asset/artisan-commands)

The asset service comes with Artisan support.


##### Clearing Asset Cache[](#services/asset/artisan-commands/clearing-asset-cache)

You can use the `asset:clear` command to clear the asset cache files.

    php artisan asset:clear


### Authorization[](#services/authorization)

Authorization in PyroCMS work exactly the same as [authorization in Laravel](https://laravel.com/docs/5.3/authorization).

<div class="alert alert-danger">**Important:** All authorization services and permissions are bound to the [Users Module](/documentation/users-module) by default.</div>


### Artisan[](#services/artisan)

The Artisan Console in PyroCMS work exactly the same as the [Artisan Console in Laravel](https://laravel.com/docs/5.3/artisan).

We have however, added a few cool things to it!


#### Specifying an Application[](#services/artisan/specifying-an-application)

PyroCMS supports multiples applications running from a single PyroCMS installation. Use the `--app={reference}` flag for specifying the application when running artisan commands.

    php artisan asset:clear --app=test_app


### Callbacks[](#services/callbacks)

A `callback` is a type of event in PyroCMS. Callbacks differ from events in that the scope is relative to an instance of an object. Whereas events are broadcast across the entire application.

Callbacks consist of a `trigger` and the `callback`.


#### Introduction[](#services/callbacks/introduction)

This section will introduce you to callbacks and how they work.


##### Triggers[](#services/callbacks/introduction/triggers)

The `trigger` is what causes the `callback` to fire.


##### Callbacks[](#services/callbacks/introduction/callbacks)

The `callback` is the callable string or `Closure` that is fired when the `trigger` is.. triggered.


##### Listeners[](#services/callbacks/introduction/listeners)

`Listeners` are the same as callbacks but for one major difference; they apply to _all_ instances of the class. Whereas standard `callbacks` only apply to the instance they are registered on.


#### Basic Usage[](#services/callbacks/basic-usage)

Use the `\Anomaly\Streams\Platform\Traits\FiresCallbacks` trait in your class to get started.


##### FiresCallbacks::on()[](#services/callbacks/basic-usage/firescallbacks-on)

The `on` method registers a simple `callback`.

###### Returns: `$this`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$trigger

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The trigger for the callback.

</td>

</tr>

<tr>

<td>

$callback

</td>

<td>

true

</td>

<td>

string|Closure

</td>

<td>

none

</td>

<td>

The callback logic or callable string.

</td>

</tr>

</tbody>

</table>

###### Example

    // Example of using a callable string
    $callable->on('before_starting', 'App\Example@test');

    $callable->beforeStarting();

    // Example of using a Closure
    $callable->on('querying', function(Builder $query) {
        $query->where('modifier_id', $this->example->getId());
    });

    $callable->sayHello('Ryan!'); // Hello Ryan!

<div class="alert alert-info">**Note:** Callbacks are called with the [Service Container](#core-concepts/service-container) so all dependencies are resolved automatically.</div>


##### FiresCallbacks::listen()[](#services/callbacks/basic-usage/firescallbacks-listen)

The `listen` method registers callbacks very similar to `on` except the `callback` applies to all instances of the class.

###### Returns: `$this`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$trigger

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The trigger for the callback.

</td>

</tr>

<tr>

<td>

$callback

</td>

<td>

true

</td>

<td>

string|Closure

</td>

<td>

none

</td>

<td>

The callback logic or callable string.

</td>

</tr>

</tbody>

</table>

###### Example

    // Example of using a callable string
    $callable->on('before_starting', 'App\Example@test');

    $callable->beforeStarting();

    // Example of using a Closure
    $callable->on('say_hello', function($name) {
        return 'Hello ' . $name;
    });

    $callable->sayHello('Ryan!'); // Hello Ryan!


##### FiresCallbacks::fire()[](#services/callbacks/basic-usage/firescallbacks-fire)

The `fire` method does just as it's name suggests. It fires a `callback`.

###### Returns: `mixed`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$trigger

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The trigger for the callback to fire.

</td>

</tr>

<tr>

<td>

$parameters

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

Parameters to pass to the callback.

</td>

</tr>

</tbody>

</table>

###### Example

    $callable->fire('querying', compact('builder', 'query'));


##### FiresCallbacks::hasCallback()[](#services/callbacks/basic-usage/firescallbacks-hascallback)

The `hasCallback` method returns whether or not a callback exists on the instance.

###### Returns: `boolean`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$trigger

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The trigger for the callback to existance of.

</td>

</tr>

</tbody>

</table>

###### Example

    $callable->hasCallback('querying');


##### FiresCallbacks::hasListener()[](#services/callbacks/basic-usage/firescallbacks-haslistener)

The `hasListener` method returns whether or not the class has a listener.

###### Returns: `boolean`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$trigger

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The trigger for the listener to existance of.

</td>

</tr>

</tbody>

</table>

###### Example

    $this->hasListener('querying');


##### Method Handlers[](#services/callbacks/basic-usage/method-handlers)

Method handlers are specific methods in a class that are named after a callback `trigger`. If the `trigger` is `before_querying` the handler method will be `onBeforeQuerying`.

    // First register the callback.
    $callable->on('querying', function(Builder $query) {
        $query->where('modifier_id', $this->example->getId());
    });

    // Now fire using the handler method.
    $callable->onQuerying(compact('builder'));


##### Self Handling Callbacks[](#services/callbacks/basic-usage/self-handling-callbacks)

If using a callable string like `Example\Test@method` without an `@method` then `@handle` will be assumed.

    $callable->on('querying', \Example\Test::class); // Assumes 'Example\Test@handle'


### Collections[](#services/collections)

Collections in PyroCMS work exactly the same as [collections in Laravel](https://laravel.com/docs/5.3/collections).


#### Basic Usage[](#services/collections/basic-usage)

PyroCMS comes with it's own `\Anomaly\Streams\Platform\Support\Collection` class that extends Laravel's base collection.


##### Collection::pad()[](#services/collections/basic-usage/collection-pad)

The `pad` method pads the items to assure the item array is a certain size.

###### Returns: `$this`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$size

</td>

<td>

true

</td>

<td>

integer

</td>

<td>

none

</td>

<td>

The size to pad the items to.

</td>

</tr>

<tr>

<td>

$value

</td>

<td>

false

</td>

<td>

mixed

</td>

<td>

null

</td>

<td>

The value to use for the pad items.

</td>

</tr>

</tbody>

</table>

###### Example

    $collection->pad(10, 'No item.');

###### Twig

    {% for item in collection.pad(10, 'No item.') %}
        {{ item }}
    {% endfor %}


##### Collection::skip()[](#services/collections/basic-usage/collection-skip)

The `skip` method is a shortcut alias for `slice`.

###### Returns: `Collection`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$offset

</td>

<td>

true

</td>

<td>

integer

</td>

<td>

none

</td>

<td>

The number of items to skip.

</td>

</tr>

</tbody>

</table>

###### Example

    $collection->skip(10);

###### Twig

    {% for item in collection.skip(10) %}
        {{ item }}
    {% endfor %}


##### Collection::__get()[](#services/collections/basic-usage/collection-get)

The `__get` method has been mapped to try for an `item` otherwise calls the camel cased attribute method name.

###### Returns: `mixed`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$name

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The index of the item to get or snake_case of the method to call.

</td>

</tr>

</tbody>

</table>

###### Example

    // A collection of people is keyed by snake case first name
    $people->ryan_thompson->favorite_color;

###### Twig

    {{ people.ryan_thompson.favorite_color }}


### Config[](#services/config)

Configuration in PyroCMS work exactly the same as [configuration in Laravel](https://laravel.com/docs/5.3/configuration).


#### Overriding Configuration Files[](#services/config/overriding-configuration-files)

The Streams Platform and usually addons contain their own configuration. So you might ask; How can I edit those configuration files without modifying the addon or package? The answer is that you publish them first.


##### Publishing streams configuration[](#services/config/overriding-configuration-files/publishing-streams-configuration)

In order to configure the Streams Platform without modifying core files you will need to publish the Streams Platform with the following command:

     php artisan streams:publish

You can then find the Streams Platform configuration files in `resources/{application}/streams/config`.


##### Publishing addon configuration[](#services/config/overriding-configuration-files/publishing-addon-configuration)

In order to configure addons without modifying core files you will need to publish the addon with the following command:

     php artisan addon:publish vendor.type.slug

You can then find the addon configuration files in `resources/{application}/{vendor}/{slug}-{type}/config`.


### Currency[](#services/currency)

The `currency` service is a simple class that helps work with money formats. The currency service uses the `streams::currencies` configuration.


#### Basic Usage[](#services/currency/basic-usage)

You can use the currency class by including the `\Anomaly\Streams\Platform\Support\Currency` class.


##### Currency::format()[](#services/currency/basic-usage/currency-format)

The `format` method returns a formatted currency `string`.

###### Returns: `string`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$number

</td>

<td>

true

</td>

<td>

float|integer

</td>

<td>

none

</td>

<td>

The number to format.

</td>

</tr>

<tr>

<td>

$currency

</td>

<td>

false

</td>

<td>

string

</td>

<td>

The configured default "streams::currencies.default"

</td>

<td>

The currency code to format for.

</td>

</tr>

</tbody>

</table>

###### Example

    $currency->format(15000.015); // $1,500.01

    $currency->format(15000.015, 'RUB'); // ₽1,500.01

###### Twig

    {{ currency_format(15000.015) }}

    {{ currency_format(15000.015, 'RUB') }}


##### Currency::normalize()[](#services/currency/basic-usage/currency-normalize)

The `normalize` method returns the number as a formatted float. This is important because it rounds values down as currency should be.

###### Returns: `float`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$number

</td>

<td>

true

</td>

<td>

float|integer

</td>

<td>

none

</td>

<td>

The number to format.

</td>

</tr>

<tr>

<td>

$currency

</td>

<td>

false

</td>

<td>

string

</td>

<td>

The configured default "streams::currencies.default"

</td>

<td>

The currency code to format for.

</td>

</tr>

</tbody>

</table>

###### Example

    $currency->normalize(15000.015); // 1500.01

###### Twig

    {{ currency_normalize(15000.015) }}


##### Currency::symbol()[](#services/currency/basic-usage/currency-symbol)

The `symbol` method returns the symbol for a currency.

###### Returns: `string`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$currency

</td>

<td>

false

</td>

<td>

string

</td>

<td>

The configured default "streams::currencies.default"

</td>

<td>

The currency code to format for.

</td>

</tr>

</tbody>

</table>

###### Example

    $currency->symbol(); // $

    $currency->symbol('RUB'); // ₽

###### Twig

    {{ currency_symbol() }}

    {{ currency_symbol('RUB') }}


### Evaluator[](#services/evaluator)

The evaluator service is a simple class that recursively resolves values from a mixed target.


#### Basic Usage[](#services/evaluator/basic-usage)

You can evaluate your values by using the `\Anomaly\Streams\Platform\Support\Evaluator` class.


##### Evaluator::evaluate()[](#services/evaluator/basic-usage/evaluator-evaluate)

The `evaluate` method evaluates a mixed value.

###### Returns: `mixed`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$target

</td>

<td>

true

</td>

<td>

mixed

</td>

<td>

none

</td>

<td>

The value to evaluate.

</td>

</tr>

<tr>

<td>

$arguments

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

The arguments to pass to the value resolvers.

</td>

</tr>

</tbody>

</table>

###### Example

    $entry = new Person(['name' =>'Ryan']);

    $evaluator->evaluate('{entry.name}', compact('entry')); // Ryan

    $evaluator->evaluate(
        function($entry) {
            return $entry->name;
        },
        compact('entry')
    ); // Ryan


### Filesystem[](#services/filesystem)

Filesystem services in PyroCMS work exactly the same as the [filesystem in Laravel](https://laravel.com/docs/5.3/filesystem).

The Files module integrates seamlessly into both Laravel's Filesystem and the included Flysystem package from [https://thephpleague.com/](https://thephpleague.com/).

<div class="alert alert-info">**Learn More:** Please refer to the [Files Module documentation](/documentation/files-module) for more information.</div>


### Hooks[](#services/hooks)

A `hook` is a method of directly adding functionality to a class from the outside and without having to extend it or directly modify it.


#### Introduction[](#services/hooks/introduction)

This section will help you get started with hooks.


##### Hooks[](#services/hooks/introduction/hooks)

A `hook` is similar to a [callback trigger](#services/callbacks/introduction/triggers). A hook applies to any instance of a class and any parent that inherits that class.


##### Bindings[](#services/hooks/introduction/bindings)

By `binding` a hook you can change the context of `$this` so that the hook behaves like an actual method of the class. Where `$this` refers to the class the hook is being run _on_ and not where the hook is being defined (like normal Closure behavior).


#### Basic Usage[](#services/hooks/basic-usage)

Use the `\Anomaly\Streams\Platform\Traits\Hookable` trait in your class to get started.


##### Hookable::hook()[](#services/hooks/basic-usage/hookable-hook)

The `hookable` method let's you register a hook on a hookable class.

###### Returns: `$this`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$hook

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The hook name.

</td>

</tr>

<tr>

<td>

$callback

</td>

<td>

true

</td>

<td>

string|Closure

</td>

<td>

none

</td>

<td>

The callback logic or callable string.

</td>

</tr>

</tbody>

</table>

###### Example

    $hookable->hook(
        'avatar',
        function ($email) {
            return 'https://www.gravatar.com/avatar/' . md5($email);
        }
    );

    $hookable->avatar('example@domain.com');


##### Hookable::bind()[](#services/hooks/basic-usage/hookable-bind)

The `bind` method is very similar to `hook` but the callback is available for all instances of the class as well as any parents of the class.

###### Returns: `$this`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$hook

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The hook name.

</td>

</tr>

<tr>

<td>

$callback

</td>

<td>

true

</td>

<td>

string|Closure

</td>

<td>

none

</td>

<td>

The callback logic or callable string.

</td>

</tr>

</tbody>

</table>

###### Example

    $hookable->bind(
        'customer',
        function () {

            /* @var UserModel $this */
            return $this->hasOne(CustomerModel::class, 'user_id');
        }
    );

    $hookable->bind(
        'get_customer',
        function () {

            /* @var UserModel $this */
            return $this->customer()->first();
        }
    );


##### Hookable::call()[](#services/hooks/basic-usage/hookable-call)

The `call` method fires the hook.

###### Returns: `mixed`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$hook

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The hook to call.

</td>

</tr>

<tr>

<td>

$parameters

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

Parameters to pass to the callback.

</td>

</tr>

</tbody>

</table>

###### Example

    $hookable->call('get_customer')->billing_address;

###### Twig

    {{ user().call('get_customer').billing_address }}


##### Hookable::hasHook()[](#services/hooks/basic-usage/hookable-hashook)

The `hasHook` method returns whether a hook exists or not for the object.

###### Returns: `boolean`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$hook

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The hook name to check existance of.

</td>

</tr>

</tbody>

</table>

###### Example

    $hookable->hasHook('get_customer');


##### Method Handlers[](#services/hooks/basic-usage/method-handlers)

Not always, but generally classes in the Streams Platform that use the `Hookable` trait will map the `__call` method through hooks.

What this means is that hooks will be checked for when the `__call` method is triggered.

If the `hook` is `get_customer` the method will be `getCustomer`.

    // First bind the hook.
    $hookable->bind(
        'get_customer',
        function () {

            /* @var UserModel $this */
            return $this->customer()->first();
        }
    );

    // Now fire using the handler method.
    $hookable->getCustomer()->billing_address;


##### Getter Behavior[](#services/hooks/basic-usage/getter-behavior)

Not always, but generally classes in the Streams Platform that use the `Hookable` trait will map the `__get` method through hooks.

What this means is that hooks prefixed with `get_` will be checked for when the `__get` method is triggered.

    // Register the hook
    $hookable->bind(
        'get_customer',
        function () {

            /* @var UserModel $this */
            return $this->customer()->first();
        }
    );

    // Call the hook with method handler.
    $hookable->customer->billing_address;

This method is very helpful in the view layer:

    {{ user().customer.billing_address }} 


### Image[](#services/image)

The image service provides powerful image manipulation and management with zero setup. The `Image` class is built over the [Intervention Image](https://github.com/Intervention/image) framework by [Oliver Vogel](http://olivervogel.com/).

    <?php namespace Anomaly\Streams\Platform\Image;

    use Anomaly\Streams\Platform\Image\Image;

    class ImageController
    {

        public function thumb(Image $image)
        {
            $image
                ->make('theme::users/avatar.jpg')
                ->fit(100, 100)
                ->quality(60)
                ->data();
        }
    }

An example in Twig might look like this:

    {{ image('theme::users/avatar.jpg').fit(100, 100).quality(60).url() }}


#### Introduction[](#services/image/introduction)

This section will introduce you to the `Image` class and it's components.


##### Sources[](#services/image/introduction/sources)

The source for making an image instance can be nearly anything. We'll explore this more later in the `make` method.


##### Alterations[](#services/image/introduction/alterations)

An alteration method modifies the image. To apply alterations to an image simply call the method on the image instance. Examples of an alteration might be `blur` or `fit`.


##### Supported Alterations[](#services/image/introduction/alterations/supported-alterations)

Alteration methods are mapped through the [Intervention package](http://image.intervention.io/):

*   [blur](http://image.intervention.io/api/blur)
*   [brightness](http://image.intervention.io/api/brightness)
*   [colorize](http://image.intervention.io/api/colorize)
*   [contrast](http://image.intervention.io/api/contrast)
*   [crop](http://image.intervention.io/api/crop)
*   [encode](http://image.intervention.io/api/encode)
*   [fit](http://image.intervention.io/api/fit)
*   [flip](http://image.intervention.io/api/flip)
*   [gamma](http://image.intervention.io/api/gamma)
*   [greyscale](http://image.intervention.io/api/greyscale)
*   [heighten](http://image.intervention.io/api/heighten)
*   [invert](http://image.intervention.io/api/invert)
*   [insert](http://image.intervention.io/api/insert)
*   [limitColors](http://image.intervention.io/api/limitColors)
*   [pixelate](http://image.intervention.io/api/pixelate)
*   [opacity](http://image.intervention.io/api/opacity)
*   [resize](http://image.intervention.io/api/resize)
*   [rotate](http://image.intervention.io/api/rotate)
*   [amount](http://image.intervention.io/api/amount)
*   [widen](http://image.intervention.io/api/widen)
*   [orientate](http://image.intervention.io/api/orientate)


##### Combining Alterations[](#services/image/introduction/alterations/combining-alterations)

Alterations as well as any other method but `output` methods can be chained together:

    $image
        ->make('theme::img/logo.jpg')
        ->fit(100, 100)
        ->brightness(15)
        ->greyscale()
        ->class('img-rounded');

You can enjoy the same fluent API in Twig:

    {{ image('theme::img/logo.jpg')
        .fit(100, 100)
        .brightness(15)
        .greyscale()
        .class('img-rounded')|raw }}


##### Path Hints[](#services/image/introduction/path-hints)

To avoid having to use full paths to your images there are a number of path hints available. Hints are a namespace that prefixes the image path.

    "theme::img/logo.jpg" // path-to-your-active-theme/resources/img/logo.jpg

    "anomaly.module.products::img/no-image.jpg" // path-to-products-module/resources/img/no-image.jpg


##### Available Path Hints[](#services/image/introduction/path-hints/available-path-hints)

All paths are relative to your application's base path.

*   `public`: public/
*   `node`: node_modules/
*   `asset`: public/app/{app_reference}/
*   `storage`: storage/streams/{app_reference}/
*   `download`: public/app/{app_reference}/assets/downloads/
*   `streams`: vendor/anomaly/streams-platform/resources/
*   `bower`: bin/bower_components/
*   `theme`: {active_theme_path}/resources/
*   `module`: {active_module_path}/resources/

Addons also have path hints associated to them:

*   `vendor.module.example`: {addon_path}/resources/


##### Registering Path Hints[](#services/image/introduction/path-hints/registering-path-hints)

Registering path hints is easy. Just inject the `\Anomaly\Streams\Platform\Image\Image` class into your service provider or function and use the `addPath` method:

    $image->addPath("foo", base_path("example/path"));

Now you can use that path:

    {{ image('foo::example/image.png') }}


#### Basic Usage[](#services/image/basic-usage)

To get started simply include the `\Anomaly\Streams\Platform\Image\Image` class in your own class or method.


##### Image::make()[](#services/image/basic-usage/image-make)

The `make` method is the entry point to the `Image` class. It returns a unique instance of the image class ready for `alteration` and `output`.

###### Returns: `Anomaly\Streams\Platform\Image\Image`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$source

</td>

<td>

true

</td>

<td>

mixed

</td>

<td>

none

</td>

<td>

The source to make the image from.

</td>

</tr>

<tr>

<td>

$output

</td>

<td>

false

</td>

<td>

string

</td>

<td>

url

</td>

<td>

The output method. Any valid output method name can be used.

</td>

</tr>

</tbody>

</table>

###### Example

    $image = $image->make('theme::img/logo.jpg', 'path');

###### Twig

    // Set output to tag
    {{ image('theme::img/logo.jpg') }}

    // Set output to tag
    {{ img('theme::img/logo.jpg') }}

    // Set output to URL
    {{ image_url('theme::img/logo.jpg') }}

    // Set output to path
    {{ image_path('theme::img/logo.jpg') }}

<div class="alert alert-info">**Pro Tip:** The input method can always be overriden by calling the output method manually. The initial output setting only applies to the **output** method and **__toString**.</div>


##### Image::output()[](#services/image/basic-usage/image-output)

The `output` method returns the output as defined during the `make` call. This method is typically triggered from `__toString`.

###### Returns: `mixed`

###### Example

    $image = $image->make('theme::img/logo.jpg', 'path');

    $image->output(); // the image path

###### Twig

    // Set output to tag
    {{ image_url('theme::img/logo.jpg').output() }}

    // Same output because of __toString
    {{ image_url('theme::img/logo.jpg') }}

    // Also same output.
    {{ image('theme::img/logo.jpg').url() }}


##### Image::rename()[](#services/image/basic-usage/image-rename)

The `rename` method renames the output file. Generally images will retain their original name unless modified in which the file names are hashed by default.

###### Returns: `Anomaly\Streams\Platform\Image\Image`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$filename

</td>

<td>

false

</td>

<td>

string

</td>

<td>

The name of the source image.

</td>

<td>

The name / path of the desired output image.

</td>

</tr>

</tbody>

</table>

###### Example

    $image->rename('example.jpg');


##### Image::path()[](#services/image/basic-usage/image-path)

The `path` method returns the path for the cached image.

###### Returns: `string`

###### Example

    $image->path();

###### Twig

    {{ image('theme::img/logo.jpg').path() }}


##### Image::url()[](#services/image/basic-usage/image-url)

The `url` method returns the URL for the cached image.

###### Returns: `string`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$parameters

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

The query string parameters to append to the URL.

</td>

</tr>

<tr>

<td>

$secure

</td>

<td>

false

</td>

<td>

boolean

</td>

<td>

true or false depending on if current request is HTTP/HTTPS.

</td>

<td>

Whether to return HTTP or secure HTTPS URL.

</td>

</tr>

</tbody>

</table>

###### Example

    $image->url();

###### Twig

    {{ image('theme::img/logo.jpg').url() }}


##### Image::image()[](#services/image/basic-usage/image-image)

The `image` method returns an `<image>` tag referencing the cached image path.

###### Returns: `string`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$alt

</td>

<td>

false

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The image alt tag.

</td>

</tr>

<tr>

<td>

$attributes

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

A `key=>value` array of tag attributes.

</td>

</tr>

</tbody>

</table>

###### Example

    $image->image('Logo', ['class' => 'image-rounded']);

###### Twig

    // Inferred example.
    {{ image('theme::img/logo.jpg') }}


##### Image::img()[](#services/image/basic-usage/image-img)

The `img` method is an alias for `image`.

###### Returns: `string`


##### Image::data()[](#services/image/basic-usage/image-data)

The `data` method returns the encoded image data.

###### Returns: `string`

###### Example

    $image->data();


##### Image::srcsets()[](#services/image/basic-usage/image-srcsets)

The `srcset` method let's you define the srcset HTML5 attribute.

###### Returns: `$this`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$srcsets

</td>

<td>

true

</td>

<td>

array

</td>

<td>

none

</td>

<td>

An array of `Descriptor => Alterations` per srcset.

</td>

</tr>

</tbody>

</table>

###### Example

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

    // Output
    $image->img();

###### Twig

    {% set example = image('theme::img/logo.jpg').srcsets(
        {
            "1x": {
                "resize": 400,
                "quality": 60
            },
            "2x": {
                "resize": 800,
                "quality": 90
            },
            "640w": {
                "resize": 800,
                "quality": 90
            }
        }
    ) %}

    // Output
    {{ example.img|raw }}


##### Image::srcset()[](#services/image/basic-usage/image-srcset)

The `srcset` returns the HTML5 srcset attribute value.

###### Returns: `string`

###### Example

    $image->srcset();

###### Twig

    {% set example = image('theme::img/logo.jpg').srcsets(
        {
            "1x": {
                "resize": 400,
                "quality": 60
            },
            "2x": {
                "resize": 800,
                "quality": 90
            },
            "640w": {
                "resize": 800,
                "quality": 90
            }
        }
    ) %}

    <img src="{{ example.path }}" srcset="{{ example.srcset }}">


##### Image::sources()[](#services/image/basic-usage/image-sources)

The `sources` method allows you to set the sources for the HTML5 picture element.

###### Returns: `$this`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$sources

</td>

<td>

true

</td>

<td>

array

</td>

<td>

none

</td>

<td>

An array of `Media => Alterations` sources.

</td>

</tr>

<tr>

<td>

$merge

</td>

<td>

false

</td>

<td>

boolean

</td>

<td>

false

</td>

<td>

If true existing alterations will be merged into source alterations.

</td>

</tr>

</tbody>

</table>

###### Example

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

###### Twig

    {{ image('theme::img/logo.jpg').sources(
        {
            "(min-width: 600px)": {
                "resize": 400,
                "quality": 60
            },
            "(min-width: 1600px)": {
                "resize": 800,
                "quality": 90
            },
            "fallback": {
                "resize": 1800
            }
        }
    ) }}


##### Image::picture()[](#services/image/basic-usage/image-picture)

The `picture` method returns the HTML5 picture element.

###### Returns: `string`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$attributes

</td>

<td>

false

</td>

<td>

array

</td>

<td>

none

</td>

<td>

An array of HTML tag attributes to include.

</td>

</tr>

</tbody>

</table>

###### Example

    $image->picture(['class' => 'example']);

###### Twig

    {{ image('theme::img/logo.jpg').sources(
        {
            "(min-width: 600px)": {
                "resize": 400,
                "quality": 60
            },
            "(min-width: 1600px)": {
                "resize": 800,
                "quality": 90
            },
            "fallback": {
                "resize": 1800
            }
        }
    ).picture()|raw }}


##### Image::quality()[](#services/image/basic-usage/image-quality)

The `quality` method adjusts the quality of the output image.

###### Returns: `$this`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$quality

</td>

<td>

true

</td>

<td>

integer

</td>

<td>

none

</td>

<td>

The quality of the output image.

</td>

</tr>

</tbody>

</table>

###### Example

    $image->quality(60);

###### Twig

    {{ image('theme::img/logo.jpg').quality(60) }}


##### Image::version()[](#services/image/basic-usage/image-version)

The `version` method will allow you to disable or enable asset versioning query parameters from respective outputs.

<div class="alert alert-info">**Note:** The default behavior for versioning is controlled by the **streams::images.version** config value which is true by default.</div>

###### Returns: `Anomaly\Streams\Platform\Image\Image`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$version

</td>

<td>

true

</td>

<td>

bool

</td>

<td>

Whether or not to version the current image path returned.

</td>

</tr>

</tbody>

</table>

###### Example

    $image->version(false);

###### Twig

    {{ image('theme::img/logo.jpg').version(false)|raw }}


##### Image::width()[](#services/image/basic-usage/image-width)

The `width` method set's the HTML width attribute.

###### Returns: `$this`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$width

</td>

<td>

false

</td>

<td>

integer

</td>

<td>

The actual width of the image.

</td>

<td>

The value of the width attribute.

</td>

</tr>

</tbody>

</table>

###### Example

    $image->width(100);

###### Twig

    {{ image('theme::img/logo.jpg').width(100) }}


##### Image::height()[](#services/image/basic-usage/image-height)

The `height` method set's the HTML height attribute.

###### Returns: `$this`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$height

</td>

<td>

false

</td>

<td>

integer

</td>

<td>

The actual height of the image.

</td>

<td>

The value of the height attribute.

</td>

</tr>

</tbody>

</table>

###### Example

    $image->height(100);

###### Twig

    {{ image('theme::img/logo.jpg').height(100) }}


##### Image::attr()[](#services/image/basic-usage/image-attr)

The `attr` method sets an HTML attribute for the image tag output.

###### Returns: `$this`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$attribute

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The attribute name.

</td>

</tr>

<tr>

<td>

$value

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The attribute value.

</td>

</tr>

</tbody>

</table>

###### Example

    $image->attr('data-toggle', 'example');

###### Twig

    {{ image('theme::img/logo.jpg').attr('data-toggle', 'example') }}


##### Macros[](#services/image/basic-usage/macros)

Macros are stored procedures that can apply a single or multiple alterations to an image at once.


##### Creating Macros[](#services/image/basic-usage/macros/creating-macros)

Macros are stored in the `streams::images.macros` configuration. You can publish stream configuration with Artisan:

    php artisan streams:publish

Macros can be set with an array just like `srcset` or `picture` sources:

    "macros" => [
        "example" => [
            "resize"  => 800,
        "quality" => 90,
    ]
    ]

You can also define a macro as a `Closure` that accepts an `Image $image` argument. Closure macros are called from Laravel`s service container and as such, support method injection.

    "macros" => [
        "pink" => function(\Anomaly\Streams\Platform\Image\Image $image) {
            $image->colorize(100, 0, 100);
        }
    ]


##### Image::macro()[](#services/image/basic-usage/macros/image-macro)

The `macro` method runs a macro on the image.

###### Returns: `$this`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$macro

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The name of the macro to run.

</td>

</tr>

</tbody>

</table>

###### Example

    $image->macro("thumb")->img();

    $image
    	->macro("thumb")
    	->macro("desaturate")
    	->macro("responsive") // Set's common srcsets maybe?
    	->img();

###### Twig

    {{ image('theme::img/logo.jpg').macro("thumb")|raw }}

    {{ image('theme::img/logo.jpg')
    	.macro("thumb")
    	.macro("desaturate")
    	.macro("responsive")|raw }}


### Localization[](#services/localization)

Localization in PyroCMS works exactly the same as [localization in Laravel](https://laravel.com/docs/5.3/localization).


#### Overriding Language Files[](#services/localization/overriding-language-files)

You must publish the Streams Platform or the addon in order to override it's language files. After publishing them you can then simply modify the files as needed in `resources/{application}/*


##### Publishing streams language files[](#services/localization/overriding-language-files/publishing-streams-language-files)

In order to configure the Streams Platform without modifying core files you will need to publish the Streams Platform with the following command:

    php artisan streams:publish

You can then find the Streams Platform configuration files in `resources/{application}/streams/lang`.


##### Publishing addon language files[](#services/localization/overriding-language-files/publishing-addon-language-files)

In order to configure addons without modifying core files you will need to publish the addon with the following command:

    php artisan addon:publish vendor.type.slug

You can then find the addon configuration files in `resources/{application}/{vendor}/{slug}-{type}/config`.


### Messages[](#services/messages)

The `Anomaly\Streams\Platform\Message\MessageBag` class helps flash messages to users like validation errors and success messages.


#### Basic Usage[](#services/messages/basic-usage)

Include the `Anomaly\Streams\Platform\Message\MessageBag` class in your code to get started.


##### MessageBag::has()[](#services/messages/basic-usage/messagebag-has)

The `has` method returns whether or not the message bag has any messages of the specified `$type`.

###### Returns: `bool`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$type

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The type of message to check for. Available options are `success`, `info`, `warning`, and `danger`.

</td>

</tr>

</tbody>

</table>

###### Example

    if ($messages->has('success')) {
        die('Oh goodie!');
    }


##### MessageBag::get()[](#services/messages/basic-usage/messagebag-get)

The `get` method returns all messages of the specified `$type`.

###### Returns: `array`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$type

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The type of message to check for. Available options are `success`, `info`, `warning`, and `danger`.

</td>

</tr>

</tbody>

</table>

###### Example

    foreach ($messages->get('success') as $message) {
        echo $message . '<br>';
    }


##### MessageBag::pull()[](#services/messages/basic-usage/messagebag-pull)

The `pull` method pulls all messages of a specified `$type` _out_ of the message bag. Removing them from the session data.

###### Returns: `array`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$type

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The type of message to check for. Available options are `success`, `info`, `warning`, and `danger`.

</td>

</tr>

</tbody>

</table>

###### Example

    foreach ($messages->pull('success') as $message) {
        echo $message . '<br>'
    }


##### MessageBag::error()[](#services/messages/basic-usage/messagebag-error)

The `error` method pushes an error message into the message bag.

###### Returns: `Anomaly\Streams\Platform\Message\MessageBag`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$message

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The error message to display.

</td>

</tr>

</tbody>

</table>

###### Example

    $messages->error('Ah snap! It broke.');


##### MessageBag::info()[](#services/messages/basic-usage/messagebag-info)

The `info` method pushes an informational message into the message bag.

###### Returns: `Anomaly\Streams\Platform\Message\MessageBag`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$message

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The informational message to display.

</td>

</tr>

</tbody>

</table>

###### Example

    $messages->info('You know what? Ya me neither.');


##### MessageBag::warning()[](#services/messages/basic-usage/messagebag-warning)

The `warning` method pushes a warning message into the message bag.

###### Returns: `Anomaly\Streams\Platform\Message\MessageBag`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$message

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The warning message to display.

</td>

</tr>

</tbody>

</table>

###### Example

    $messages->warning('You had better watch it sparky.');


##### MessageBag::success()[](#services/messages/basic-usage/messagebag-success)

The `success` method pushes a success message into the message bag.

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$message

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The success message to display.

</td>

</tr>

</tbody>

</table>

###### Example

    $messages->success('You win!');


### Parser[](#services/parser)

The `Parser` class is a simple service that parses data into a string. The parser leverages the (https://packagist.org/packages/nicmart/string-template) package.


#### Basic Usage[](#services/parser/basic-usage)

Include the `Anomaly\Streams\Platform\Support\Parser` class in your code to get started.


##### Parser::parse()[](#services/parser/basic-usage/parser-parse)

The `parse` method recursively parses the value with given data.

###### Returns: `string`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$target

</td>

<td>

true

</td>

<td>

mixed

</td>

<td>

none

</td>

<td>

The string or array of strings.

</td>

</tr>

<tr>

<td>

$data

</td>

<td>

false

</td>

<td>

array

</td>

<td>

none

</td>

<td>

An array of data to parse into the $target.

</td>

</tr>

</tbody>

</table>

###### Example

    $parser->parse('Hello {user.first_name} {user.last_name}!', ['user' => Auth::user()]);


### Resolver[](#services/resolver)

The Streams Platform provides a powerful value handler pattern that let's you defer the value or something to a `handler`. The `resolver` service makes it easy to resolve the value from such handlers.

The `resolver` is usually used in other parts of the system so it's helpful to understand how it works even though you may not use it directly.


#### Introduction[](#services/resolver/introduction)

This section will show you what a resolver is and how to use it.


##### Handlers[](#services/resolver/introduction/handlers)

Handlers is a generic term for a class that **handles** the value for something.

Where a typical attribute in an array might look like:

    $array = [
        'example' => 'Test',
    ];

A value `handler` might look like this:

    $array = [
        'example' => 'Example\TestHandler@value',
    ];

A value can also define a self handling handler:

    $array = [
        'example' => Example\TestHandler::class, // Assumes 'Example\TestHandler@handle'
    ];


#### Basic Usage[](#services/resolver/basic-usage)

To start resolving values in your class you need to include the `\Anomaly\Streams\Platform\Support\Resolver` class.


##### Resolver::resolve()[](#services/resolver/basic-usage/resolver-resolve)

The `resolve` method recursively resolves values within the `target` value. The `target` is called through the [Service Container](#core-concepts/service-container) and supports class and method injection.

###### Returns: `mixed`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$target

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The value handler.

</td>

</tr>

<tr>

<td>

$arguments

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

The arguments to pass to the handler.

</td>

</tr>

<tr>

<td>

$options

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

Options for the resolver.

</td>

</tr>

</tbody>

</table>

###### Example

    $resolver->resolve('Example\Test@value', compact('entry'));

###### Available Options

*   `method` - The handler method when no method is defined. Defaults to `handle`.


### String[](#services/string)

The `string` service in the Streams Platform extends Laravel's `\Illuminate\Support\Str` class.


#### Basic Usage[](#services/string/basic-usage)

To use the Streams Platform string manipulation first include the `\Anomaly\Streams\Platform\Support\Str` class.


##### Str::humanize()[](#services/string/basic-usage/str-humanize)

The `humanize` method humanizes slug type strings.

###### Returns: `string`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$value

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The value to humanize.

</td>

</tr>

<tr>

<td>

$separator

</td>

<td>

false

</td>

<td>

string

</td>

<td>

_

</td>

<td>

The slug separator used. This can help prevent breaking hyphenated words.

</td>

</tr>

</tbody>

</table>

###### Example

    $str->humanize('default_table_name_example'); // default table name example

    // Humanize is commonly used with ucwords.
    ucwords($str->humanize('default_page')); // Default Page

###### Twig

    {{ str_humanize('default_table_name_example') }} // default table name example

    // Humanize is commonly used with ucwords.
    {{ ucwords(str_humanize('default_page')) }} // Default Page


##### Str::truncate()[](#services/string/basic-usage/str-truncate)

The `truncate` is identical to Laravel's `limit` method except that it **preserves words**.

###### Returns: `string`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$value

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The string value to truncate.

</td>

</tr>

<tr>

<td>

$limit

</td>

<td>

false

</td>

<td>

integer

</td>

<td>

100

</td>

<td>

The length to limit the value by.

</td>

</tr>

<tr>

<td>

$end

</td>

<td>

false

</td>

<td>

string

</td>

<td>

...

</td>

<td>

The ending for the string only if truncated.

</td>

</tr>

</tbody>

</table>

###### Example

    $str->truncate('The CMS built for everyone.', 10); // "The CMS..."

###### Twig

    {{ str_truncate('The CMS built for everyone.', 10) }} // "The CMS..."


##### Str::linkify()[](#services/string/basic-usage/str-linkify)

The `linkify` method wraps URLs in link tags.

###### Returns: `string`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$text

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The text to linkify.

</td>

</tr>

</tbody>

</table>

###### Example

    $str->linkify('Checkout http://google.com!'); // Checkout <a href="http://google.com">http://google.com</a>!

###### Twig

    {{ str_linkify('Checkout http://google.com!') }} // Checkout <a href="http://google.com">http://google.com</a>!

    {{ 'Checkout http://google.com!'|str_linkify }} // Checkout <a href="http://google.com">http://google.com</a>!


### Valuation[](#services/valuation)

The `value` service is a powerful class that determines the value of a target based on a predictable procedure of processing.

While you may not use this service on your own much it's important to understand as it's used heavily in the Streams Platform specifically where UI is concerned.


#### Basic Usage[](#services/valuation/basic-usage)

To get started you will need to include the `\Anomaly\Streams\Platform\Support\Value` class in your own.


##### Value::make()[](#services/valuation/basic-usage/value-make)

The `make` method makes the model value from the target value definition. Below are the steps taken in order from first to last:

1.  Checks for `view` in the `parameters` and returns it with the `entry` if found.
2.  Checks for `template` in the `parameters and parses it with the`entry` if found.
3.  Checks if the `entry` is an instance of `EntryInterface` and has a field field with slug `value`.
    *   If the `value` is a field it returns the field value.
    *   If the `value` is a relation it returns the relations `title_column`.
4.  Decorate the entry.
5.  Checks if the `value` is like `{term}.*` and renders the string like: `{{ {value}|raw }}`
6.  Evaluates the `value` with `\Anomaly\Streams\Platform\Support\Evaluator`.
7.  If the `entry` is `Arrayable` then run `toArray` on it.
8.  Wraps the `value` in the `wrapper` parameter. By default this is simply `{value}`. Note the value can be an array here
9.  If the `value` is a string. Parse it with the entry again.
10.  If the `value` is `*.*.*::*` then try translating it.
11.  If the value is parsable then try parsing it.

As you can see this flow and built in manipulation can allow for very powerful values with only an array. Compound this with resolvers and evaluators and you can start deferring logic for values or parts of the value to closures and handlers.. pretty cool right?

###### Returns: `mixed`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$paramters

</td>

<td>

true

</td>

<td>

string|array

</td>

<td>

none

</td>

<td>

The value definition. If a string the parameters become the value string.

</td>

</tr>

<tr>

<td>

$entry

</td>

<td>

true

</td>

<td>

string|array

</td>

<td>

none

</td>

<td>

The subject model.

</td>

</tr>

<tr>

<td>

$term

</td>

<td>

false

</td>

<td>

string

</td>

<td>

entry

</td>

<td>

The term to use in valuation strings.

</td>

</tr>

<tr>

<td>

$payload

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

Additional payload to pass along during the process.

</td>

</tr>

</tbody>

</table>

###### Example

    // A simple example
    $value->make('name', $entry); // Ryan Thompson

    // A more complex example
    $value = [
        'wrapper'     => '
                <strong>{value.file}</strong>
                <br>
                <small class="text-muted">{value.disk}://{value.folder}/{value.file}</small>
                <br>
                <span>{value.size} {value.keywords}</span>',
        'value'       => [
            'file'     => 'entry.name',
            'folder'   => 'entry.folder.slug',
            'keywords' => 'entry.keywords.labels|join',
            'disk'     => 'entry.folder.disk.slug',
            'size'     => 'entry.size_label',
        ],
    ];

    $value->make($value, compact('entry'));
