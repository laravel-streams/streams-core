# Builders

- [Introduction](#introduction)
	- [The Primary Object](#the-primary-object)
	- [Component Objects](#component-objects)
	- [Component Definitions](#component-definitions)
- [Creating Builders](#creating-builders)
- [Configuration](#configuration)
	- [Builder Properties](#builder-properties)
	- [Property Handlers](#property-handlers)
- [Input Processing](#input-processing)
	- [Resolving Input](#resolving-input)
	- [Default Input](#default-input)
	- [Normalize Input Parameters](#normalize-input-parameters)
	- [Predict Input Parameters](#predict-input-parameters)
	- [Guess Input Parameters](#guess-input-parameters)
	- [Merge With Pre-registered Parameters](#merge-with-pre-registered-parameters)
 	- [Parse Input](#parse-input)
	- [Evaluate Input](#evaluate-input)

<a name="introduction"></a>
## Introduction

Builders provide a convenient mechanism to build and render powerful UI objects with little to no setup at all using a common `Builder Pattern`. Builders can be used to make tables, forms, sortable lists, dashboard widgets and more.

The primary purpose of builders is to give the developer a *simple* interface to build complex objects, while not limiting the developer when advanced situations arise.

Configurations, definitions, and otherwise instructions for the builder are all referred to as it's `input`.

<a name="the-primary-object"></a>
### The Primary Object

The primary is the object the builder is building. The builder uses it's various configuration to build the primary object and it's components and render it.

The builder is always aptly named for the type of primary object it is building. Form builders build forms, table builders build tables, etc.

<a name="component-definitions"></a>
### Object Components

Components are smaller configurable objects that make up the object being built. For example, the form builder has action, button, field and section components (as well as options) by default.

Please refer to the documentation for specific builders for what components are available.

<a name="component-definitions"></a>
### Component Definitions

Component definitions are the configuration inputs from the builder (see [configuration](#configuration) below). The definition is used to define how the component object will be built.

You can often use a simple string as a definition and let the system normalize and default the rest of the definition else.

	protected $buttons = [
		'new_category'
	];

The definition above is a special format for creating new/add buttons quickly. The same button could be defined like this:

	protected $buttons = [
		'icon'       => 'fa fa-plus',
		'type'       => 'success',
		'text'       => 'anomaly.module.forum::button.new_category',
		'attributes' => [
		   	'href' => 'http://example.com/admin/forum/caetgories/create'
		]
	];

This is just one example of how definitions are processed and automated. For more information on specific component definition behavior please see documentation for specific builders.

<a name="creating-builders"></a>
## Creating Builders

To get started in creating a builder first create your builder class that extends the base builder class.

	<?php namespace Anomaly\ForumModule\Category\Form;

	use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
	
	class CategoryFormBuilder extends FormBuilder
	{
	
	}

Please refer to the documentation for specific builders to determine which base builder class to extend with your own.

<a name="configuration"></a>
## Configuration

You can configure builders and their components in a number of different ways depending on the complexity of configuration needed. Configuring the builder and it's components tells the builder how to build the primary object, it's components and how to handle any other configurable processes.

Please refer to the documentation for specific builders to determine configurable components and options and also what their default values are.

<a name="builder-properties"></a>
### Builder Properties

The easiest way to configure builders is to simply override the builder's properties.

	<?php namespace Anomaly\ForumModule\Category\Form;

	use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
	
	class CategoryFormBuilder extends FormBuilder
	{
		protected $fields = [
			'name',
			'slug'
		];
	}

<a name="property-handlers"></a>
### Property Handlers

Sometimes you may wish to configure the builder differently based on other logic. For example you may want to disable a field if the form is in `create` or `edit` mode. To do this you need to define a property handler.

	<?php namespace Anomaly\ForumModule\Category\Form;

	use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
	
	class CategoryFormBuilder extends FormBuilder
	{
		protected $fields = CategoryFormFields::class;
	}

Now we've told the builder to let `CategoryFormBuilder` to handle the setting of the configuration for `fields`. If the class implements `SelfHandling` then the `handle` method will be called however you may also define a full callable class and handler method. Property handlers are called from Laravel's service container and are always passed at least the `$builder` instance itself.

Here is a very straight forward example of how the above `CategoryFormFields` might look:

	<?php namespace Anomaly\ForumModule\Category\Form;

	use Anomaly\ForumModule\Category\Form\CategoryFormBuilder;
	use Illuminate\Contracts\Bus\SelfHandling;
	
	class CategoryFormFields
	{
		public function handle(CategoryFormBuilder $builder)
		{
			$builder->setFields(
				[
					'name',
					'slug' => [
						'disabled' => function() use ($builder) {
							return $builder->getFormMode() === 'edit';
						}
					]
				]
			);
		}
	}

#### Automatic Property Handlers

You can also let the system detect property handlers instead of setting them explicitly. The handler should be in the same namespace and replace `Builder` with the CamelCase version of the property name. For example `FooBarTableBuilder` would look for a column handler in the same namespace named `FooBarTableColumns`. 

All builder components and options support automatic property handlers.

<a name="input-processing"></a>
## Input Processing

All input is processed before it's used to build it's respective component object. This let's the developers specify simple input, closures, handlers, and even handlers for specific definition parameters.

<a name="resolving-input"></a>
### Resolving Input

First the input provided is resolved recursively. Resolving will take any input and any resulting input parameters and look for handler class strings like `Example\MyHandler@handle` and run them through Laravel's service container.

<a name="default-input"></a>
### Default Input

If no input is present at this time, the defaults will be applied. Setting a property to `false` will disable the respective component and prevent defaults from being used.

<a name="normalize-input-parameters"></a>
### Normalize Input Parameters

At this point the input is put through normalization. Normalization is different for different components but generally expands simple string definitions to full definitions and fills in missing parameters based on required parameters provided.

<a name="predict-input-parameters"></a>
### Predict Input Parameters

Occasionally certain parameters of input can be predicted initially early on in the processing. You may override this by passing the parameter yourself for a given definition input.

<a name="guess-input-parameters"></a>
### Guess Input Parameters

Similar to predicting, guessing will look at your existing input parameters and try and guess other parameters. For example, `create` or `add` buttons will guess an `href` like `{current_url}/create`.

<a name="merge-with-pre-registered-parameters"></a>
### Merge With Pre-registered Parameters

Many components have pre-registered parameters associated with a `type`. Merging is why a `create` button is green, says "Create", has a "+" icon, and has `{current_url}/create` as an HREF. All pre-registered parameters can be overridden by simply passing your parameters.

<a name="parse-input"></a>
### Parse Input

Parsing input takes the relative objects (usually an entry) and merges it's data into input parameters. For example an HREF like `foo/bar/edit/{entry.id}` is parsed to `foo/bar/edit/1`. There are many values available by default and different builders will pass along additional values to use. See documentation for parsing and for specific builders for more information on parsing payload.

<a name="evaluating-input"></a>
### Evaluating Input

Lastly the input is evaluated for closures recursively. Any closures used for definitions or definition parameters will be called through Laravel's service container. Different builders will pass different payload (usually an entry) along to be injected into the closure. See documentation for specific builders for more information on evaluation payload.