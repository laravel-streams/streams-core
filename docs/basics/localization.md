# Localization

- [Introduction](#introduction)
    - [Configuring The Locale](#configuring-the-locale)
- [Basic Usage](#basic-usage)
    - [Pluralization](#pluralization)
- [Overriding Vendor Language Files](#overriding-vendor-language-files)

<a name="introduction"></a>
## Introduction

The localization features directly extend Laravel's features and provide a convenient way to retrieve strings in various languages, allowing you to easily support multiple languages within your application and addons.

Language strings are stored in files within the `resources/lang` directory of your addon. Within this directory there should be a subdirectory for each language supported by the application:

	/example-module
	    /resources
	        /lang
	            /en
	                messages.php
	            /es
	                messages.php

All language files simply return an array of keyed strings. For example:

    <?php

    return [
        'welcome' => 'Welcome to our application'
    ];

<a name="configuring-the-locale"></a>
### Configuring The Locale

There can be many different factors that determine what locale is "active" during use of your application. Let's take a look at the different methods of configuring the locale from least priority to highest priority.

#### Default Configuration

The default language for your application is stored in the `config/app.php` configuration file and by default uses the value from the `.env` file which was generated during installation.

The "fallback language" is also configured in `config/app.php` and by default uses the value stored in `.env`. The fallback will be used when the active language does not contain a given language line. 

**This is the default behavior if nothing else changes these values.**

#### Settings Module

Some addons will alter the locale based on user input. The `Settings Module` can be used to let system admins change the default language of your application. When set, the defined language will be set as the application's active locale very early during the boot process.

#### Preferences Module

The `Preferences Module` can be used to let the user set their preferred language too. The preferences module is very similar to the `Settings Module` above but is unique to a specific user. When set, the user's preferred language will be set as the application's active locale very early during the boot process.

#### Localization Hints

You may wish to use domain or URI hints to set the locale automatically. To do this, override the `streams::locales.hint` configuration value in `config/streams/locales.php`. If this file does exist, simply create it and add the `hint` configuration key. By default no `hint` is `true` which means both `uri` and `domain` hints will be detected.

If `domain` hints are enabled then your application will look for an i18n locale code in the sub domain of your application. For example `de.yoursite.com` will set your application's locale to German and override all other configurations. If no i18n code is found then the other configurations remain in effect.

If `uri` hints are enabled then your application will look for an i18n locale code in the first URI segment of your application. For example `yoursite.com/de/about-us` will set your application's locale to German and override all other configurations. If no i18n code is found then the other configurations remain in effect. There is no need to include the locale in your applications routing. With this configuration enabled, pretend the locale segment is not there.

<a name="basic-usage"></a>
## Basic Usage

You may retrieve lines from language files using the `trans` helper function. The `trans` method accepts the `prefixed` file and key of the language line as its first argument. For example, let's retrieve the language line `welcome` in the `example-module/resources/lang/messages.php` language file:

    echo trans('anomaly.module.example::messages.welcome');

If the Example module is currently active you can retrieve the same value using the short prefix:

    echo trans('module::messages.welcome');

You can also access the translation utility using Twig:

    {{ trans('anomaly.module.example::messages.welcome') }}

If the specified language line does not exist, the `trans` function will simply return the language line key. So, using the example above, the `trans` function would return `messages.welcome` if the language line does not exist.

#### Replacing Parameters In Language Lines

If you wish, you may define place-holders in your language lines. All place-holders are prefixed with a `:`. For example, you may define a welcome message with a place-holder name:

    'welcome' => 'Welcome, :name',

To replace the place-holders when retrieving a language line, pass an array of replacements as the second argument to the `trans` function:

    echo trans('anomaly.module.example::messages.welcome', ['name' => 'Ryan']);

<a name="pluralization"></a>
### Pluralization

Pluralization is a complex problem, as different languages have a variety of complex rules for pluralization. By using a "pipe" character, you may distinguish a singular and plural form of a string:

    'apples' => 'There is one apple|There are many apples',

Then, you may then use the `trans_choice` function to retrieve the line for a given "count". In this example, since the count is greater than one, the plural form of the language line is returned:

    echo trans_choice('anomaly.module.example::messages.apples', 10);

Since the Laravel translator is powered by the Symfony Translation component, you may create even more complex pluralization rules:

    'apples' => '{0} There are none|[1,19] There are some|[20,If] There are many',

<a name="overriding-vendor-language-files"></a>
## Overriding Vendor Language Files

Most addons may ship with their own language files. Instead of hacking the addon' core files to tweak these lines, you may override them by placing your own files in the `resources/lang/addon/{addon}/{locale}` directory.

So, for example, if you need to override the English language lines in `messages.php` for the `example-module`, you would place a language file at: `resources/lang/addon/example-module/en/messages.php`. In this file you should only define the language lines you wish to override. Any language lines you don't override will still be loaded from the package's original language files.