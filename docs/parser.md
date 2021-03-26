---
title: Parsing Variables
category: developers
enabled: true
sort: 90
---

## Introduction

Streams parses variables within strings to allow dynamic configuration.

### Request Variables

The following `request` variables are available:

```php
'request' => [
    'url'      => Request::url(),
    'path'     => Request::path(),
    'root'     => Request::root(),
    'input'    => Request::input(),
    'full_url' => Request::fullUrl(),
    'segments' => Request::segments(),
    'uri'      => Request::getRequestUri(),
    'query'    => Request::getQueryString(),
    'parsed'   => array_merge($parsed, [
        'domain' => explode('.', $parsed['host'])
    ]),
],
```

### URL Variables

The following `URL` variables are available:

```php
'url' => [
    'previous' => URL::previous(),
],
```

### Route Variables

The following `route` variables are available:

```php
'route' => [
    'uri'                      => Request::route()->uri(),
    'parameters'               => Request::route()->parameters(),
    'parameters.to_urlencoded' => array_map(
        function ($parameter) {
            return urlencode($parameter);
        },
        array_filter(Request::route()->parameters())
    ),
    'parameter_names'          => Request::route()->parameterNames(),
    'compiled'                 => [
        'static_prefix'     => Request::route()->getCompiled()->getStaticPrefix(),
        'parameters_suffix' => str_replace(
            Request::route()->getCompiled()->getStaticPrefix(),
            '',
            Request::getRequestUri()
        ),
    ],
],
```

@todo clean up and use table/values.
