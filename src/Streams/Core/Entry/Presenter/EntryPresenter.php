<?php namespace Streams\Core\Entry\Presenter;

use Streams\Core\Model\Presenter\EloquentPresenter;

class EntryPresenter extends EloquentPresenter
{
    public function __get($key)
    {
        if ( /*!method_exists($this, $key) and */
        $assignment = $this->resource->findAssignmentByFieldSlug($key)
        ) {
            $decorator  = \App::make('McCool\LaravelAutoPresenter\PresenterDecorator');

            if ($assignment) {
                $type = $assignment->field->type
                    ->setAssignment($assignment)
                    ->setEntry($this->resource)
                    ->setValue($this->resource->{$assignment->field->slug});

                return $decorator->decorate($type);
            }
        }

        return parent::__get($key);
    }
}
