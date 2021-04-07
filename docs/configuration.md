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

## Configuring Streams Core

Below are the contents of the published configuration file:

```php
// config/streams/core.php

return [
    // Waiting
];
```
