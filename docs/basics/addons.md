# Addons

- [Introduction](#introduction)
	- [Modules](#modules)
	- [Field Types](#field-types)
	- [Plugins](#plugins)
	- [Themes](#themes)
	- [Extensions](#extensions)
- [Addon Structure](#addon-structure)
	- [The Anatomy Of An Addon](#anatomy)
	- [Addon Locations](#locations)

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

Field types are the basic building blocks of your entire application's UI and data. They are created and assigned to Streams and handle the setting up of custom data structures and rending the input to manage it.

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

Extensions lets developers build applications that are closed for modification and open for **extension**. They are a "wild card" addon. Extensions can do anything that any of the other addon types can do. Extensions do anything from simply [provide an extra API](https://github.com/anomalylabs/aws_sdk-extension) to providing [driver functionality](https://github.com/anomalylabs/local_storage_adapter-extension) to modules to providing a [special service](https://github.com/anomalylabs/throttle_security_check-extension) for a module.


<a name="addon-structure"></a>
## Addon Structure

Addons all extend their base addon type class which then extends the generic addon class. They are also all loaded in the exact same fashion. This means that the structure, features and *basic* behavior are all the same.

<a name="anatomy"></a>
### The Anatomy Of An Addon

<a name="locations"></a>
### Addon Locations