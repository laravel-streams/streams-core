# Config

- [Introduction](#introduction)
    - [Overriding Configuration](#overriding-configuration)

<hr>

<a name="introduction"></a>
## Introduction

Configuration in PyroCMS work exactly the same as [configuration in Laravel](https://laravel.com/docs/5.1/installation#basic-configuration).

<a name="overriding-configuration"></a>
### Overriding Configuration

Configuration for the streams platform and addons can be found in their respective locations but can be overridden in your root `resources` directory.

To override configuration values for all sites / applications in your PyroCMS installation use the core override path:

	resources/core/config

To override configuration values for a specific site / application only:

	resources/{app_reference}/config

Next, append the specific override path for the package or addon.

To override configuration found in the streams platform use `streams`:

	resources/core/config/streams

	resources/{app_reference}/config/streams

To override configuration found in a specific addon use `{vendor}/{slug}-{type}` similar to the addon's vendor directory and containing directory.

	resources/core/config/anomaly/posts-module

	resources/{app_reference}/config/anomaly/posts-module

Lastly, copy the config file to the above location and modify as needed!

For example, you can override the configuration value for `streams::addons.eager` by adding your own `addons.php` configuration file:

	resources/core/config/streams/addons.php

Within the `addons.php` file you can define your own `eager` value:

	<?php

	return [
	    'eager' => [
	    	'example.module.foo'
	    ]
	];

You can view available configuration for Streams Platform in `vendor/anomaly/streams-platform/resources/config`. Just copy files / values in the override directory.

You can override addon configuration in the same way.