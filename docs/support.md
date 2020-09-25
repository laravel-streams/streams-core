---
title: Support
category: basics
intro: 
stage: drafting
enabled: true
sort: 99
todo: 
    - Any more to add?
---

## Arr

The following methods have been added to Laravel's [array helper](https://laravel.com/docs/helpers#arrays).

```php
use Illuminate\Support\Arr;

Arr::make($target);
```

### Arr::make()

Convert the target recusively to array values. This method leverages `toArray` and public propertis of objects to resolve arrays as well.

```php
Arr::make($target);
Arr::make($collection);
```

### Arr::parse()

Recusively [parse](#str-parse) an array of target values. This method leverages `Arr::make()` to ensure an array target.

```php
Arr::parse($target, $entry);
Arr::make($target, ['entry' => $entry]);
```

### Arr::undot()

Converts array keys with dots to nested key values. This is the opposite of Laravel's [Arr::dot()](https://laravel.com/docs/helpers#method-array-dot) method.

```php
$dotted = [
    'foo.bar' => 'baz'
];

$undotted = Arr::undot($dotted);

array:1 [
  "foo" => array:1 [
    "bar" => "baz"
  ]
]
```

## Str

The following methods have been added to Laravel's [string helper](https://laravel.com/docs/helpers#strings).

```php
use Illuminate\Support\Str;

Str::humanize($value);
```

### Str::parse()

The `parse` methods uses [Arr::make()](#arr-make) on the **payload** and parses the **string** with the array using a dot notation.-m-0

```php
$payload = [
    'foo' => [
        'bar' => 'baz',
    ],
];

// Example: baz
Str::parse('Example {foo.bar}', $payload);

// Hi Ryan
Str::parse('Hi {name}', $entry);
```

### Str::purify()

Vigurously cleanse the **target** value of any impure content or malicious intent.

```php
$clean = Str::purify($dirty);
```

### Str::humanize()

Humanize a [string slug](https://laravel.com/docs/helpers#method-fluent-str-slug). This method returns all **lowercase**.

```php
$segment = 'streams-platform_v2';

// streams platform v2
$title = Str::humanize($segment);

// Streams Platform V2
echo ucwords($title);
```

### Str::markdown()

Parse a markdown string using the fantastic [Parsedown package](https://github.com/erusev/parsedown). You 

```php
$markdown = '#Hello';

// <h1>Hello</h1>
echo Str::markdown($markdown);
```

### Str::linkify()

Wrap all URLs within **target** with links.

```php
$urls = 'Example: https://streams.dev/docs';

// Example: <a href="https://streams.dev/docs">https://streams.dev/docs</a>
echo Str::linkify($urls);
```

### Str::truncate()

Truncate a string **value** to a given **length**. A third **end** argument maybe be used to specify the string ending which defaults to "**...**".

```php
$lengthy = 'My long winded introduction has to start with my childhood.';

// My long winded intro...
echo Str::truncate($lengthy, 20);
```
