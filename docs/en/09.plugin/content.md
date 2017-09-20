---
title: Plugin
---

## Plugin[](#plugin)

This section will go over how to use the built-in plugin that comes with the Streams Platform.

##### Mapping functions to services

The streams plugin leverages function mapping to handle defining multiple functions within the same object.

For example all functions called that start with `agent_` will be mapped to the `\Jenssegers\Agent\Agent` class. When function mapping is being used the suffix will be camel cased into a method name.

For example `agent_is_mobile()` becomes `$agent->isMobile()` and any parameters are passed along accordingly.


### Addon[](#usage/addon)

The `addon` functions provide access to the `\Anomaly\Streams\Platform\Addon\AddonCollection`.


#### addon[](#usage/addon/addon)

The `addon` function returns a decorated addon instance.

###### Returns: `\Anomaly\Streams\Platform\Addon\AddonPresenter`

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

$identifier

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

The slug or dot namespace of the addon.

</td>

</tr>

</tbody>

</table>

###### Twig

    // Specify as a dot namespace.
    {{ addon('anomaly.module.users').name }} // Users Module

    // Or you can pass the
    // slug if it's unique.
    {{ addon('pages').name }} // Users Module


#### addons[](#usage/addon/addons)

The `addons` method returns a decorated collection of addons.

###### Returns: `\Anomaly\Streams\Platform\Addon\AddonCollection`

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

type

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

The type of addons to return.

</td>

</tr>

</tbody>

</table>

###### Twig

    {{ addons() }} // A collection of all addons.

    // A collection of all modules.
    {% for module in addons('modules') %}
        <p>{{ module.name }} is enabled.</p>
    {% endfor %}


### Agent[](#usage/agent)

The `agent_*` functions map directly to the `\Jenssegers\Agent\Agent` class.

    {{ agent_is("iPhone") }} // boolean

    {{ agent_is_mobile() }} // boolean

    {{ agent_platform() }} // "OS X"

