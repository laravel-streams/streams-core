<?php namespace Streams\Core\Addon\Presenter;


use Streams\Core\Addon\FieldTypeAbstract;

class FieldTypePresenter extends AddonPresenter
{
    /**
     * Create a new FieldTypePresenter instance.
     *
     * @param FieldTypeAbstract $resource
     */
    public function __construct(FieldTypeAbstract $resource) {
        $this->resource = $resource;
    }

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
