<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Addon\AddonPresenter;
use Anomaly\Streams\Platform\Contract\StringableInterface;

/**
 * Class FieldTypePresenter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldTypePresenter extends AddonPresenter implements StringableInterface
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

    /**
     * Return the instance as a string.
     *
     * @return mixed
     */
    public function toString()
    {
        return $this->resource->getValue();
    }

}