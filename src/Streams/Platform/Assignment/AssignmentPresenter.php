<?php namespace Streams\Platform\Assignment;

use Streams\Platform\Model\EloquentPresenter;

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