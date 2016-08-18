# Streams Plugin

- [Addon](#addon)
- [Agent](#agent)
- [Asset](#asset)
- [Auth](#auth)
- [Carbon](#carbon)
- [Config](#config)
- [CSRF](#csrf)
- [Entries](#entries)
- [Env](#env)
- [Footprint](#footprint)
- [Forms](#forms)
- [Image](#image)
- [Request](#request)
- [Session](#session)
- [String](#string)
- [Translator](#translator)
- [URL](#url)    
- [Views](#views)    

<a name="introduction"></a>
## Introduction

PyroCMS comes with a large core plugin which provides an interface to various core services.  

<hr>

<a name="addon"></a>
### Addon

The addon functions provide access to the `Anomaly\Streams\Platform\Addon\AddonCollection`.

##### Returning an addon collection

    {% verbatim %}
    {% for addon in addons().enabled() %}
        The {{ trans(addon.name) }} is installed and enabled.
    {% endfor %}
    
    {% for addon in addons().fieldTypes() %}
        {{ trans(addon.name) }} is a field type.
    {% endfor %}
    {% endverbatim %}

##### Returning a single addon
 
Returns a single addon. The `$identifier` can be the slug or full namespace of any addon.

    {% verbatim %}
    {{ addon('users').namespace }} // "anomaly.module.users"
    
    {{ trans(addon('relationship').name) }} // "Relationship Field Type"
    
    {{ addon('anomaly.module.posts').isInstalled() }} // boolean
    {% endverbatim %}

<hr>

<a name="agent"></a>
### Agent

The `agent_*` functions map directly to the `Jenssegers\Agent\Agent` class. For more information on usage please refer to [jenssegers/agent](https://github.com/jenssegers/agent).

    {% verbatim %}
    {{ agent_is("iPhone") }} // boolean
    
    {{ agent_is_mobile() }} // boolean
    
    {{ agent_platform() }} // "OS X"
    {% endverbatim %}

<hr>

<a name="asset"></a>
### Asset

The `asset_*` functions map directly to the `Anomaly\Streams\Platform\Asset\Asset` service. For more information on usage please refer to the `Asset` service documentation.

    {% verbatim %}
    {{ asset_add("theme.js", "theme::js/vendor/*") }}
    {{ asset_add("theme.js", "theme::js/libraries/sortable.js", ["min"]) }}
    {{ asset_add("scripts.js", asset_download("https://shakydomain.com/js/example.js")) }}
    
    {{ asset_script("theme.js ["min"]) }}
    
    {% for script in asset_scripts("scripts.js") %}
            {{ script|raw }}
        {% endfor %}
    {% endverbatim %}

##### Including javascript constants

The `constants` function includes a number of required javascript constants necessary for field types and potentially other components to work correctly. 

    {% verbatim %}
    {{ constants() }}
    {% endverbatim %}

<hr>

<a name="auth"></a>
### Auth

The auth functions provide limited access to the `Illuminate\Contracts\Auth\Guard` authentication service.

    {% verbatim %}
    {% if auth_check() %}
        Hello {{ auth_user().display_name }}!
    {% endif %}
    
    {% if auth_guest() %}
        Welcome guest!
    {% endif %}
    {% endverbatim %}

<hr>

<a name="carbon"></a>
### Carbon

The carbon function provides access to the `Carbon` datetime class. The `$time` and `$timezone` arguments are optional.

    {% verbatim %}
    {{ carbon('-1 day', config('app.timezone')) }} // "2016-08-17 15:05:26"
    
    {{ carbon('-1 day', config('app.timezone')).diffInHours() }} // 24
    {% endverbatim %}

<hr>

<a name="config"></a>
### Config

The config functions provide limited access to the `Illuminate\Contracts\Config\Repository` class.

    {% verbatim %}
    {{ config_get("foo") }} // "bar"
    
    {{ config_has("foo") }} // boolean
    {% endverbatim %}

<hr>

<a name="csrf"></a>
### CSRF

The CSRF functions provide access to CSRF information.

    {% verbatim %}
    {{ csrf_token() }} // The CSRF token
    
    {{ csrf_field() }} // The CSRF field name
    {% endverbatim %}

<hr>

<a name="entries"></a>
### Entries

The `entry` and `entries` functions let you fetch stream entries. Both functions return an `Anomaly\Streams\Platform\Entry\EntryCriteria` instance. For more information on implementing custom criteria methods please refer to the `Criteria` service documentation.

##### Fetching a single stream entry

The `entry($namespace, $stream)` function let's you retrieve a single entry.   

    {% verbatim %}
    {% set category = entry("posts", "categories").whereSlug("releases").get() %}
    
    {{ category.title }} // "Releases"
    {% endverbatim %}

##### Finding stream entries.

Aside from the default trigger `get`, you can also use the base triggers designed for returning a single entry. 

    {% verbatim %}
    {% set category = entry("posts", "categories").first() %}
    
    {% set category = entry("posts", "categories").find(4) %}
    
    {% set category = entry("posts", "categories").findBySlug("releases") %}
    {% endverbatim %}

##### Fetching a collection of stream entries

The `entries($namespace, $stream)` function let's you retrieve a collection of entries.   

    {% verbatim %}
    {% set posts = entries("posts", "posts").recent().get() %} // PostsCollection
    
    {% for post in posts.live() %}
        {{ html_link(post.route("view"), post.title) }}
    {% endfor %}
    {% endverbatim %}

##### Paginating stream entries

    {% verbatim %}
    {% set posts = entries("posts", "posts").recent().paginate(10) %}
    
    {% for post in posts %}
        {{ html_link(post.route("view"), post.title) }}
    {% endfor %}
    
    {{ posts.render|raw }} // Render pagination
    {% endverbatim %}

<div class="alert alert-primary">
<strong>Pro-tip:</strong> If namespace and stream are the same then you can just pass namespace. 
</div>

<hr>

<a name="env"></a>
### Env

You can access environmental values with `env`. This function behaves just like the Laravel helper function.

    {% verbatim %}
    {% if env("APP_DEBUG") %}
        You are debugging!
    {% endif %}
    {% endverbatim %}

<hr>

<a name="footprint"></a>
### Footprint

Footprint functions help you display information about the current page load.

    {% verbatim %}
    {{ request_time() }} // 0.55
    
    {{ memory_usage() }} // 6 mb
    {% endverbatim %}

<hr>

<a name="forms"></a>
### Forms

The `form` function returns a `Anomaly\Streams\Platform\Ui\Form\FormCriteria` which helps you build a form via a `FormBuilder`. For more information on form criteria please refer to the `Criteria` service documentation. 

The form criteria's `get` trigger returns a `Anomaly\Streams\Platform\Ui\Form\FormPresenter`.

##### Rendering a form automatically

    {% verbatim %}
    {{ form("posts", "categories").option('redirect', '/')|raw }} 
    {% endverbatim %}

##### Manually rendering a form

You can access `Anomaly\Streams\Platform\Ui\Form\Form` components through the presenter and use them however you want.

    {% verbatim %}
    {% set form=form("posts", "categories").entry(1).option('redirect', '/') %}
     
    {{ form.open|raw }}
    
    {% for field in form.fields %}
    
        {% if field.input_name == "name" %}
            {{ field.setPlaceholder().input|raw }}
        {% else %}
            {{ field.input|raw }}
        {% endif %}
    {% endfor %}
    
    {{ form.close|raw }}
    {% endverbatim %}

<hr>

<a name="image"></a>
### Image

The Image functions provide access to the `Anomaly\Streams\Platform\Image\Image` service. Each function sets an initial output method and returns the `Image` instance.

    {% verbatim %}
    {{ img("disk://folder/filename.ext") }} <img src="path/to/filename.ext"/>
    
    {{ image("disk://folder/filename.ext") }} <img src="path/to/filename.ext"/>
    
    {{ image_path("disk://folder/filename.ext") }} "path/to/filename.ext"
    
    {{ image_url("disk://folder/filename.ext") }} "http://domain.com/path/to/filename.ext"
    {% endverbatim %}

##### Checking route parameters

You can use the `route_has` method to check if an optional route parameter exists.

    {% verbatim %}
    {% if route_has("id") %}
        {% set entry = entry("posts").find(url_segment(2)) %}
    {% endif %}
    {% endverbatim %}

#### The following `$identifier` values are supported:

##### A disk path as provided by the files module.

    {% verbatim %}
    {{ image("disk://folder/filename.ext") }}
    {% endverbatim %}

##### A prefixed path.

For available prefixes please refer to the Image service documentation. 

    {% verbatim %}
    {{ image("anomaly.module.example::img/example.jpg") }}
    {% endverbatim %}

##### A `FileInterface` or `FilePresenter` from the files module. 

    {% verbatim %}
    {{ image(file(1)) }}
    {{ image(entry.file_field) }}
    {% endverbatim %}

<div class="alert alert-info">
<strong>Note:</strong> The file and files field types both return a file interface and collection of file interfaces respectively. 
</div>

#### Chaining image methods and alterations.

Because these image functions return an `Anomaly\Streams\Platform\Image\Image` instance, you can chain any public method to alter the image and it's output just like using the service via API.

    {% verbatim %}
    {{ image("disk://folder/filename.ext").resize(100, 100).quality(50)|raw }}
    
    {{ image("disk://folder/filename.ext").path() }} // Manually call the path output method
    {% endverbatim %}

<div class="alert alert-primary">
<strong>Pro-tip:</strong> Head over to the Image service documentation for a full resource of alterations, macros, and more. 
</div>

<hr>

<a name="request"></a>
### Request

The `request_*` functions map directly to the `Illuminate\Http\Request` object.

For more information on available methods please refer to [requests in Laravel](https://laravel.com/docs/5.1/requests).

    {% verbatim %}
    {{ request_get("foo") }} // "bar"
    
    {{ request_method() }} // "GET"
    
    {{ request_root() }} // "http://domain.com/"
    
    {{ request_segment(1) }} // "foo"
    {% endverbatim %}

<hr>

<a name="session"></a>
### Session

The session functions provide limited access to the `Illuminate\Session\Store` class.

    {% verbatim %}
    {{ session_get("foo") }} // "bar"
    
    {{ session_pull("foo") }} // "bar"
    {{ session_pull("foo") }} // null
    
    {{ session_has("foo") }} // boolean
    {% endverbatim %}

<hr>

<a name="string"></a>
### String

The `str_*` functions map directly to the `Anomaly\Streams\Platform\Support\Str` class which extends Laravel's `Str` class. For more information on usage please refer to the `String` service documentation and [Laravel string helpers](https://laravel.com/docs/5.1/helpers#strings)

    {% verbatim %}
    {{ str_humanize("hello_world") }} // "Hello World"
    
    {{ str_truncate(string, 100) }}
    
    {% if str_is("*.module.*", addon("users").namespace) %}
        That's a valid module namespace!
    {% endif %}
    
    {{ str_camel("some_slug") }} // "someSlug"
    
    {{ str_studly("some_slug") }} // "SomeSlug"
    
    {{ str_random(10) }} // 4sdf87yshs
    {% endverbatim %}

The `str_*` filters also map directly to the `Anomaly\Streams\Platform\Support\Str` class.

    {% verbatim %}
    {{ "posts.view"|str_humanize }} // "Posts View"

    {{ "This is a string"|str_studly }} // "ThisIsAString"
    
    {{ "This is a string"|str_limit(5) }} // This i...
    {% endverbatim %}

<hr>

<a name="translator"></a>
### Translator

The translator functions provide access to the `Illuminate\Translation\Translator`.

    {% verbatim %}
    {{ trans("anomaly.module.users::addon.name") }} // "Users Module"
    
    {{ trans_exists("anomaly.module.users::field.bogus.name") }} // boolean
    {% endverbatim %}

<hr>

<a name="url"></a>
### URL

The `url_*` functions map directly to the `Illuminate\Contracts\Routing\UrlGenerator`. For more information on usage please refer to [Laravel URL helpers](https://laravel.com/docs/5.1/helpers#url)

    {% verbatim %}
    {{ url_to("example") }} // "http://domain.com/example"
    
    {{ url_secure("example") }} // "https://domain.com/example"
    
    {{ url_route("anomaly.module.users::password.forgot") }} // "users/password/forgot"
    {% endverbatim %}

<hr>

<a name="views"></a>
### Views

View functions help work with the view engine.

##### Returning a view through the view composer

The single most important detail of this function versus simply including a view is that the view is passed through the view composer in order to allow overriding from the theme. 

    {% verbatim %}
    {{ view("module::some/view", {"foo": "bar"}) }}
    {% endverbatim %}

##### Parsing a string

Use the `parse` function to parse a string. You can pass along data to parse into the string as the second paramter.

    {% verbatim %}
    {{ parse("This is a template {{ foo }} }}", {"foo": "bar"}) }}
    {% endverbatim %}

##### Look for a layout

Use the `layout($layout, $default = "default")` method to look for a `$layout`. The `$default` layout is returned if the `$layout` is not found. 

    {% verbatim %}
    {% extends layout("posts") %} // extends "theme::layotus/default" if not found
    {% endverbatim %}
