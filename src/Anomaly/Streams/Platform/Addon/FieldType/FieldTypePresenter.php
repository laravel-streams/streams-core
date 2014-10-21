<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Addon\AddonPresenter;

class FieldTypePresenter extends AddonPresenter
{
    /**
     * By default return the set value.
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->resource->getValue();
    }
}