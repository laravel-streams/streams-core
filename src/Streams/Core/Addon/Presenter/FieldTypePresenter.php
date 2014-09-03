<?php namespace Streams\Core\Addon\Presenter;


class FieldTypePresenter extends AddonPresenter
{
    /**
     * Return the assignment object.
     *
     * @return mixed
     */
    public function assignment()
    {
        return $this->resource->getAssignment();
    }

    /**
     * Return the entry object.
     *
     * @return mixed
     */
    public function entry()
    {
        return $this->resource->getEntry();
    }

    /**
     * Return the input.
     *
     * @return mixed
     */
    public function input()
    {
        return $this->resource->input();
    }

    /**
     * By default return the value.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->resource->value();
    }
}
