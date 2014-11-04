<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Model\EloquentPresenter;

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

            if ($assignment instanceof AssignmentModel) {

                $type = $assignment->type($this->resource);

                if ($type instanceof FieldType) {

                    return $type->decorate();
                }
            }
        }

        return parent::__get($key);
    }
    /*public function __get($key)
    {
        return $this->resource->getValueFromField($key);
    }*/
}
