<?php namespace Anomaly\Streams\Platform\Collection;

use Illuminate\Database\Eloquent\Collection;

class EloquentCollection extends Collection
{
    /**
     * Create a new EloquentCollection instance.
     * Decorate models on the way in.
     *
     * @param array $models
     */
    public function __construct($models = [])
    {
        foreach ($models as &$model) {

            $model = app('streams.decorator')->decorate($model);

        }

        return parent::__construct($models);
    }

    /**
     * Return an item by it's slug.
     * This is very common so let's do it!
     *
     * @param $slug
     * @return null
     */
    public function findBySlug($slug)
    {
        $match = null;

        foreach ($this->items as $item) {

            if ($item->slug == $slug) {

                $match = $item;

            }

        }

        return $match;
    }
}