For more information on usage refer to the [jenssegers/agent](https://github.com/jenssegers/agent) documentation.


### Asset[](#usage/asset)

The `asset_*` functions map directly to the ``Anomaly\Streams\Platform\Asset\Asset` class. For more information on usage please refer to [asset documentation](#service/asset).

    {{ asset_add("theme.js", "theme::js/vendor/*") }}
    {{ asset_add("theme.js", "theme::js/libraries/sortable.js", ["min"]) }}

    {{ asset_script("theme.js", ["min"]) }}

    {% for script in asset_scripts("scripts.js") %}
        {{ script|raw }}
    {% endfor %}


#### Including javascript constants[](#usage/asset/including-javascript-constants)

The `constants` function returns a number of required javascript constants necessary for field types and potentially other components to work correctly. Make sure you include it in your themes!

    {{ constants() }}

Example of the included JavaScript constants:

    <script type="text/javascript">

        var APPLICATION_URL = "{{ url() }}";
        var APPLICATION_REFERENCE = "{{ env('APPLICATION_REFERENCE') }}";
        var APPLICATION_DOMAIN = "{{ env('APPLICATION_DOMAIN') }}";

        var CSRF_TOKEN = "{{ csrf_token() }}";
        var APP_DEBUG = "{{ config_get('app.debug') }}";
        var APP_URL = "{{ config_get('app.url') }}";
        var REQUEST_ROOT = "{{ request_root() }}";
        var REQUEST_ROOT_PATH = "{{ parse_url(request_root()).path }}";
        var TIMEZONE = "{{ config_get('app.timezone') }}";
        var LOCALE = "{{ config_get('app.locale') }}";
    </script>


### Auth[](#usage/auth)

The `auth_*` functions provide **limited** access to the `\Illuminate\Contracts\Auth\Guard` class.

    {% if auth_check() %}
        Hello {{ auth_user().display_name }}!
    {% endif %}

    {% if auth_guest() %}
        Welcome guest!
    {% endif %}


### Breadcrumb[](#usage/breadcrumb)

The `breadcrumb` functions returns the `\Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection`.

You can use this function to automatically generate a Bootstrap 3/4 breadcrumb:

    {{ breadcrumb() }} // Returns Bootstrap breadcrumb

You can use the same function to generate your own breadcrumb:

    <ol class="breadcrumb">
        {% for breadcrumb, url in breadcrumb() %}
            {% if loop.last %}
                <li class="breadcrumb-item active">{{ trans(breadcrumb) }}</li>
            {% else %}
                <li class="breadcrumb-item"><a href="{{ url }}">{{ trans(breadcrumb) }}</a></li>
            {% endif %}
        {% endfor %}
    </ol>


### Favicons[](#usage/favicons)

The `favicons` functions renders multiple favicon tags based on a single `source`.

You can use this function to automatically generate comprehensive and modern favicon tags:

    {{ favicons('theme::img/favicon.png') }} // Use a 512px source for example

The above function will generate the below favicons using the `streams::partials/favicons` view:

    <link rel="icon" type="image/png" href="{{ image(source).resize(16, 16).path }}" sizes="16x16"/>
    <link rel="icon" type="image/png" href="{{ image(source).resize(32, 32).path }}" sizes="32x32"/>
    <link rel="icon" type="image/png" href="{{ image(source).resize(96, 96).path }}" sizes="96x96"/>
    <link rel="icon" type="image/png" href="{{ image(source).resize(128, 128).path }}" sizes="128x128"/>
    <link rel="icon" type="image/png" href="{{ image(source).resize(196, 196).path }}" sizes="196x196"/>
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{ image(source).resize(57, 57).path }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="{{ image(source).resize(60, 60).path }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ image(source).resize(72, 72).path }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="{{ image(source).resize(76, 76).path }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ image(source).resize(114, 114).path }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{ image(source).resize(120, 120).path }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ image(source).resize(144, 144).path }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ image(source).resize(152, 152).path }}"/>


### Carbon[](#usage/carbon)

The `carbon` function provides access to the `\Carbon\Carbon` class.

###### Returns: `/Carbon/Carbon`

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

$time

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

A date/time string.

</td>

</tr>

<tr>

<td>

$timezone

</td>

<td>

false

</td>

<td>

string

</td>

<td>

Configured default timezone.

</td>

<td>

A timezone string.

</td>

</tr>

</tbody>

</table>

###### Twig

    {{ carbon().today() }} // 2016-06-24 00:00:00

    {{ carbon('-1 day', config('app.timezone')) }} // "2016-08-17 15:05:26"

    {{ carbon('-1 day', config('app.timezone')).diffInHours() }} // 24


### Config[](#usage/config)

The `config` functions provide **limited** access to the `\Illuminate\Contracts\Config\Repository` class.

    {{ config_get("app.name") }} // PyroCMS

    {{ config_get("streams::locales.default") }} // en

    {{ config_has("foo") }} // boolean


### CSRF[](#usage/csrf)

The CSRF functions provide access to CSRF information.


#### csrf_token[](#usage/csrf/csrf-token)

The `csrf_token` method returns the CSRF token value.

###### Returns: `string`

###### Twig

    {{ csrf_token() }} // The CSRF token


#### csrf_field[](#usage/csrf/csrf-field)

The `csrf_field` method returns the name of the CSRF field.

###### Returns: `string`

###### Twig

    {{ csrf_field() }} // The CSRF field name


### Entries[](#usage/entries)

The `entries` and `query` functions provide you with a convenient, fluent interface to fetch streams and non-streams database records respectively.


#### Introduction[](#usage/entries/introduction)

The Streams Platform comes with a clean, extendable, fluent API for building database queries within the `view layer`.


##### entries[](#usage/entries/introduction/entries)

The `entries` function starts a model criteria query for database records powered by Streams. Being that nearly everything in PyroCMS is a stream this is your primary entry point to retrieving database records.

###### Returns: `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

The stream namespace.

</td>

</tr>

<tr>

<td>

$slug

</td>

<td>

false

</td>

<td>

string

</td>

<td>

The namespce provided.

</td>

<td>

The stream slug.

</td>

</tr>

</tbody>

</table>

###### Twig

    <ul>
        {% for category in entries('posts', 'categories').get() %}
        <li>
            {{ category.slug }}
        </li>
        {% endfor %}
    </ul>

<div class="alert alert-primary">**Pro Tip:** The entry criteria is extendable! To learn how to add your own functionality to queries refer to the criteria documetation.</div>


##### query[](#usage/entries/introduction/query)

The `query` function starts a model criteria query for database records that are **not** powered by Streams though it works all the same for Streams powered database records.

###### Returns: `\Anomaly\Streams\Platform\Model\EloquentCriteria`

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

$model

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

The model to start the query from.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set users = query()
        .from('test_table')
        .where('active', true)
        .get() %}

    // Using a model
    {% set users = query('App\Example\TestModel')
        .where('active', true)
        .get() %}

