# Resolver

- [Introduction](#introduction)
    - [Handlers](#handlers)
- [Basic Usage](#basic-usage)

<hr>

<a name="introduction"></a>
## Introduction

PyroCMS provides convenient value resolution service.

By using `\Anomaly\Streams\Platform\Support\Resolver` you can recursively resolve value handlers and closures for a string or array.

<a name="handlers"></a>
### Handlers

Pyro's core heavily leverages value resolution which means you can define the value for a form attribute, field config value, or anything else you need as a closure or even define a callable class string to handle returning the value.

Consider a field for a form that we want to use a handler for the default value:

    protected $fields = [
        'name' => [
            'config' => [
                'default_value' => DefaultValueHandler::class
            ]
        ]
    ];

And the handler class could look like this:

    class DefaultValueHandler
    {
        public function handle(Request $request) {
            return $request->get('default', 'foo');
        }
    }

You could just as easily define the `default_value` with a closure too. The resolver service will resolve any combination of handlers.

<div class="alert alert-primary">
<strong>Pro Tip:</strong> Handlers can be self handling or defined like QualifiedClass@handle too.
</div>

<a name="basic-usage"></a>
### Basic Usage

To leverage the Resolver in your own code simply call the `resolve` method on your `$target` and pass along any `$payload` data.

    $payload = compact('entry');

    $value = [
        'foo' => HandlerClass::class . '@handle',
        'bar' => function(EntryInterace $entry) {
            return $entry->getId();
        }

    $resolved = app('Anomaly\Streams\Platform\Support\Resolver')->resolve($value, $payload);

<div class="alert alert-info">
<strong>Pro Tip:</strong> Handlers are called with Laravel's service container. Any method dependencies / dependency injections that are not included in the payload will be automatically resolved.
</div>
