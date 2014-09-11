<?php namespace Streams\Core\Field\Presenter;

use Streams\Core\Model\Presenter\EloquentPresenter;

class FieldPresenter extends EloquentPresenter
{
    /**
     * Return the type attribute.
     *
     * @param $type
     * @return \AddonAbstract
     */
    public function type()
    {
        return $this->resource->type;
    }

    /**
     * Return the translated field name property.
     *
     * @return string
     */
    public function name()
    {
        return trans($this->resource->name);
    }
}