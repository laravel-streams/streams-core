<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Model\EloquentPresenter;

class AssignmentPresenter extends EloquentPresenter
{

    /**
     * Return the translated instructions string.
     *
     * @return string
     */
    public function instructions()
    {
        return trans($this->resource->instructions);
    }
}