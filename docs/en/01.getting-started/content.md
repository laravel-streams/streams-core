---
title: Getting Started
layout: default
---

## [Getting Started](#home)

This section will help you get started in understanding what the **Streams Platform** is, it's role in **PyroCMS**, and how to use it.


### [Introduction](#introduction)

**The Streams Platform** is a [Composer](https://getcomposer.org/) package that acts as the foundation or engine for **PyroCMS**. Every addon in **PyroCMS** uses the **Streams Platform** to build it's tables, forms, nested lists, to install and uninstall, and to do many other things.


### [Installation](#installation)

**The Streams Platform** comes setup and ready right out of the box with **PyroCMS**. It's highly recommended to start projects that may not leverage the CMS aspects of **PyroCMS** with a general installation and remove what you don't need from there.

However, if you would like to install it in an existing **Laravel** application there are a couple things you need to do.

> **Notice:** If you are using **PyroCMS** the **Streams Platform** is already installed for you!


#### [Install with Composer](#installation_install-with-composer)

First require the composer package by running `composer require anomaly/streams-platform` or adding the following line to your `composer.json` file:

```json
    "anomaly/streams-platform": "latest",
```

> **Notice:** The last Streams Platform is currently compatible with Laravel `>=5.4` only.


#### [Register the service provider](#installation_register-the-service-provider)

Next you need to register the main service provider. To do this, you should add the following lines to the end of the `providers` section in `config/app.php` (added by default **PyroCMS** install):

```php
    /**
     * The Streams Platform main Service Provider
     */
    Anomaly\Streams\Platform\StreamsServiceProvider::class,
```


#### [Register the kernels](#_installation_register-the-kernels)

The **Streams Platform** adds low level functionality to the HTTP and console kernels. In order for this to work properly you must register the kernels in the `bootstrap/app.php` file:

```php
$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    Anomaly\Streams\Platform\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    Anomaly\Streams\Platform\Console\Kernel::class
);
```

You're all set! You can now use addons just like **PyroCMS** as well as all of the other services and utilities within the **Streams Platform**.
