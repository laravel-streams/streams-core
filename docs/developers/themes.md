# Developing Themes

- [Introduction](#introduction)
	- [Creating A Theme](#creating-a-theme)
- [Theme Components](#theme-components)
	- [Views](#views)
	- [Layouts](#layouts)
	- [Assets](#assets)
	- [Overriding Views](#overriding-views)
	- [Other Components](#other-components)

<a name="introduction"></a>
## Introduction

Themes are addons that control the way the control panel and public facing content look. Two themes can be active at any given time. An `admin` theme for the control panel and a `standard` theme for public facing content.

<a name="creating-a-theme"></a>
### Creating A Theme

Creating a theme is the same as creating any other addon.

	php artisan make:addon anomaly.theme.starter

The new theme will be located at `addons/{app_reference}/anomaly/starter-theme`. 

The `--shared` option may also be used to create the theme in the shared addons directory.

	php artisan make:addon anomaly.theme.starter --shared

This theme will be located at `addons/shared/anomaly/starter-theme`.

#### Creating An Admin Theme

In order to make a theme available for use for the control panel you must flag it as an admin theme.

	<?php namespace Anomaly\ExampleTheme;
	
	use Anomaly\Streams\Platform\Addon\Theme\Theme;
	
	class ExampleTheme extends Theme
	{
	
	    protected $admin = true;
	
	}


<a name="theme-components"></a>
## Theme Components

The structure of a theme is the exact same as other addons. But there are a few areas of particular interest where themes are concerned.

<a name="views"></a>
### Views

Theme views are located in the addon's view directory at `example-theme/resources/views` just like any other addon. Views parse using the extremely popular [Twig](http://twig.sensiolabs.org/) template engine and should use the `.twig` file extension.

When using referencing other views you may use the `theme::` namespace to reference views in the current theme.

	// Include resources/views/partials/example.twig in active theme
	
	{{ view("theme::partials/example") }}
	
	{% include "theme::partials/example" %}

If needed, you may also use namespace prefixes like `anomaly.module.example` to reference views in other addons.

	// Include example-module/resources/views/example.twig
	
	{{ view("anomaly.module.example::example") }}
	
	{% include "anomaly.module.example::example" %}

There is no restriction on view organization except for `layouts` as mentioned below, you are free to structure your views any way you like.

<a name="layouts"></a>
### Layouts

Theme layouts define the *outer most* structure of HTML. Layouts are located in the theme's views directory at `example-theme/resources/views/layouts`. 

All themes **must** at least include a `default` layout. In order display any system output you must use a Twig `block` named `content`.

	<!DOCTYPE html>
	<html lang="en">
	
	<head>
	    {% include "theme::partials/metadata" %}
	</head>
	
	<body>
	
	{% include "theme::partials/navigation" %}
	
	<div id="content">
	    <div class="container">
	    
	    	// Display the inner HTML
			{% block content %}{% endblock %}
	        
	    </div>
	</div>
	
	{% include "theme::partials/footer" %}
	{% include "theme::partials/scripts" %}
	
	</body>
	
	</html>

<a name="assets"></a>
### Assets

When using the `asset` and `image` plugins, the `theme::` prefix refers to the theme's `resources` directory. You can organize your `js`, `css`, `less`, `scss`, `coffee script` and other assets like `images` however you like.

	// Add resources/less/example.less to theme.css
	
	{{ asset_add("theme.css", "theme::less/example.less") }}
	
	// Obtaining the URL for resources/img/example.jpg
	
	{{ image_url("theme::img/example.jpg") }}

As with views you may also, if you desire, reference assets from another addon by using it's namespace prefix.

	// Add example-module/resources/js/example.js to theme.js
	
	{{ asset_add("theme.js", "anomaly.module.example::js/example.js") }}
	
	// Obtaining the URL for example-module/resources/img/example.jpg
	
	{{ image_url("anomaly.module.example::img/example.jpg") }}

For more information on the asset and image plugins please see their documentation.

#### Required Asset Collections

If you will be rendering field type inputs in your content that have JS dependencies you must render them using the `asset_scripts` plugin function to include the `scripts.js` collection.

	{% for script in asset_scripts("scripts.js") %}
		{{ script|raw }}
	{% endfor %}

You may include the `styles.css` for field types in a similar fashion by including the `styles.css` collection.

	{% for style in asset_styles("styles.css") %}
		{{ style|raw }}
	{% endfor %}

<a name="overriding-views"></a>
### Overriding Views

The active theme may override views from any other addon. In order to override a view you must register the override in the theme's service provider. Simply add overridden themes to the `$overrides` array of the service provider where the key is the view to be overridden and the value is the overriding view.

	<?php namespace Anomaly\StarterTheme;
	
	use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
	
	class StarterThemeServiceProvider extends AddonServiceProvider
	{
	
	    protected $overrides = [
	        'streams::errors/404' => 'theme::errors/404',
	        'streams::errors/500' => 'theme::errors/500'
	    ];
	
	}

#### Overriding Views For Mobile User Agents

You may also override views specifically for mobile user agents by adding the views to override to the `$mobile` property of the service provider.

	<?php namespace Anomaly\StarterTheme;
	
	use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
	
	class StarterThemeServiceProvider extends AddonServiceProvider
	{
	
	    protected $mobile = [
	        'streams::table/table' => 'theme::ui/table'
	    ];
	
	}

<a name="other-components"></a>
### Other Components

While themes can not be installed and thus can not create streams, they share the same base addon class. however unlikely it may that you need to, you may use many of the basic services and components outlined in addon documentation.

For example, the theme's [service provider](../../basics/addons#service-provider) can register anything you may need. You can also utilize the theme's `src` folder however you see fit.

It is, however, encouraged to keep logic that should be in a different addon in said addon. Themes should remain consistent with their primary purpose which is displaying content.