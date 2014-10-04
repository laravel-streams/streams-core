<?php namespace Streams\Platform\Addon\FieldType;

use Streams\Platform\Addon\AddonPresenterAbstract;

class FieldTypePresenter extends AddonPresenterAbstract
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
     * By default return the value.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->resource->getValue();
    }
}