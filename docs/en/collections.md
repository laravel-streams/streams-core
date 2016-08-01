# Collections

- [Introduction](#introduction)
	- [Entry Collections](#entry-collections)

<hr>

<a name="introduction"></a>
## Introduction

Collections in PyroCMS work exactly the same as [collections in Laravel](https://laravel.com/docs/5.1/collections).

PyroCMS comes with `\Anomaly\Streams\Platform\Support\Collection` that extends Laravel's base collection.

    {% verbatim %}
    $shuffled = $collection->shuffle(); // Shuffles items randomly
    
    $new = $collection->skip(5); // Alias for offset($offset, null, true);
    {% endverbatim %}

<a name="entry-collections"></a>
### Entry Collections

Entry models return an instance of `Anomaly\Streams\Platform\Entry\EntryCollection` by default.

You can specify a custom collection for an entry model by simply placing the collection next to your model. Entry models automatically detect matching entry collections via class name transformation.

    {% verbatim %}
    Anomaly\PostsModule\Post\PostModel // Standard model naming convention
    Anomaly\PostsModule\Post\PostCollection // Detected automatically
    {% endverbatim %}

Your custom collection should extend the base `EntryCollection`.

    {% verbatim %}
    class PostCollection extends EntryCollection
    {
        public function customMethod()
        {
            // Your logic here...
        }
    }
    {% endverbatim %}

You can also override the `newCollection` method on your entry model in order to specify the collection to use.

    {% verbatim %}
    public function newCollection(array $items = [])
    {
        return new FancyCollection($items);
    }
    {% endverbatim %}