<div class="alert alert-info">**Note:** To use a custom criteria you must provide a **model** because the model returns it's criteria.</div>


#### Retrieving Results[](#usage/entries/retrieving-results)

This section will show you how to return results from the model criteria returned by `entries` and `query` functions.


##### Retrieving A Single Row[](#usage/entries/retrieving-results/retrieving-a-single-row)

If you just need to retrieve a single entry, you may use the `first` method. This method will return a single `\Anomaly\Streams\Platform\Entry\EntryPresenter`:

    {% set user = entries('users').where('display_name', 'Ryan Thompson').first() %}

    {{ user.email }}


##### EloquentCriteria::get()[](#usage/entries/retrieving-results/eloquentcriteria-get)

The `get` method returns the results of the query.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCollection` or `\Anomaly\Streams\Platform\Entry\EntryCollection`

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

$columns

</td>

<td>

false

</td>

<td>

array

</td>

<td>

`["*"]`

</td>

<td>

The columns to select.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set users = entries('users', 'users')
        .where('email', 'LIKE', '%@gmail.com%')
        .where('activated', true)
        .get() %}

    {% for user in users %}
        {{ user.display_name }}
    {% endfor %}


##### EloquentCriteria::first()[](#usage/entries/retrieving-results/eloquentcriteria-first)

The `first` method returns the first matching query result.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentPresenter` or `\Anomaly\Streams\Platform\Entry\EntryPresenter`

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

$columns

</td>

<td>

false

</td>

<td>

array

</td>

<td>

`["*"]`

</td>

<td>

The columns to select.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set user = entries('users').where('display_name', 'Ryan Thompson').first() %}

    {{ user.email }}


##### EloquentCriteria::find()[](#usage/entries/retrieving-results/eloquentcriteria-find)

The `find` method allows you to return a single record by it's ID.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentPresenter` or `\Anomaly\Streams\Platform\Entry\EntryPresenter`

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

$identifier

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

The ID of the result to return.

</td>

</tr>

<tr>

<td>

$columns

</td>

<td>

false

</td>

<td>

array

</td>

<td>

`["*"]`

</td>

<td>

The columns to select.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set user = entries('users').find(1) %}

    {{ user.email.mailto|raw }}


##### EloquentCriteria::paginate()[](#usage/entries/retrieving-results/eloquentcriteria-paginate)

The `paginate` method returns the result of the `entries` and `query` functions as a pagination object.

###### Returns: `\Illuminate\Pagination\LengthAwarePaginator`

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

$perPage

</td>

<td>

false

</td>

<td>

string

</td>

<td>

15

</td>

<td>

The number of entries per page.

</td>

</tr>

<tr>

<td>

$columns

</td>

<td>

false

</td>

<td>

array

</td>

<td>

`["*"]`

</td>

<td>

The columns to select.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set posts = entries('posts').paginate() %}

    {% for post in posts %}
        <p>
            {{ post.title }}
        </p>
    {% endfor %}

    {{ posts.links|raw }}


##### EloquentCriteria::findBy()[](#usage/entries/retrieving-results/eloquentcriteria-findby)

