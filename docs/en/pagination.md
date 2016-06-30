# Pagination

- [Introduction](#introduction)
- [Basic Usage](#basic-usage)

<hr>

<a name="introduction"></a>
## Introduction

Pagination in PyroCMS works exactly the same as [pagination in Laravel](https://laravel.com/docs/5.1/pagination).

<a name="basic-usage"></a>
## Basic Usage

You can easily obtain pagination any way you normally would in Laravel. There are also a couple of additional built-in methods.

#### Repositories

All repositories provide a `paginate` method.

    $lengthAwarePaginator = app(PostRepositoryInterface::class)->paginate($parameters = []);

You can define a few parameters to customize the return.

- `per_page`: The number of entries to display on each page. Defaults to system configured value (15).
- `paginator`: The paginator to use - currently only `simple` or `null` (length aware) are supported.
- `scope`: A model scope method to start the query with.

#### Criteria

You can also paginate entry results when using the `entries` plugin function.

    {% verbatim %}
    {% results = entries('store', 'products').where('sale', true).paginate(25) %}

    {# Loop over your results #}
    ...

    {# Render pagination #}
    {{ results.render|raw }}
    {% endverbatim %}
