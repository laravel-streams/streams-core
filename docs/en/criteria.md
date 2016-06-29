# Criteria

- [Introduction](#introduction)
- [Basic Usage](#basic-usage)
	- [Fetching Results](#fetching-results)
	- [Finding Single Entry](#finding-single-entry)
	- [Creating Criteria](#creating-criteria)

<hr>

<a name="introduction"></a>
## Introduction

Model criteria help you build flexible queries within views. Think of model criteria as a wrapper for Eloquent's query builder.

<hr>

<a name="basic-usage"></a>
## Basic Usage

When the `entry` or `entries` plugin functions are invoked a model criteria is returned.  You can then restrict entries by value, order them, and call custom criteria methods.

    {% verbatim %}
    {# Get all sale products. #}
    {% set results = entries('store', 'products').where('sale', true).get() %}

    {# Get paginated sale products. #}
    {% set results = entries('store', 'products').where('sale', true).paginate(15) %}

    {# Get the most expensive product. #}
    {% set product = entry('store', 'products').orderBy('price', 'DESC').get() %}

    {# Get a custom paginated set of products defined in ProductModel's criteria class. #}
    {% set results = entries('store', 'products').favorites().orderBy('price', 'DESC').paginate(15) %}
    {% endverbatim %}

<div class="alert alert-danger">
<strong>Important:</strong> Model criteria do not allow you to modify records.
</div>

<a name="returning-collections"></a>
### Returning Collections

The following methods can be used with the `entries` method to fetch a collection of entries.

#### `get($columns = ['*'])`

Get all matching entries. Returns the entry model's collection.

#### `paginate($perPage = 15, $columns = ['*'])`

Get all matching entries. Returns a `LengthAwarePaginator`.

<a name="finding-single-entry"></a>
### Returning Single Entry

The following methods can be used with the `entry` method to fetch a single record. If no entry is found `null` is returned.

#### `find($identifier, $columns = ['*'])`

Find an entry by ID.

#### `findBy($where, $value, $columns = ['*'])`

Find an entry a column value.

#### `first($columns = ['*'])`

Return the first matched entry.

<div class="alert alert-primary">
<strong>Note:</strong> Criteria results are always decorated. The entry function will return a single presenter and entries will return a collection of presenters.
</div>

<a name="creating-criteria"></a>
### Creating Criteria

In order to make custom methods methods like `favorites()` in the example above available, you must create a criteria class for the desired model.

The criteria class name is returned by the model's `getCriteriaName()` method. By default criteria is a simple class transformation of the model:

    ProductModel becomes ProductCriteria
    FooBarModel becomes FooBarCriteria

All you have to do to get started is create your criteria class:

    <?php namespace Anomaly\StoreModule\Product;

    use Anomaly\Streams\Platform\Entry\EntryCriteria;

    class ProductCriteria extends EntryCriteria
    {

        public function favorites($user = null)
        {
            $user = $user ?: \Auth::user();

            $this->query->join('favorites', 'favorites.product_id', '=', 'store_products.id');
            $this->query->where('favorites.user_id', $user->id);

            return $this;
        }
    }

**Note that criteria methods must _always_ return `$this`.**

<div class="alert alert-primary">
<strong>Pro Tip:</strong> Model criteria are resolved out of the service container so feel free to override the construct and inject other services!
</div>