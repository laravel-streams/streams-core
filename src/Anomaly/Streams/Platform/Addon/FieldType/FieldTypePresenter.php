<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Addon\AddonPresenter;

class FieldTypePresenter extends AddonPresenter
{

    /**
     * By default return the value.
     * TODO: This can be dangerous if used in a loop!
     *       There is a PHP bug that caches it's
     *       output when used in a loop.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->resource->getValue();
    }

}