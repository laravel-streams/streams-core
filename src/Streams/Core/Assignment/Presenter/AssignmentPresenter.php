<?php namespace Streams\Platform\Assignment\Presenter;

use Streams\Platform\Model\Presenter\EloquentPresenter;

class AssignmentPresenter extends EloquentPresenter
{
    /**
     * Return the translated instructions string.
     *
     * @return string
     */
    public function instructions()
    {
        return \Lang::has($this->resource->instructions) ? trans($this->resource->instructions) : null;
    }
}