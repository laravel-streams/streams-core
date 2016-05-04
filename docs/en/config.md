# Config

- [Introduction](#introduction)
    - [Overriding Configuration Files](#overriding-configuration-files)

<hr>

<a name="introduction"></a>
## Introduction

Configuration in PyroCMS work exactly the same as [configuration in Laravel](https://laravel.com/docs/5.1/installation#basic-configuration).

<a name="overriding-configuration-files"></a>
### Overriding Configuration Files

Addons ship with their own configuration files. Instead of hacking the addon files to tweak these lines, you may override them by placing your own files in the `resources` directory.

To override configuration files from the streams platform, use `resources/core/config/streams` or `resources/{$appReference}/config/streams`.

To override configuration files from addons, use `resources/core/config/addons/{$vendor}/{$addon}-{$type}` or `resources/{$appReference}/config/addons/{$vendor}/{$addon}-{$type}`.

So, for example, if you need to override the configuration values in `config.php` for the `anomaly/example-module` for the `default` site, you would place a config file at: `resources/default/config/addons/anomaly/example-module/config.php`. In this file you should only define the configuration lines you wish to override. Any configuration lines you don't override will still be loaded from the addon's original configuration files.