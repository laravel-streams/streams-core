<?php namespace Streams\Core\Collection;

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
        $decorator = \App::make('McCool\LaravelAutoPresenter\PresenterDecorator');

        foreach ($models as &$model) {
            $model = $decorator->decorate($model);
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
