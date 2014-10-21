<?php namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Model\EloquentPresenter;

class FieldPresenter extends EloquentPresenter
{
    /**
     * Return the type attribute.
     *
     * @return mixed
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