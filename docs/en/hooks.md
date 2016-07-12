# Hooks

- [Introduction](#introduction)
	- [Registering Hooks](#registering-hooks)
	- [Binding Hooks](#binding-hooks)
	- [Calling Hooks](#calling-hooks)

<hr>

<a name="introduction"></a>
## Introduction

A hook is a method in PyroCMS of adding functionality to a class without having to extend it. This is especially helpful when you would need to extend or decorate a class multiple times with different extending behaviors. This way, you can leave the class as is, and still extend the classes abilities from different locations.

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

	$hookable->hook("test_me", function($text = "Hello") {
		return $text . "!"
	});

<div class="alert alert-info">
<strong>Note:</strong> Hooks are called with Laravel's service container and support direct injection.
</div>

	$hookable->hook("example", function(Application $application) {
		return $application->getReference();
	});

<a name="binding-hooks"></a>
### Binding Hooks

Binding hooks is very similar to registering them but for one very important difference; when you **bind** a hook, the `$this` variable will be the object the hook is being called on *just like a native method*. Whereas the registered hook will behave like a normal closure. Here is an example to illustrate this difference.

	<?php namespace Anomaly\SimpleModule;

	use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
	use Anomaly\Streams\Platform\Entry\EntryModel;

	class SimpleModuleServiceProvider extends AddonServiceProvider
	{
		
	    public function register(EntryModel $model)
	    {
	        $model->hook(
		    	'normal_hook',
		    	function () {
					return get_class($this); // Anomaly\SimpleModule\AddonServiceProvider
		    	}
	        );
	        
	        $model->bind(
            	'bound_hook',
            	function () {
					return get_class($this); // Anomaly\Streams\Platform\Entry\EntryModel
            	}
	        );
	    }
	}

<a name="calling-hooks"></a>
### Calling Hooks

Hooks can be called just like any other method on your class. When calling hooks use the camel case of it's name.

	echo $hookable->testMe("Nice"); // Nice!
	
	echo $hookable->example(); // pyro

You can also "call" them using property access. When running hooks this way use the snake case of the hooks name.

	echo $hookable->test_me; // Hello!

<div class="alert alert-primary">
<strong>Pro Tip:</strong> Registering hooks on base classes allows inheritance of hooks by extending classes.
</div>