The `findBy` by method allows you to find a single query result by a column value. This comes in handy for finding records by `slug` for example.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentPresenter` or `\Anomaly\Streams\Platform\Entry\EntryPresenter`

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

$column

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

The column to test.

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

mixed

</td>

<td>

none

</td>

<td>

The value to test the column by.

</td>

</tr>

<tr>

<td>

$columns

</td>

<td>

false

</td>

<td>

array

</td>

<td>

`["*"]`

</td>

<td>

The columns to select.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set admin = entries('roles', 'users').findBy('slug', 'admin') %}

    // You can also map the column into the method name.
    {% set admin = entries('roles', 'users').findBySlug('admin') %}


##### EloquentCriteria::cache()[](#usage/entries/retrieving-results/eloquentcriteria-cache)

The `cache` method sets the cache TTL for the query.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

$ttl

</td>

<td>

true

</td>

<td>

int

</td>

<td>

none

</td>

<td>

The maximum time in seconds to cache results for.

</td>

</tr>

</tbody>

</table>

###### Twig

    // Cache for a maximum of 300 seconds
    {% set books = entries('library', 'books').cache(300).get() %}

<div class="alert alert-info">**Note:** Cache automatically invalidates itself when any entry in the stream is modified.</div>


##### EloquentCriteria::fresh()[](#usage/entries/retrieving-results/eloquentcriteria-fresh)

The `fresh` method forces non-cached results to be returned.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

###### Twig

    {% set books = entries('library', 'books').fresh().get() %}


#### Aggregates[](#usage/entries/aggregates)

The model criteria also provide a variety of aggregate methods such as `count`, `max`, `min`, `avg`, and `sum`. You can call any of these methods after constructing your query.


##### EloquentCriteria::count()[](#usage/entries/aggregates/eloquentcriteria-count)

The `count` method returns the total number of query results.

###### Returns: `integer`

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

$columns

</td>

<td>

false

</td>

<td>

array

</td>

<td>

`["*"]`

</td>

<td>

The collection to add the asset to.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set activated = entries('users').where('activated', true).count() %}


##### EloquentCriteria::sum()[](#usage/entries/aggregates/eloquentcriteria-sum)

The `sum` method returns the sum of the `column` value.

###### Returns: `integer`

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

$column

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

The column to summarize.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set orders = entries('store', 'orders').where('finalized', true).sum('subtotal') %}


##### EloquentCriteria::max()[](#usage/entries/aggregates/eloquentcriteria-max)

The `max` method returns the highest `column` value.

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

$column

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

The column to find the max for.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set price = entries('store', 'products').where('enabled', true).max('price') %}


##### EloquentCriteria::min()[](#usage/entries/aggregates/eloquentcriteria-min)

The `min` method returns the lowest `column` value.

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

$column

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

The column to find the min for.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set price = entries('store', 'products').where('enabled', true).min('price') %}


##### EloquentCriteria::avg()[](#usage/entries/aggregates/eloquentcriteria-avg)

The `avg` method returns the average value of the `column`.

###### Returns: `integer`

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

$column

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

The column to average.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set mean = entries('store', 'products').where('enabled', true).avg('price') %}


#### Where Clauses[](#usage/entries/where-clauses)

This section will go over `where` clauses for the `entries` and `query` model criteria functions.


##### EloquentCriteria::where()[](#usage/entries/where-clauses/eloquentcriteria-where)

The `where` method adds a where clauses to the query. The most basic call to `where` requires three arguments. The first argument is the name of the column. The second argument is an operator, which can be any of the database's supported operators. Finally, the third argument is the value to evaluate against the column.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

$column

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

The name of the column.

</td>

</tr>

<tr>

<td>

$operator|$value

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

The where operator.

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

string

</td>

<td>

null

</td>

<td>

The value if an operator is defined.

</td>

</tr>

</tbody>

</table>

###### Twig

    // Example that verifies the value of the "votes" column is equal to 100:
    {% set users = entries('users').where('votes', '=', 100).get() %}

    // Assuming the "=" operator.
    {% set users = entries('users').where('votes', 100).get() %}


##### EloquentCriteria::orWhere()[](#usage/entries/where-clauses/eloquentcriteria-orwhere)

You may chain `where` constraints together as well as add `or` where clauses to the query.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

$column

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

The name of the column.

</td>

</tr>

<tr>

<td>

$operator|$value

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

The where operator.

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

string

</td>

<td>

null

</td>

<td>

The value if an operator is defined.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set = users = entries('users')
        .where('votes', '>', 100)
        .orWhere('name', 'John')
        .get() %}


##### EloquentCriteria::whereBetween()[](#usage/entries/where-clauses/eloquentcriteria-wherebetween)

The `whereBetween` method verifies that a column's value is between two values.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

$column

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

The name of the column.

</td>

</tr>

<tr>

<td>

$values

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

The values to test the column against.

</td>

</tr>

</tbody>

</table>

###### Example

    {% set users = entries('users').whereBetween('votes', [1, 100]).get() %}


##### EloquentCriteria::whereNotBetween()[](#usage/entries/where-clauses/eloquentcriteria-wherenotbetween)

The `whereNotBetween` method verifies that a column's value lies outside of two values.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

$column

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

The name of the column.

</td>

</tr>

<tr>

<td>

$values

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

The values to test the column against.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set users = entries('users').whereNotBetween('votes', [1, 100]).get() %}


##### EloquentCriteria::whereIn()[](#usage/entries/where-clauses/eloquentcriteria-wherein)

The `whereIn` method verifies that a given column's value is contained within the given array.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

$column

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

The name of the column.

</td>

</tr>

<tr>

<td>

$values

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

The array of values to find.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set users = entries('users').whereIn('id', [1, 2, 3]).get() %}


##### EloquentCriteria::whereNotIn()[](#usage/entries/where-clauses/eloquentcriteria-wherenotin)

The `whereNotIn` method verifies that a given column's value is not contained within the given array.

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

$column

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

The name of the column.

</td>

</tr>

<tr>

<td>

$values

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

The array of values to exclude.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set users = entries('users').whereNotIn('id', [1, 2, 3]).get() %}


##### EloquentCriteria::whereNull()[](#usage/entries/where-clauses/eloquentcriteria-wherenull)

The `whereNull` method verifies that the value of the given column is `NULL`.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

$column

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

The name of the column.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set users = entries('users').whereNull('updated_at').get() %}


##### EloquentCriteria::whereNotNull()[](#usage/entries/where-clauses/eloquentcriteria-wherenotnull)

The `whereNotNull` method verifies that the column's value is not `NULL`.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

$column

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

The name of the column.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set users = entries('users').whereNotNull('updated_at').get() %}


##### EloquentCriteria::whereDate()[](#usage/entries/where-clauses/eloquentcriteria-wheredate)

The `whereDate` method may be used compare a column's value against a date.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

$column

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

The name of the column.

</td>

</tr>

<tr>

<td>

$operator|$value

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

The where operator.

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

string

</td>

<td>

null

</td>

<td>

The value if an operator is defined.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set users = entries('users').whereDate('created_at', '2016-10-10').get() %}


##### EloquentCriteria::whereMonth()[](#usage/entries/where-clauses/eloquentcriteria-wheremonth)

The `whereMonth` method may be used compare a column's value against a specific month of an year.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

$column

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

The name of the column.

</td>

</tr>

<tr>

<td>

$operator|$value

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

The where operator.

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

string

</td>

<td>

null

</td>

<td>

The value if an operator is defined.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set users = entries('users').whereMonth('created_at', '10').get() %}


##### EloquentCriteria::whereDay()[](#usage/entries/where-clauses/eloquentcriteria-whereday)

The `whereDay` method may be used compare a column's value against a specific day of a month.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

$column

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

The name of the column.

</td>

</tr>

<tr>

<td>

$operator|$value

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

The where operator.

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

string

</td>

<td>

null

</td>

<td>

The value if an operator is defined.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set users = entries('users').whereDay('created_at', '10').get() %}


##### EloquentCriteria::whereYear()[](#usage/entries/where-clauses/eloquentcriteria-whereyear)

The `whereYear` method may be used compare a column's value against a specific year.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

$column

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

The name of the column.

</td>

</tr>

<tr>

<td>

$operator|$value

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

The where operator.

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

string

</td>

<td>

null

</td>

<td>

The value if an operator is defined.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set users = entries('users').whereYear('created_at', '2016').get() %}


##### EloquentCriteria::whereColumn()[](#usage/entries/where-clauses/eloquentcriteria-wherecolumn)

The `whereColumn` method may be used to test two values with an operator.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

$column

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

The name of the column to test.

</td>

</tr>

<tr>

<td>

$operator|$compare

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

The test operator or the column to compare.

</td>

</tr>

<tr>

<td>

$compare

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

The column to compare.

</td>

</tr>

</tbody>

</table>

###### Twig

    // Assumes "=" operator
    {% set users = entries('users').whereColumn('first_name', 'last_name').get() %}

    // Use a different operator.
    {% set users = entries('users').whereColumn('updated_at', '>', 'created_at').get() %}


#### JSON Where Clauses[](#usage/entries/json-where-clauses)

Laravel supports querying JSON column types on databases that provide support for JSON column types. You can leverage this the in the criteria queries too. Currently, this includes MySQL 5.7 and Postgres. To query a JSON column, use the `->` operator:

    {% set users = entries('users')
        .where('options->language', 'en')
        .get() %}

    {% set users = entries('users')
        .where('preferences->dining->meal', 'salad')
        .get() %}


#### Ordering, Grouping, Limit, & Offset[](#usage/entries/ordering-grouping-limit-and-offset)

The Streams Platform supports a number of Laravel methods for ordering, grouping, limit, and offsetting records.


##### EloquentCriteria::orderBy()[](#usage/entries/ordering-grouping-limit-and-offset/eloquentcriteria-orderby)

The `orderBy` method allows you to sort the result of the query by a given column.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

$column

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

The name of the column.

</td>

</tr>

<tr>

<td>

$direction

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

The direction to order column values.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set users = entries('users').orderBy('name', 'desc').get() %}


##### EloquentCriteria::inRandomOrder()[](#usage/entries/ordering-grouping-limit-and-offset/eloquentcriteria-inrandomorder)

The `inRandomOrder` method may be used to sort the query results randomly. For example, you may use this method to fetch a random record.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

###### Twig

    {% set user = entries('users').inRandomOrder().first() %}


##### EloquentCriteria::groupBy()[](#usage/entries/ordering-grouping-limit-and-offset/eloquentcriteria-groupby)

The `groupBy` method can be used to group the query results.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

$column

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

The name of the column.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set users = entries('users').groupBy('category').get() %}


##### EloquentCriteria::having()[](#usage/entries/ordering-grouping-limit-and-offset/eloquentcriteria-having)

The `having` method is used often in conjunction with the `groupBy` method.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

$column

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

The name of the column.

</td>

</tr>

<tr>

<td>

$operator|$value

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

The where operator.

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

string

</td>

<td>

null

</td>

<td>

The value if an operator is defined.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set users = entries('users').groupBy('account_id').having('account_id', '>', 100).get() %}


##### EloquentCriteria::skip()[](#usage/entries/ordering-grouping-limit-and-offset/eloquentcriteria-skip)

The `skip` method is an alias for `limit`.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

The number of results to skip.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set users = entries('users').skip(10).get() %}


##### EloquentCriteria::offset()[](#usage/entries/ordering-grouping-limit-and-offset/eloquentcriteria-offset)

The `offset` method skips a number of results from the query.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

integer

</td>

<td>

none

</td>

<td>

The number of results to skip.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set users = entries('users').offset(10).get() %}


##### EloquentCriteria::take()[](#usage/entries/ordering-grouping-limit-and-offset/eloquentcriteria-take)

The `take` method is an alias for `limit`.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

integer

</td>

<td>

none

</td>

<td>

The number of results to return.

</td>

</tr>

</tbody>

</table>


##### EloquentCriteria::limit()[](#usage/entries/ordering-grouping-limit-and-offset/eloquentcriteria-limit)

The `limit` method specifies the number of results to return.

###### Returns: `\Anomaly\Streams\Platform\Eloquent\EloquentCriteria` or `\Anomaly\Streams\Platform\Entry\EntryCriteria`

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

integer

</td>

<td>

none

</td>

<td>

The number of results to return.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% set users = entries('users').limit(5).get() %}


#### Searching[](#usage/entries/searching)

This section will show you how to search for results from the search criteria returned by `entries` and `query` functions.


##### EloquentCriteria::search()[](#usage/entries/searching/eloquentcriteria-search)

The `search` method returns a new search criteria instance which can be used just like the entry and eloquent criteria.

###### Returns: `\Anomaly\Streams\Platform\Search\SearchCriteria`

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

$term

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

The term you would like to search for.

</td>

</tr>

</tbody>

</table>

###### Twig

    // The search method must be used after entries/query
    {% set results = entries('users').search('gmail').get() %}

    // You can still chain criteria methods after search.
    {% set results = entries('users').search('gmail').where('active', true).get() %}


##### Searchable Models[](#usage/entries/searching/searchable-models)

In order to leverage model searching you must make your model `searchable` using the `\Laravel\Scout\Searchable` trait:

    use \Laravel\Scout\Searchable;

For Streams entry models you can also simply define the `searchable` flag since the base models implement this trait already:

    protected $searchable = true;


##### Searchable Streams[](#usage/entries/searching/searchable-streams)

Defining Streams as searchable can be done just like a model. However you may want to include this option in your streams migration as well:

    protected $stream = [
        'slug'         => 'users',
        'title_column' => 'username',
        'searchable'   => true,
        'trashable'    => true,
    ];


### Env[](#usage/env)

You can access environmental values with the `env` function. This function behaves just like the Laravel helper function.

    {% if env("APP_DEBUG") %}
        You are debugging!
    {% endif %}


### Footprint[](#usage/footprint)

The footprint functions provide information about load time and footprint.


#### request_time[](#usage/footprint/request-time)

The `request_time` function returns the elapsed time for the request.

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

$decimal

</td>

<td>

false

</td>

<td>

integer

</td>

<td>

2

</td>

<td>

The number of decimals to return.

</td>

</tr>

</tbody>

</table>

###### Twig

    {{ request_time(3) }} // 0.551


#### memory_usage[](#usage/footprint/memory-usage)

The `memory_usage` function returns the memory used by the request.

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

$precision

</td>

<td>

false

</td>

<td>

integer

</td>

<td>

1

</td>

<td>

The number of decimals to return.

</td>

</tr>

</tbody>

</table>

###### Twig

    {{ memory_usage() }} // 6.5 m


### Image[](#usage/image)

The `image` function returns an instance of `Anomaly\Streams\Platform\Image\Image` for altering and displaying images. For more information please see the [Image documentation](/documentation/streams-platform/latest#services/image).


#### Introduction[](#usage/image/introduction)

This section will introduce you to the basics of using the image functions and how to alter and output images.


##### img[](#usage/image/introduction/img)

The `img` function is an alias to the `image` function described below.


##### image[](#usage/image/introduction/image)

The `image` method makes a new instance of the `Image` class. The output for this function is `tag` by default which renders the entire image tag.

*   [Image service](/documentation/streams-platform/latest#services/image/basic-usage)
*   [Image sources](/documentation/streams-platform/latest#services/image/basic-usage/image-make)

###### Returns: `\Anomaly\Streams\Platform\Image\Image`

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

</tbody>

</table>

###### Twig

    {{ image('theme::img/logo.jpg')|raw }}

    {{ image('theme::img/logo.jpg').resize(1000).quality(60)|raw }}


##### image_path[](#usage/image/introduction/image-path)

The `image_path` method makes a new instance of the `Image` class. The output for this function is `path` by default which renders the relative image path.

*   [Image service](/documentation/streams-platform/latest#services/image/basic-usage)
*   [Image sources](/documentation/streams-platform/latest#services/image/basic-usage/image-make)

###### Returns: `\Anomaly\Streams\Platform\Image\Image`

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

</tbody>

</table>

###### Twig

    {{ image_path('theme::img/logo.jpg') }}

    {{ image_path('theme::img/logo.jpg').fit(500, 500) }}


### Request[](#usage/request)

The `request_*` functions map directly to the `\Illuminate\Http\Request` class.

For more information on usage please refer to documentation for [requests in Laravel](https://laravel.com/docs/5.3/requests).

    {{ request_get("foo") }} // bar

    {{ request_method() }} // GET

    {{ request_root() }} // http://domain.com/

    {{ request_path() }} // /the/uri/path

    {{ request_segment(1) }} // foo

    {{ request().route('id') }} // 123

    {{ request_is("myaccount/*", "account/*") }} // boolean

    {{ request_ajax() }} // boolean


### Route[](#usage/route)

The `route_*` functions map directly to the `\Illuminate\Routing\Route` class.

    {{ route_parameter("foo", "default") }} // bar

    {{ route_parameters() }} // ["foo" => "bar"]

    {{ route_uri() }} // /the/path/example

    {{ route_secure() }} // boolean

    {{ route_domain() }} // example.com

    {{ route_get_name() }} // the route name if any


### Session[](#usage/session)

The `session_*` functions provide **limited** access to the `\Illuminate\Session\Store` class.

    {{ session_get("foo") }} // "bar"

    {{ session_pull("foo") }} // "bar"
    {{ session_pull("foo") }} // null

    {{ session_has("foo") }} // boolean


### String[](#usage/string)

The `str_*` functions map directly to the `\Anomaly\Streams\Platform\Support\Str` class which extends Laravel's `\Illuminate\Support\Str` class.

For more information on usage please refer to the [String service](#services/string).

    {{ str_humanize("hello_world") }} // "Hello World"

    {{ str_truncate(string, 100) }}

    {% if str_is("*.module.*", addon("users").namespace) %}
        That's a valid module namespace!
    {% endif %}

    {{ str_camel("some_slug") }} // "someSlug"

    {{ str_studly("some_slug") }} // "SomeSlug"

    {{ str_random(10) }} // 4sdf87yshs


### Translator[](#usage/translator)

The `translator_*` functions provide access to the `\Illuminate\Translation\Translator` class.

    {{ trans("anomaly.module.users::addon.name") }} // "Users Module"

    {{ trans_exists("anomaly.module.users::field.bogus.name") }} // boolean


### URL[](#usage/url)

The `url_*` functions map directly to the `\Illuminate\Contracts\Routing\UrlGenerator`.

You can also refer to [Laravel URL helpers](https://laravel.com/docs/5.3/helpers#url) for more information.

    {{ url_to("example") }} // "http://domain.com/example"

    {{ url_secure("example") }} // "https://domain.com/example"

    {{ url_route("anomaly.module.users::password.forgot") }} // "users/password/forgot"


### View[](#usage/view)

View functions help leverage the view engine.


#### view[](#usage/view/view)

The `view` function returns a rendered view.

The single most important detail of this function versus using Twig's `include` is that the view is passed through the `view composer` in order to allow overriding. Overriding on the other hand is not supported with the `include` tag.

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

$view

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

The view you wish to render.

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

null

</td>

<td>

The data to pass along to the view.

</td>

</tr>

</tbody>

</table>

###### Twig

    {{ view('example.module.test::example/view', {'foo': 'Bar'}) }}


#### parse[](#usage/view/parse)

The `parse` function parses a string template.

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

$template

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

The template string to parse.

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

null

</td>

<td>

The data to pass along to the view.

</td>

</tr>

</tbody>

</table>

###### Twig

    {{ parse("This is a template {{ foo }}", {"foo": "bar"}) }}


#### layout[](#usage/view/layout)

The `layout` method checks for a theme layout and returns a `default` if it's not found.

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

$layout

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

The layout to look for.

</td>

</tr>

<tr>

<td>

$default

</td>

<td>

false

</td>

<td>

string

</td>

<td>

default

</td>

<td>

The default layout to fallback to.

</td>

</tr>

</tbody>

</table>

###### Twig

    {% extends layout("posts") %} // extends "theme::layotus/default" if not found
