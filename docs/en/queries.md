# Query Builder

- [Introduction](#introduction)
    - [Basic Usage](#basic-usage)

<hr>

<a name="introduction"></a>
## Introduction

Query builders in PyroCMS work exactly the same as [query builders in Laravel](https://laravel.com/docs/5.1/controllers).

<a name="basic-usage"></a>
### Basic Usage

Entry model's return an instance of the `EntryQueryBuilder` which comes with a few extra features.

##### Sortable stream entries

If your stream is `sortable` than the entries will be returned by `sort_order` by default.

##### Caching query results

You can easily cache entries by using the `cache` method when building queries.

    public function findAllAwesome()
    {
        return $this->model
            ->where('awesome', true)
            ->cache(60)
            ->get(); // Cache for 60 seconds.
    }

##### Auto-caching query results

You can also tell your model to automatically cache all unique queries by setting the `$ttl` property on your model. 

<div class="alert alert-info">
<strong>Note:</strong> Cache is automatically cleared for a model when any of it's records is changed. 
</div>

##### Forcing fresh results

You can force the query builder to bypass cache if needed by using the `fresh` method.

    return $this->model
        ->where('awesome', true)
        ->fresh()
        ->get();
