# Hooks

- [Introduction](#introduction)
	- [Registering Hooks](#registering-hooks)
	- [Calling Hooks](#calling-hooks)

<hr>

<a name="introduction"></a>
## Introduction

A hook is a method in Pyro of adding functionality to a class without having to extend it. This is especially helpful when you would need to extend or decorate a class multiple times with different extending behaviors. This way, you can leave the class as is, and still extend the classes abilities from different locations.

The `\Anomaly\Streams\Platform\Traits\Hookable` trait makes it easy to register and call hooks on anything from anywhere.

<a name="registering-hooks"></a>
### Registering Hooks

To get started simply add the `\Anomaly\Streams\Platform\Traits\Hookable` trait to your class.

	<?php namespace App\Example;
	
	use Anomaly\Streams\Platform\Traits\Hookable;
	
	class Widget
	{
		
		use Hookable;
		
	}

To register a hook to a class you simply call the `hook` method and define your hook **name** and a `Closure` **callback**. Hook names should always be snake case.

	(new Widget)->hook("test_me", function($text = "Hello") {
		return $text . "!"
	});

<div class="alert alert-info">
<strong>Note:</strong> Hooks are called with Laravel's service container and support direct injection.
</div>

	(new Widget)->hook("example", function(Application $application) {
		return $application->getReference();
	});

<a name="calling-hooks"></a>
### Calling Hooks

Hooks can be called just like any other method on your class. When calling hooks use the camel case of it's name.

	echo (new Widget)->testMe("Nice"); // Nice!
	
	echo (new Widget)->example(); // pyro

You can also "call" them using property access. When running hooks this way use the snake case of the hooks name.

	echo (new Widget)->test_me; // Hello!