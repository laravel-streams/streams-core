# Addons

- [Introduction](#introduction)
	- [Modules](#modules)
	- [Field Types](#field-types)
	- [Plugins](#plugins)
	- [Themes](#themes)
	- [Extensions](#extensions)
- [Addon Structure](#addon-structure)
	- [Addon Locations](#locations)
	- [Folder Structure](#folder-structure)
	- [Required Components](#required-components)
- [The Addon Service Provider](#service-provider)
	- [Routes](#registering-routes)
	- [Plugins](#registering-plugins)
	- [Middleware](#registering-middleware)
	- [Listeners](#registering-listeners)
	- [Providers](#registering-providers)
	- [Bindings](#registering-bindings)
	- [Singletons](#registering-singletons)
	- [Commands](#registering-commands)
	- [Schedules](#registering-schedules)
	- [View Overrides](#registering-view-overrides)
	- [Mobile View Overrides](#registering-mobile-view-overrides)


<a name="introduction"></a>
## Introduction

Addons are organized bundles of code that you can use to add functionality. You can either create your own, or use some of the addons available on the store. 

All addons follow the same basic structure, same storage pattern and can often provide the same or similar basic services (like an `AddonServiceProvider`).

Addons are organized into six different types based on their structure and *intended* use: Modules, Field Types, Plugins, Themes, and Extensions. 

<a name="modules"></a>
### Modules

Modules are the primary building blocks of an application. They are the largest type of addon. They have a place in the control panel menu (usually), and can provide control panel content, plugins, services, and much more.

For example, the Partials module contains the control panel area that allows you to create and organize snippets of content and a plugin to allow you to access partials in views.

Modules can, and often do, have public-facing controllers as well.

For example, the Posts module allows you to manage posts and post types in the control panel, but also provides public controllers for displaying posts, categories and more using your public theme.

<a name="field-types"></a>
### Field Types

Field types are the basic building blocks of your entire application's UI and data. They are created and assigned to Streams and handle the setting up of custom data structures and rendering the input to manage it.

Field types represent the types of data you can add to a Stream. They contain all the logic regarding getting data in and out of the database, formatting it correctly, and validating it.

An example of a very simple field type is the [Text Field Type](https://github.com/anomalylabs/text-field_type). It allows you to create a simple text input. There are also field types for date/time, select/checkboxes, related entries, and more.

<a name="plugins"></a>
### Plugins

Plugins are essentially [Twig extensions](http://twig.sensiolabs.org/doc/advanced.html). While most plugins provide Twig [functions](http://twig.sensiolabs.org/doc/advanced.html#id2) they can provide [token parsers](http://twig.sensiolabs.org/doc/advanced.html#defining-a-token-parser), [node visitors](http://twig.sensiolabs.org/doc/advanced.html#defining-a-node), [globals](http://twig.sensiolabs.org/doc/advanced.html#id1), [filters](http://twig.sensiolabs.org/doc/advanced.html#id3), [tags](http://twig.sensiolabs.org/doc/advanced.html#id4), [operators](http://twig.sensiolabs.org/doc/advanced.html#operators), and [tests](http://twig.sensiolabs.org/doc/advanced.html#id5).

An example of a simple Plugin is the [Request Plugin](https://github.com/anomalylabs/request-plugin). It allows you to access information from Laravel's Request object.

	{{ request_segment(2) }}

<a name="themes"></a>
### Themes

Themes come in two varieties; **public** and **admin**. Themes are responsible for displaying content for the control panel and public facing application or site.

<a name="extensions"></a>
### Extensions

Extensions lets developers build applications that are closed for modification and open for **extension**. They are a "wild card" addon. Extensions can do anything that any of the other addon types can do. Extensions can do anything! Examples range from simply [providing an API package](https://github.com/anomalylabs/aws_sdk-extension), to providing [driver functionality](https://github.com/anomalylabs/local_storage_adapter-extension) to addons, to providing a [special service](https://github.com/anomalylabs/throttle_security_check-extension) for an addon.


<a name="addon-structure"></a>
## Addon Structure

Addons all extend their base addon type class which then extends the generic addon class. They are also all loaded in the exact same fashion. This means that the structure, features and *basic* behavior are all the same.

<a name="locations"></a>
### Addon Locations

Addon locations follow a specific pattern based on Composer and PSR autoloading standards. No matter what directory an addon is located in, it will **always** be in it's **vendor directory**. Vendors of addons are very similar and often the same as vendors of Composer packages.

Addons can be located in 3 different directories:

#### Core

Core addons are accessible to all applications in a multi-application environment. Any addons included in your application's `composer.json` file will be located here:

	core/{vendor}/*

#### Shared

Any addons that can be shared across different application in a single installation are located here:

	addons/shared/{vendor}/*

#### Private

Any addons that can only be accessed by a specific application are located here:

	addons/{application}/{vendor}/*


<a name="folder-structure"></a>
### Folder Structure

To create an addon, first create the it's folder in one of the above [addon locations](#locations). The folder **must** follow this pattern:

	{slug}-{type}

A few simple examples are:

	// The pages module
	pages-module
	
	// The text field type
	text-field_type
	
	// The default authenticator extension
	default_authenticator-extension

You will notice that core addons generally use the same exact pattern for repository names and [Packagist](https://packagist.org/) listing.

<a name="required-components"></a>
### Required Components

In order to simply load, all addons must contain at least these required files:

	addon-folder/composer.json
	addon-folder/src/AddonClass.php

The `composer.json` is only *required* to provide an autoloading definition for it's addon.

	{
	    "autoload": {
	        "psr-4": {
	            "ExampleVendor\\ExampleModule\\": "src/"
	        }
	    }
	}

It may, however provide more information that is used both by [Packagist](https://packagist.org/) and the addons module internally.

	{
	    "name": "anomaly/pages-module",
	    "type": "streams-addon",
	    "description": "Public content and page management.",
	    "keywords": [
	        "streams module",
	        "streams addon",
	        "module"
	    ],
	    "homepage": "http://anomaly.is/",
	    "version": "1.0.0",
	    "license": "MIT",
	    "authors": [
	        {
	            "name": "AnomalyLabs, Inc.",
	            "email": "hello@anomaly.is",
	            "homepage": "http://anomaly.is/",
	            "role": "Owner"
	        }
	    ],
	    "support": {
	        "email": "support@anomaly.is"
	    },
	    "autoload": {
	        "psr-4": {
	            "Anomaly\\PagesModule\\": "src/"
	        }
	    },
	    "extra": {
	        "branch-alias": {
	            "dev-1.0/master": "1.0.x-dev"
	        }
	    }
	}

The AddonClass is a PSR compliant class that must *at least* extend the base addon class for it's type.

	<?php namespace Anomaly\PagesModule;

	use Anomaly\Streams\Platform\Addon\Module\Module;

	class PagesModule extends Module
	{

	}

If we look at the pattern this file must use, it looks like this:

	<?php namespace {vendor}\{slug}{type};

	use Anomaly\Streams\Platform\Addon\Module\Module;

	class {slug}{type} extends {type}
	{

	}

Different addon types may accept more features but by default nothing is *usually* required. The necessary logic is inherited and setup automatically.

For more information on what more can be done in addon type classes see their respective documentation.

### Congratulations!

Following this simple location, folder and file pattern, your addon will load and display in the Addons module.

Now you can easily develop your addon to do something awesome!


<a name="service-provider"></a>
## The Addon Service Provider

All addons support an optional addon service provider. The service provider acts as a normal Laravel service provider and is responsible for registering your addon's routes, classes, services, singletons, events, commands, plugins, view overrides and more. Don't worry though, the addon service provider is designed to let you do all of this with simple arrays.

To get started, create your service provider class. The class name of your addon service provider is *directly* related to your addon class name. Simply add `ServiceProvider` to the end of it.

	ExampleModule transforms to: ExampleModuleServiceProvider
	ExampleTheme  transforms to: ExampleThemeServiceProvider

A simple addon service provider might look like this: 

	<?php namespace Anomaly\ExampleModule;

	use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

	class ExampleModuleServiceProvider extends AddonServiceProvider
	{

	}

From this point, you can start adding properties to handle registering various services.

<a name="registering-routes"></a>
### Routes

Every module will need to register routes, this is how you wold register a couple simple routes:

	protected $routes = [
		'admin/pages/example'     => PagesController::class . '@example',
		'admin/pages/delete/{id}' => PagesController::class . '@delete'
	];

A more complex route might look like this:

	protected $routes = [
		'pages/example/{slug}' => [
			'use'         => PagesController::class . '@view',
			'constraints' => [
				'slug' => '[a-z0-9_-]'
			],
			'parameter'   => 'example',
			'anomaly.module.users::permission' => 'anomaly.module.pages::pages.do_something'
		]
	];

The above route not only defines the route and action, but also adds a constraint to the `slug` parameter and defines a permission that the users module will authorize against current user.

Route arrays generally route just like this `Route::any(key, value)->where(array_get(value, constraints);`.

A list of route parameters and how they work will be available in each individual module's documentation.

For more information on event listeners please see [Laravel's routing documentation](http://laravel.com/docs/5.1/routing).

<a name="registering-plugins"></a>
### Plugins

Oftentimes an addon will include it's own Plugins. Here is how to register plugins from the addon service provider.:

	protected $plugins = [
		ExampleModulePlugin::class,
		FooBarPlugin::class
	];

<a name="registering-middleware"></a>
### Middleware

Registered middleware runs in the base controller - any controller that extends `Anomaly\Streams\Platform\Http\Controller\PublicController` or `Anomaly\Streams\Platform\Http\Controller\AdminController` will run registered middleware.

	protected $middleware = [
		MyCustomMiddleware::class
	];

For more information on middleware please see [Laravel's middleware documentation](http://laravel.com/docs/master/middleware).

<a name="registering-listeners"></a>
### Listeners

Registering event listeners could not be easier. Just define the array of `event => [listeners]`.

	protected $listeners = [
		ExampleEventWasTriggered::class => [
			DoSomething::class,
			DoMore::class
		]
	];

For more information on event listeners please see [Laravel's event documentation](http://laravel.com/docs/5.1/events).

<a name="registering-providers"></a>
### Service Providers

You can also register additional service providers from the `AddonServiceProvider`. 

	protected $providers = [
		ExampleServiceProvider::class
	];

Service providers registered here will be ran by Laravel just like any other service provider.

For more information on service providers please see [Laravel's service providers documentation](http://laravel.com/docs/5.1/providers).

<a name="registering-bindings"></a>
### Bindings

Register interface and other class bindings like this:

	protected $bindings = [
		ExampleInterface::class => ExampleImplementation::class,
		ExampleModel::class     => MyCustomExampleModel::class
	];

The first binding registers an interface to an implementation and the second binds a model to a custom model.

For more information on binding please see [Laravel's service container documentation](http://laravel.com/docs/5.1/container).

<a name="registering-singletons"></a>
### Singletons

Similar to bindings above, register singleton interfaces and other classs bindings like this:

	protected $singletons = [
		ExampleInterface::class => ExampleImplementation::class
	];

For more information on binding please see [Laravel's service container documentation](http://laravel.com/docs/5.1/container).

<a name="registering-commands"></a>
### Commands

Similar to other classes you can register artisan console commands like this:

	protected $commands = [
		ExampleCommand::class
	];

For more information on artisan commands please see [Laravel's artisan console documentation](http://laravel.com/docs/5.1/artisan).

<a name="registering-schedules"></a>
### Schedules

You can register scheduled console commands easily from the addon service provider. Here is an example on how to run the `ExampleCommand` every 5 minutes.

Don't forget to register the command as well!

	protected $schedule = [
		'*/5 * * * *' => [
			ExampleCommand::class
		]
	];

For more information on command schedules please see [Laravel's scheduling documentation](http://laravel.com/docs/5.1/scheduling).

<a name="registering-view-overrides"></a>
### View Overrides

Though typically done in themes, you can override any view from any addon. Override views by defining them like `view => override`. For example:

	protected $overrides = [
		'anomaly.module.users::login' => `anomaly.theme.example::my_login'
	];

<a name="registering-mobile-view-overrides"></a>
### Mobile View Overrides

Even with the elegance of responsive design these days sometimes you just need to override a view for a mobile device. Define mobile view overrides exactly like normal view overrides.

	protected $mobile = [
		'anomaly.module.users::login' => `anomaly.theme.example::my_mobile_login'
	];
