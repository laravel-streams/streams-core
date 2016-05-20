# Breadcrumbs

- [Introduction](#introduction)
- [Basic Usage](#basic-usage)
	- [Adding Breadcrumbs](#adding-breadcrumbs)
	- [Displaying Breadcrumbs](#displaying-breadcrumbs)

<hr>

<a name="introduction"></a>
## Introduction

Breadcrumbs in general are automated. However they can be modified, disabled, and managed manually.

The `\Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection` class makes it easy to manage breadcrumbs.

<hr>

<a name="basic-usage"></a>
## Basic Usage

Breadcrumbs are a normal collection but typically added using the `add` method.

	$breadcrumbs->add($key, $url);

Where `$key` is a the text string and `$url` is the breadcrumb URL.

<a name="adding-breadcrumbs"></a>
### Adding Breadcrumbs

To get started simply use the `\Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection` class.

	<?php namespace App\Example;

	use Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection;

	class ExampleClass
	{

		public function example(BreadcrumbCollection $breadcrumbs)
		{
			$breadcrumbs->add('theme::page.home', url('home'));
		}

	}

You can also add breadcrumbs directly from your controller like this:

    $this->breadcrumbs->add('Home', '/');
    $this->breadcrumbs->add('About', 'about/me');

<div class="alert alert-info">
<strong>Note:</strong> Breadcrumbs are available as a property on public and admin controllers by default.
</div>

<a name="displaying-breadcrumbs"></a>
### Displaying Breadcrumbs

The breadcrumb collection is always available in the `template` variable within views.

	{% if template.breadcrumbs %}
	    <ol>
	        {% for breadcrumb, href in template.breadcrumbs %}
	            <li class="{{ loop.last ? 'active' }}">
	                <a href="{{ href }}">
	                    {{ trans(breadcrumb) }}
	                </a>
	            </li>
	        {% endfor %}
	    </ol>
	{% endif %}
