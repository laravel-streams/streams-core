# Builders

- [Introduction](#introduction)
	- [Primary](#primary)
	- [Components](#components)
- [Creating Builders](#creating-builders)
	- [Configuration](#configuration)

<a name="introduction"></a>
## Introduction

Builders provide a convenient mechanism to build and render powerful UI objects with little to no setup at all using a common `Builder Pattern`. Builders can be used to make tables, forms, sortable lists, dashboard widgets and more.

The primary purpose of builders is to give the developer a *simple* interface to build complex objects, while not limiting the developer when advanced situations arise.

<a name="primary"></a>
### Primary

The primary is the object the builder is building. The builder uses it's various configuration to build the primary object and it's components and render it.

<a name="components"></a>
### Components

Components are configurable objects that make up the object being built. For example, a form builder has action, button, field and section components (as well as options).

<a name="creating-builders"></a>
## Creating Builders

To get started in creating a builder first create your builder class that extends the base builder class.

	<?php namespace Anomaly\ForumModule\Category\Form;

	use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
	
	class CategoryFormBuilder extends FormBuilder
	{
	
	}

Please refer to the documentation for the specific builder to determine which base builder class to extend with your own.

<a name="configuration"></a>
### Configuration

You can configure builders and components in a number of different ways depending on the complexity of configuration needed.