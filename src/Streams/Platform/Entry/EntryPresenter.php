<?php namespace Streams\Platform\Entry;

use Streams\Platform\Model\Presenter\EloquentPresenter;

class EntryPresenter extends EloquentPresenter
{
    /**
     * Wrap with a decorated field type if possible.
     *
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        if ($assignment = $this->resource->findAssignmentByFieldSlug($key)) {
            if ($assignment) {
                $type = $assignment->field->type->setValue($this->resource->{$assignment->field->slug});

                return app('streams.decorator')->decorate($type);
            }
        }

        return parent::__get($key);
    }
}
