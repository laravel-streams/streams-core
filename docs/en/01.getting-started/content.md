---
title: Getting Started
---

## Getting Started[](#getting-started)

This section will help you get started in understanding what the Streams Platform is, it's role in PyroCMS, and how to use it.


### Introduction[](#getting-started/introduction)

The Streams Platform is a [Composer](https://getcomposer.org/) package that acts as the foundation or engine for PyroCMS. Every addon in PyroCMS uses the Streams Platform to build it's tables, forms, nested lists, to install and uninstall, and to do many other things.


### Installation[](#getting-started/installation)

The Streams Platform comes setup and ready right out of the box with PyroCMS. It's highly recommended to start projects that may not leverage the CMS aspects of PyroCMS with a general installation and remove what you don't need from there.

However, if you would like to install it in an existing Laravel application there are a couple things you need to do.

<div class="alert alert-warning">**Notice:** If you are using PyroCMS the Streams Platform is already installed for you!</div>


#### Install with Composer[](#getting-started/installation/install-with-composer)

First require the composer package by running `composer require anomaly/streams-platform` or adding the following line to your `composer.json` file:

    "anomaly/streams-platform": "1.1.x-dev"

<div class="alert alert-danger">**Notice:** The Streams Platform is currently compatible with Laravel 5.3 only.</div>


#### Register the service provider[](#getting-started/installation/register-the-service-provider)

Next you need to register the service provider. To do this add the following service provider to the end of the `providers` section in `config/app.php`:

    Anomaly\Streams\Platform\StreamsServiceProvider::class


#### Register the kernels[](#getting-started/installation/register-the-kernels)

The Streams Platform adds low level functionality to the HTTP and console kernels. In order for this to work properly you must register the kernels in the `bootstrap/app.php` file:

    $app->singleton(
        Illuminate\Contracts\Http\Kernel::class,
        'Anomaly\Streams\Platform\Http\Kernel'
    );

    $app->singleton(
        Illuminate\Contracts\Console\Kernel::class,
        'Anomaly\Streams\Platform\Console\Kernel'
    );

You're all set! You can now use addons just like PyroCMS as well as all of the other services and utilities within the Streams Platform.
