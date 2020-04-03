<?php

namespace Anomaly\Streams\Platform\Addon\FieldType\Concerns;

use Illuminate\Support\Collection;

/**
 * Trait HasValue
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasValue
{

    /**
     * The field value.
     *
     * @var null|mixed
     */
    protected $value = null;

    /**
     * Set the value.
     *
     * @param  $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Return if the type
     * has a value or not.
     *
     * @return bool
     */
    public function hasValue()
    {
        $value = $this->getValue();

        if ($value == '') {
            return false;
        }

        if ($value === null) {
            return false;
        }

        if ($value instanceof Collection) {
            return $value->isNotEmpty();
        }

        return true;
    }
}
