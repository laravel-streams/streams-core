---
title: Configuration
category: getting_started
intro: Configuring the core.
sort: 2
enabled: true
---

## Configuration Files

Published configuration files reside in `config/streams/`.

``` files
├── config/streams/
│   └── core.php
```

### Publishing Configuration

Use the following command to publish configuration files.

```bash
php artisan vendor:publish --provider=Streams\\Core\\StreamsServiceProvider --tag=config
```

The above command will copy configuration files from their package location to the directory mentioned above so that you can modify them directly and commit them to your version control system.

## Configuring the Core

Below are the contents of the published configuration file:

```php
// config/streams/core.php

return [];
```


### Routes File

The `app/Providers/RouteServiceProvider.php` file typically uses the `api` middleware group when loading the `routes/api.php` file. By default this file is compatible with this package and routes defined there will be properly prefixed and grouped.

If you configure a non-standard middleware group to use, you will have to adjust all the above files accordingly.
