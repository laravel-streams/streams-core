---
title: Extending
category: advanced
intro: Extend and customize Streams core.
stage: outlining
enabled: true
sort: 2
---

## Introduction

Streams architecture is designed to support systemic customization and extension.

Before continuing, please familiarize yourself with [Laravel's service container](https://laravel.com/docs/8.x/container).


## The Basics

Below is essential knowledge on how to extend streams core.

### Macros

All basic services and components are "macroable" and allow direct extension via Laravel **macros**. Typically, you should declare collection macros in the **boot** method of a [service provider](providers).

```php
use Streams\Core\Stream\Stream;
use Streams\Ui\Table\TableBuilder;

Stream::macro('table', function ($attributes = []) {

    // Grab the UI config off the stream.
    $configuration = Arr::get($this->ui, 'table', []);

    $configuration = Arr::undot($configuration);

    // Merge configured and passed attributes.
    $attributes = array_merge($configuration, $attributes);

    // Set the stream.
    $attributes['stream'] = $this;

    return new TableBuilder($attributes);
});

$table = Streams::make('contacts')->table();
```


### Callbacks



### Workflows
### View Overrides


### Parsing
## Addon Development
