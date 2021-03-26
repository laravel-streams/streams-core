---
title: Configuration
category: getting_started
intro: Streams uses Laravel config files and environment variables for application-level settings.
stage: review
enabled: true
sort: 2
---

## Configuration Files

Published configuration files reside in `config/streams/`.

``` files
├── config/streams/
│   └── core.php
```

#### Publishing Configuration

Use the following command to publish configuration files.

```bash
php artisan vendor:publish --vendor=Streams\\Core\\StreamsServiceProvider --tag=config
```

The above command will copy configuration files from their package location to the directory mentioned above so that you can modify them directly and commit them to your version control system.

## Environment Variables

It is often helpful to have different configuration values based on the environment in which your application is running. For example, you may wish to enable "debug mode" on your local server but not your production server.

### The `.env` File

Environmental variables are defined in the `.env` file in your project's root directory. In fresh installations, Composer will automatically rename the included `.env.example` file to `.env` for you.

You can manually copy and rename, or use `php -r "copy('.env.example', '.env');"` if the file does not already exist.

### Environment Variable Types

Variables in your `.env` files parse as strings. A couple specific values are worth noting:

```bash
EXAMPLE_VAR=        # (string) ''
EXAMPLE_VAR=null    # (null) null
```

If you need to define an environment variable value containing a space, you may enclose the value in double-quotes.

``` env
APP_NAME="Spaghetti + Meatballs"
```

### Retrieving Environment Variables

All environmental variables are available in configuration files by using the `env()` helper function. An optional second argument allows you to pass a default value.

``` php
// config/app.php
'debug' => env('APP_DEBUG', false),
```

Once passed into a config file, the variable is available using the `config()` helper function. Again, an optional second argument allows you to specify a default value.

``` php
// Retrieve the above 'debug' value:
config('app.debug', false)
```

### Do not version your `.env` file

The `.env` file **should not be committed to version control**. Each developer or server running your application may require a different environment configuration. It is also a security risk if a nefarious character gains access to your version control repository because sensitive data like credentials, API keys, and other configuration would be visible to them.

### Hiding Environment Variables from Debug Pages

When an exception is uncaught, and the `APP_DEBUG` environment variable is `true`, the debug page will show all environment variables and their assigned values. You may obscure variables by updating the `debug_blacklist` option in your `config/app.php` file.

``` php
return [

    // ...

    'debug_blacklist' => [
        '_ENV' => [
            'APP_KEY',
            'SECRET_API_KEY',
            'BITCOIN_WALLET_PW',
        ],

        '_SERVER' => [
            'APP_KEY',
            'DB_PASSWORD',
        ],

        '_POST' => [
            'password',
        ],
    ],
];
```


Learn more about [environment configuration](https://laravel.com/docs/configuration#environment-configuration) in the Laravel docs.
