# Callbacks

- [Introduction](#introduction)
    - [Trigger](#trigger)
    - [Callback](#callback)
    - [Listener](#listener)
- [Basic Usage](#basic-usage)
	- [Registering Callbacks](#registering-callbacks)
	- [Firing Callbacks](#calling-callbacks)
- [Examples](#examples)

<hr>

<a name="introduction"></a>
## Introduction

A callback is a type of event in Pyro. Callbacks differ from events in that the scope is relative to a specific to an instance. Whereas events are broadcast across the entire application.

Callbacks consist of a `trigger` or callback name and the actual `callback`.

The `\Anomaly\Streams\Platform\Traits\FiresCallbacks` trait makes it easy to register and fire callbacks on anything from anywhere.

<a name="trigger"></a>
### Trigger

Triggers are similar to an event name. They are always snake case. Triggers are used when registering a callback, creating a handler method for a callback and also when firing callbacks.

    $this->on('trigger_name', $callback);

    $this->fire('trigger_name');

<a name="callback"></a>
### Callback

Callbacks are `Closure` functions that are registered to run when a specified `trigger` is fired.

    $callback = function() {
        // Do something.
    }

    $this->on('trigger_name', $callback);

Callbacks can also be handled with a method on the object named like `public function on{TriggerName}($arguments)`. Typically, methods are used to hook into core functionality from your extending class.

<div class="alert alert-info">
<strong>Note:</strong> Handling callbacks with methods will apply to all instsances.
</div>

    public function onTriggerName(Writer $log)
    {
        $log->info('Something happened!');
    }

<a name="listener"></a>
### Listener

Listeners are identical to callbacks but for one major difference. They apply to all instances of the firing object. This is great for consistently changing core behavior across the entire system.

    $this->listen('trigger_name', $callback);

<hr>

<a name="basic-usage"></a>
## Basic Usage

To get started simply use the `\Anomaly\Streams\Platform\Traits\FiresCallbacks` trait.

	<?php namespace App\Example;

	use Anomaly\Streams\Platform\Traits\FiresCallbacks;

	class Widget
	{

		use FiresCallbacks;

	}


<a name="registering-callbacks"></a>
### Registering Callbacks

To register a callback for a trigger on another class use the `on` method or the `listen` method for global callback listeners.

	$example->on('trigger_name', function() {
		// Do something.
	});

<div class="alert alert-info">
<strong>Note:</strong> Callbacks are called with Laravel's service container and support direct injection.
</div>

	$example->on('some_callback', function(Writer $log) {
		$log->info('Something happened!');
	});

<div class="alert alert-primary">
<strong>Remember:</strong> If needed, you can also register callbacks on <strong>$this</strong>.
</div>

#### Callback Methods

Callback methods are great for consistently hooking into behavior because they apply to all instances.

    public function onTriggerName()
    {
        // Do something.
    }

<a name="firing-callbacks"></a>
### Firing Callbacks

Callbacks are fired with the `fire` method. An optional set of arguments to send to the callback can also be provided.

	$this->fire("trigger_name", $arguments);

<hr>

<a name="examples"></a>
## Examples

By far, the most common example of this is the `querying` trigger on tables and other UI components.

Trigger: [https://github.com/anomalylabs/streams-platform/blob/master/src/Model/EloquentTableRepository.php#L70](https://github.com/anomalylabs/streams-platform/blob/master/src/Model/EloquentTableRepository.php#L70)
Callback: [https://github.com/anomalylabs/files-module/blob/master/src/File/Upload/UploadTableBuilder.php#L103](https://github.com/anomalylabs/files-module/blob/master/src/File/Upload/UploadTableBuilder.php#L103)
