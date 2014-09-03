<?php namespace Streams\Core\Entry\Presenter;

use Streams\Core\Model\Presenter\EloquentPresenter;

class EntryPresenter extends EloquentPresenter
{
    public function __get($key)
    {
        if ( /*!method_exists($this, $key) and */
        isset($this->resource->{$key})
        ) {
            $decorator  = \App::make('McCool\LaravelAutoPresenter\PresenterDecorator');
            $assignment = $this->resource->getStream()->assignments->findBySlug($key);

            if ($assignment) {
                $type       = $assignment->field->type->setAssignment($assignment)->setEntry($this->resource);
                return $decorator->decorate($type);
            }
        }

        return parent::__get($key);
    }
}
