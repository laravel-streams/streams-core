<?php namespace Streams\Platform\Entry\Presenter;

use Streams\Platform\Model\Presenter\EloquentPresenter;

class EntryPresenter extends EloquentPresenter
{
    public function __get($key)
    {
        if ( /*!method_exists($this, $key) and */
        $assignment = $this->resource->findAssignmentByFieldSlug($key)
        ) {
            if ($assignment) {
                $type = $assignment->field->type
                    ->setAssignment($assignment)
                    ->setEntry($this->resource)
                    ->setValue($this->resource->{$assignment->field->slug});

                return \Decorator::decorate($type);
            }
        }

        return parent::__get($key);
    }
}
