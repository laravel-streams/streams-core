# Request Lifecycle

- [Introduction](#introduction)
- [Service Provider](#service-provider)

<hr>

<a name="introduction"></a>
## Introduction

The request lifecycle in PyroCMS is nearly identical to the [request lifecycle in Laravel](https://laravel.com/docs/5.1/lifecycle).

The primary difference between PyroCMS and a basic Laravel installation is the inclusion of the streams platform service provider in `config/app.php`.

<hr>

<a name="service-provider"></a>
## Service Provider

The `\Anomaly\Streams\Platform\StreamsServiceProvider` is the only difference in the Laravel request lifecycle.

#### Including Extra Services

Aside from addons, you can also easily add various services in `config/streams.php` that will be included during `register`.

After the base services for Streams Platform are registered the `boot` method is ran. This method continues setting up now existing classes but more importantly, the `boot` method _registers all addons_.