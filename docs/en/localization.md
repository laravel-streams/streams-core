# Localization

- [Introduction](#introduction)
- [Overriding Language Files](#overriding-language-files)

<hr>

<a name="introduction"></a>
## Introduction

Localization in PyroCMS works exactly the same as [localization in Laravel](https://laravel.com/docs/5.1/localization).

<hr>

<a name="overriding-language-files"></a>
## Overriding Language Files

Addons ship with their own language files. Instead of hacking the addon files to tweak these lines, you may override them by placing your own files in the `resources` directory.

To override language files from the streams platform, use `resources/core/lang/streams/{$locale}` or `resources/{$appReference}/lang/streams/{$locale}`.

To override language files from addons, use `resources/core/lang/addons/{$vendor}/{$addon}-{$type}/{$locale}` or `resources/{$appReference}/lang/addons/{$vendor}/{$addon}-{$type}/{$locale}`.

So, for example, if you need to override the English language lines in `messages.php` for the `anomaly/example-module` for the `default` site, you would place a language file at: `resources/default/lang/addons/anomaly/example-module/en/messages.php`. In this file you should only define the language lines you wish to override. Any language lines you don't override will still be loaded from the addon's original language files.