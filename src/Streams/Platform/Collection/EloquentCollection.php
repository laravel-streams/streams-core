<?php namespace Streams\Platform\Collection;

use Illuminate\Database\Eloquent\Collection;

class EloquentCollection extends Collection
{
    /**
     * Create a new EloquentCollection instance.
     *
     * @param array $models
     */
    public function __construct($models)
    {
        foreach ($models as &$model) {
            $model = app('streams.decorator')->decorate($model);
        }

        return parent::__construct($models);
    }

    /**
     * Run delete on all the items individually.
     *
     * @return bool
     */
    public function delete()
    {
        foreach ($this->items as $item) {
            $item->delete();
        }

        return true;
    }
}
