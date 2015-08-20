# Streams

- [Introduction](#introduction)
- [What Are Streams?](#what-are-streams)
	- [Stream Fields](#stream-fields)
	- [Field Assignments](#field-assignments)
	- [Stream Entries](#stream-entries)
- [Streams Usage](#streams-usage)
	- [Creating Streams](#creating-streams)
	- [Managing Entries](#managing-entries)

<a name="introduction"></a>
## Introduction

Every application requires defining structures of data. For example, a website may need a list of events, or a roster of bands. Each of these requires a data structure and a way to create, read, update, and delete entries. Streams is a powerful way of managing this data and structure, and it is baked into the structure of how your applications works. This page explains what streams are, how you can use them, and where to find out more information on various streams-related topics.

<a name="what-are-streams"></a>
## What Are Streams?

Streams are simply structures of data that you can store data in. Anything can be defined by a stream. For example, you could create a `stream` for TV Shows and add `fields` to it like title, category, a commercial image and so on.

On a technical level, streams are simply database tables (every stream represents a database table), so if you need to reference streams directly in with an Eloquent model, you can easily do that.

Streams are organized by their namespace. For example you could have a TV Shows stream and a TV Actors stream both in a `tv` namespace.

<a name="stream-fields"></a>
### Stream Fields

Fields represent the attributes of a stream. Fields can be used for multiple streams in the same namespace. For example, you may create a single name field and use it for both the TV Shows stream and the TV Actors stream.

#### Field Types

Every single field uses a field type that controls how the data for that field is managed. Field types can range from simple text and dropdown field types to complex content editors and file uploader field types.

Field types also handle how the data is passed in and out of the stream entry in the API.

<a name="field-assignments"></a>
### Field Assignments

Field assignments are a siple relationship between the stream and it's fields. Once you create a field and a stream, you must assign the field to the stream in order to use it. In this way, again, you can assign the same field to multiple streams in the same namespace.

Once you assign a field to a stream a column will be added to the stream's database table according to the field's field type.

<a name="stream-entries"></a>
### Stream Entries

If streams are represented by the database table and assigned fields by the table columns then entries are the rows in the database table.

Since streams extends Laravel's Eloquent model you can access stream entries using their models and work with them just like any other model.

<a name="stream-usage"></a>
## Stream Usage

Streams are tightly bound to Laravel's `migrations` and Eloquent `models`. If you know how to use these services you already know how to create and use streams... Fancy that!

<a name="creating-streams"></a>
### Creating Streams

Migrations are the default method of creating streams. To get started you will need to create or have a module or extension handy. Modules and extensions are the only addons that support migrations (which are ran when they install and uninstall).

Creating a migration for an addon is almost the same as creating any other Laravel migration. Let's make a migration for our TV module's fields:

	php artisan make:migration create_tv_fields --addon=anomaly.module.tv

This command will generate a migration in the TV module in the anomaly vendor directory. The migration will look just like a normal Laravel migration and can be used just the same. Since we're adding fields with this one though we will only create a `$fields` property and add our fields there.
	
	<?php
	
	use Anomaly\Streams\Platform\Database\Migration\Migration;
		
	class AnomalyModuleTvCreateTvFields extends Migration
	{
		
		protected $fields = [
			'title'       => 'anomaly.field_type.text',
			'slug'        => [
				'type'   => 'anomaly.field_type.slug',
				'config' => [
					'slugify' => 'title'
				]
			],
			'description' => 'anomaly.field_type.textarea',
			'category'    => [
				'type'   => 'anomaly.field_type.select',
				'config' => [
					'options' => [
						'mystery' => 'Mystery',
						'scifi'   => 'Sci-Fi'
					]
				]
			]
		];
	
	}

Now let's make a migration to create a `TV Shows` stream.

	php artisan make:migration create_tv_shows_stream --addon=anomaly.module.tv

In this migration we will define our stream and assign the fields we created earlier to it.

	<?php
	
	use Anomaly\Streams\Platform\Database\Migration\Migration;
		
	class AnomalyModuleTvCreateTvShowsStream extends Migration
	{
		
		protected $namespace = 'tv';
	
		protected $stream = [
			'slug'         => 'tv_shows',
			'title_column' => 'title',
			'translatable' => true
		];
		
		protected $assignments = [
			'title'  => [
				'required'     => true,
				'translatable' => true
			],
			'slug'  => [
				'required' => true,
				'unique'   => true
			],
			'description'  => [
				'required'     => true,
				'translatable' => true
			],
			'category'
		];
	
	}

We can now install / uninstall / reinstall this module which will cause these migrations to migrate, refresh or reset.

	php artisan module:install anomaly.module.tv
	
	php artisan module:uninstall anomaly.module.tv
	
	php artisan module:reinstall anomaly.module.tv

If you wish, you can also manage these migrations manually. This is a huge benefit when developing custom modules or extensions.

	php artisan migrate --addon=anomaly.module.tv
	
	php artisan migrate:reset --addon=anomaly.module.tv
	
	php artisan migrate:refresh --addon=anomaly.module.tv

<a name="managing-entries"></a>
### Managing Entries

Managing stream entries is the same as managing records with any other Eloquent model. When a stream is created an entry model is automatically generated in `storage/streams/{site_reference}/models/{namespace}`.

**Models generated in `storage` are not intended to be used directly in your addon.**

It is best practice to create a model in your addon that extends the generated model. For example our TV Shows model might look like this:

	<?php namespace Anomaly\TvModule\TvShow;
	
	use Anomaly\Streams\Platform\Model\Tv\TvTvShowsEntryModel;
	
	class TvShowModel extends TvTvShowsEntryModel
	{
	
	}

Now you can use the model to manage entries with typical Eloquent usage.

	$show = TvShowModel::find(1);
	
	$show->title = 'Columbo';
	
	$show->save();
