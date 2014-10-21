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
}
